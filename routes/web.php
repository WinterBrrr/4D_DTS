<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Document;
use App\Models\Department;
use App\Models\DocumentType;
use App\Models\UserProfile;
use App\Models\ActivityLog;
use App\Models\AppSetting;
use App\Support\Totp;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::middleware('web')->group(function () {
    // Public routes
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', function () {
        if (Session::get('logged_in') === true) {
            // Check user role and redirect accordingly
            $userRole = Session::get('user_role', 'user');
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Reset session to avoid role leakage between logins
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        // Authenticate user by email and password
        $user = \App\Models\User::where('email', $validated['email'])->first();
        if (!$user || !\Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
        // Block login if user status is 'pending'
        if ($user->status === 'pending') {
            return back()->withErrors(['email' => 'Your account is pending approval by an administrator.'])->withInput();
        }
        $userRole = $user->role ?? 'user';

        // Log in using Laravel Auth
        Auth::login($user);

        // Load profile for nicer display name
        $profile = \App\Models\UserProfile::where('user_id', $user->id)->first();

        // Save session (for legacy code/UI)
        Session::put('logged_in', true);
        Session::put('user_email', $user->email);
        Session::put('user_role', $userRole);
        Session::put('user_name', $profile->nickname ?? $user->name ?? 'User');

        // Log login
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'details' => ['email' => $user->email, 'role' => $userRole],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // If admin and 2FA enabled, require TOTP challenge first
        if ($userRole === 'admin') {
            $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
            if ($profile->two_factor_enabled && !session('2fa_verified')) {
                Session::put('2fa_user_id', $user->id);
                return redirect('/2fa');
            }
            return redirect()->route('admin.dashboard');
        }
        // Auditor role: redirect to auditor dashboard
        if ($userRole === 'auditor') {
            return redirect()->route('auditor.dashboard');
        }
        // Teachers, students, handlers use the regular user dashboard
        return redirect()->route('dashboard');
    })->name('login.attempt');

    // POST /logout removed; using Route::any('/logout') below.

    // Fallback: allow ANY /logout (covers GET and POST) to avoid 419/404
    Route::any('/logout', function () {
        Session::forget(['logged_in', 'user_email', 'user_role', 'user_name']);
        Session::flush();
        return redirect()->route('login');
    })->withoutMiddleware([VerifyCsrfToken::class])->name('logout');

    // UI helper routes to prevent broken links from layout
    Route::get('/privacy', function () {
        return view('legal.privacy');
    })->name('privacy');

    Route::get('/terms', function () {
        return view('legal.terms');
    })->name('terms');

    // Admin workflow stage setter: pending|initial|under|final|completed
    Route::get('/admin/workflow/{stage}', function (string $stage) {
        $stage = strtolower($stage);
        Session::put('workflow_stage', $stage);
        $map = [
            'pending' => 'admin.pending',
            'initial' => 'admin.initial',
            'under' => 'admin.under',
            'final' => 'admin.final',
            'completed' => 'admin.completed',
        ];
        $target = $map[$stage] ?? 'admin.pending';
        return redirect()->route($target);
    })->name('admin.workflow.set');

    Route::get('/support', function () {
        return view('support');
    })->name('support');

    // Provide a settings link target; redirect to admin settings if admin, else dashboard
    Route::get('/settings', function () {
        if (Session::get('user_role') === 'admin') {
            return redirect()->route('admin.settings');
        }
        return redirect()->route('dashboard');
    })->name('settings');

    // Profile page
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

        // Extra route for /profile/show
        Route::get('/profile/show', function () {
            return view('profile.show');
        });


    // Password reset and registration
    Route::get('/password/reset', function () {
        return redirect('/login')->with('info', 'Password reset not yet implemented. Contact support.');
    })->name('password.request');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:student,teacher,handler,auditor'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Map teacher/student to 'user', handler to 'handler', auditor to 'auditor'
        $role = $validated['role'] === 'handler' ? 'handler' : ($validated['role'] === 'auditor' ? 'auditor' : 'user');


        $userStatus = ($role === 'admin') ? 'registered' : 'pending';
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $role,
            'password' => \Hash::make($validated['password']),
            'status' => $userStatus,
        ]);

        // Optionally create a profile
        \App\Models\UserProfile::create([
            'user_id' => $user->id,
            'nickname' => $validated['name'],
        ]);

        // Log registration
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'register',
            'details' => ['email' => $user->email, 'role' => $user->role],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

    // Do not auto-login. Redirect to login with info message
    return redirect()->route('login')->with('info', 'Registration successful! Your account is pending approval by an administrator. You will be able to log in once approved.');
    })->name('register.attempt');

    // 2FA challenge (shown after admin login when enabled)
    Route::get('/2fa', function () {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa');
    })->name('2fa.show');

    Route::post('/2fa', function (Request $request) {
        $request->validate(['code' => ['required','digits:6']]);
        $userId = session('2fa_user_id');
        if (!$userId) return redirect()->route('login');
        $profile = UserProfile::firstOrCreate(['user_id' => $userId]);
        if (!$profile->two_factor_enabled || empty($profile->two_factor_secret)) {
            // No 2FA actually required
            session()->forget('2fa_user_id');
            session(['2fa_verified' => true]);
            return redirect()->route('admin.dashboard');
        }
        $ok = Totp::verify($profile->two_factor_secret, $request->input('code'));
        if (!$ok) {
            return back()->withErrors(['code' => 'Invalid code. Try again.']);
        }
        session()->forget('2fa_user_id');
        session(['2fa_verified' => true]);
        return redirect()->route('admin.dashboard');
    })->name('2fa.verify');

    // Protected user routes
    Route::middleware([\App\Http\Middleware\CheckAuth::class])->group(function () {
    // Auditor status guide page
    Route::get('/auditor/status-guide', function () {
        return view('auditor.status_guide');
    })->name('auditor.status.guide');

    // Auditor profile page
    Route::get('/auditor/profile', function () {
        return view('auditor.profile');
    })->name('auditor.profile.show');
    // Handler document actions
    Route::post('/handler/documents/{id}/review', [\App\Http\Controllers\HandlerController::class, 'reviewDocument'])->name('handler.documents.review');
    Route::post('/handler/documents/{id}/comment', [\App\Http\Controllers\HandlerController::class, 'addComment'])->name('handler.documents.comment');
    Route::post('/handler/documents/{id}/forward', [\App\Http\Controllers\HandlerController::class, 'forwardDocument'])->name('handler.documents.forward');
    Route::post('/handler/documents/{id}/update-timeline', [\App\Http\Controllers\HandlerController::class, 'updateTimeline'])->name('handler.documents.updateTimeline');
    // Handler dashboard route
    Route::get('/handler/dashboard', function (Request $request) {
        // Example stats and recent activity for handler dashboard
        $user = Auth::user();
        $stats = [
            'assigned' => \App\Models\Document::where('handler', $user->name)->count(),
            'pending' => \App\Models\Document::where('handler', $user->name)->where('status', 'pending')->count(),
            'completed' => \App\Models\Document::where('handler', $user->name)->where('status', 'completed')->count(),
        ];
        $documents = \App\Models\Document::where('handler', $user->name)->orderByDesc('updated_at')->get();
        return view('handler.dashboard', compact('stats', 'documents'));
    })->name('handler.dashboard');
    // Auditor dashboard route
    Route::get('/auditor/dashboard', function (Request $request) {
        // Example stats and recent activity for auditor dashboard
        $stats = [
            'total' => \App\Models\Document::count(),
            'pending' => \App\Models\Document::where('status', 'pending')->count(),
            'completed' => \App\Models\Document::where('status', 'completed')->count(),
        ];
        $recentActivity = \App\Models\Document::orderByDesc('updated_at')->limit(3)->get()->map(function ($d) {
            return [
                'title' => $d->title ?? $d->code ?? 'Untitled',
                'uploaded_at' => $d->updated_at ? $d->updated_at->diffForHumans() : '-',
            ];
        })->toArray();
        return view('auditor.dashboard', compact('stats', 'recentActivity'));
    })->name('auditor.dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        // Status Guide page for users
        Route::get('/status-guide', function () {
            return view('status_info');
        })->name('status.guide');


        Route::get('/upload', [DocumentController::class, 'create'])->name('upload');
        Route::post('/upload', [DocumentController::class, 'store'])->name('upload.store');

        // Inspect document details
        Route::get('/inspect/{document}', [DocumentController::class, 'inspect'])->name('inspect');

        // Profile: update personal info (saved to user_profiles)
        Route::post('/profile', function (Request $request) {
            $validated = $request->validate([
                'nickname' => ['nullable','string','max:255'],
                'identity' => ['nullable','in:Teacher,Student'],
                'full_name' => ['nullable','string','max:255'],
                'email' => ['nullable','email'],
                'age' => ['nullable','integer','min:1','max:120'],
                'occupation' => ['nullable','string','max:255'],
                'nationality' => ['nullable','string','max:255'],
                'contact_number' => ['nullable','string','max:255'],
                'address' => ['nullable','string','max:500'],
                'gender' => ['nullable','in:Male,Female'],
            ]);

            $user = User::where('email', Session::get('user_email'))->first();
            // If no DB user exists (because login is session-based), create one on-the-fly
            if (!$user) {
                $user = User::create([
                    'name' => Session::get('user_name', 'User'),
                    'email' => Session::get('user_email'),
                    'password' => bcrypt(Str::random(24)),
                    'role' => Session::get('user_role', 'user'),
                ]);
            }
            if ($user) {
                // Persist name/email on users table
                $user->fill([
                    'name' => $validated['full_name'] ?? $user->name,
                    'email' => $validated['email'] ?? $user->email,
                ])->save();
                Session::put('user_email', $user->email);
                Session::put('user_name', $user->name);

                // Persist personal info on user_profiles
                $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
                $profile->fill([
                    'nickname' => $validated['nickname'] ?? $profile->nickname,
                    'identity' => $validated['identity'] ?? $profile->identity,
                    'age' => $validated['age'] ?? $profile->age,
                    'occupation' => $validated['occupation'] ?? $profile->occupation,
                    'nationality' => $validated['nationality'] ?? $profile->nationality,
                    'contact_number' => $validated['contact_number'] ?? $profile->contact_number,
                    'address' => $validated['address'] ?? $profile->address,
                    'gender' => $validated['gender'] ?? $profile->gender,
                ])->save();

                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'profile.update',
                    'details' => ['nickname' => $profile->nickname, 'identity' => $profile->identity],
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
            return back()->with('success', 'Profile updated');
        })->name('profile.update');

        // Profile: upload photo -> save to user_profiles.profile_photo_path
        Route::post('/profile/photo', function (Request $request) {
            $request->validate(['photo' => ['required','image','max:2048']]);
            $user = User::where('email', Session::get('user_email'))->first();
            if (!$user) {
                $user = User::create([
                    'name' => Session::get('user_name', 'User'),
                    'email' => Session::get('user_email'),
                    'password' => bcrypt(Str::random(24)),
                    'role' => Session::get('user_role', 'user'),
                ]);
            }
            if ($user) {
                $path = $request->file('photo')->store('profiles', 'public');
                // Save to user_profiles
                $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
                $profile->profile_photo_path = $path;
                $profile->save();
                // Also keep a session fallback so UI can show immediately
                Session::put('profile_photo_path', $path);

                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'profile.photo.upload',
                    'details' => ['path' => $path],
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
            return back()->with('success', 'Profile photo updated');
        })->name('profile.photo');

        // Profile: stream photo (works even without storage:link)
        Route::get('/profile/photo', function () {
            $path = null;
            $user = User::where('email', Session::get('user_email'))->first();
            if ($user && Schema::hasColumn('users', 'profile_photo_path') && $user->profile_photo_path) {
                $path = $user->profile_photo_path;
            }
            // Fallback to session if DB not yet updated
            if (!$path) {
                $path = Session::get('profile_photo_path');
            }
            if (!$path || !Storage::disk('public')->exists($path)) {
                abort(404);
            }
            return Storage::disk('public')->response($path);
        })->name('profile.photo.show');

        // Documents: export CSV
        Route::get('/documents/export', function () {
            $filename = 'documents_'.date('Ymd_His').'.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];
            $callback = function () {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['code','title','type','handler','department','status','expected_completion_at']);
                Document::orderBy('id')->chunk(200, function ($chunk) use ($out) {
                    foreach ($chunk as $d) {
                        fputcsv($out, [$d->code,$d->title,$d->type,$d->handler,$d->department,$d->status,$d->expected_completion_at]);
                    }
                });
                fclose($out);
            };
            return response()->stream($callback, 200, $headers);
        })->name('documents.export');

        // Documents: import CSV
        Route::post('/documents/import', function (Request $request) {
            $request->validate(['csv' => ['required','file','mimes:csv,txt']]);
            $path = $request->file('csv')->getRealPath();
            $h = fopen($path, 'r');
            $header = fgetcsv($h);
            $count = 0;
            while (($row = fgetcsv($h)) !== false) {
                [$code,$title,$type,$handler,$department,$status,$expected] = array_pad($row, 7, null);
                if (!$code) continue;
                Document::updateOrCreate(['code' => $code], [
                    'title' => $title,
                    'type' => $type,
                    'handler' => $handler,
                    'department' => $department,
                    'status' => $status,
                    'expected_completion_at' => $expected,
                ]);
                $count++;
            }
            fclose($h);
            ActivityLog::create([
                'user_id' => optional(User::where('email', Session::get('user_email'))->first())->id,
                'action' => 'documents.import',
                'details' => ['count' => $count],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return back()->with('success', 'Documents imported');
        })->name('documents.import');
    });

    // Admin routes with proper protection
    Route::prefix('admin')->name('admin.')->middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Approve user
    Route::post('/users/{id}/approve', [\App\Http\Controllers\AdminController::class, 'approveUser'])->name('users.approve');
    // Reject user
    Route::post('/users/{id}/reject', [\App\Http\Controllers\AdminController::class, 'rejectUser'])->name('users.reject');
        
        // Dashboard (persistent stats from documents table)
        Route::get('/dashboard', function () {
            $stats = [
                'pending' => \App\Models\Document::where('status', 'pending')->count(),
                'reviewing' => \App\Models\Document::where('status', 'reviewing')->count(),
                'completed' => \App\Models\Document::where('status', 'completed')->count(),
                'total' => \App\Models\Document::count(),
            ];

            $last = \App\Models\Document::orderByDesc('updated_at')->first()
                ?? \App\Models\Document::orderByDesc('id')->first();
            $stats['lastAccessedTitle'] = $last?->title ?? '—';

            $recentActivity = \App\Models\Document::orderByDesc('updated_at')->limit(3)->get();
            $docs = \App\Models\Document::orderByDesc('id')->get();

            return view('admin.dashboard', compact('stats', 'recentActivity', 'docs'));
        })->name('dashboard');

        // Document workflow pages - FIXED ROUTE NAMES
        Route::get('/pending', [App\Http\Controllers\AdminController::class, 'pending'])->name('pending');

        // FIXED: Changed from '/initial-review' to '/initial'
        Route::get('/initial/{document?}', function ($document = null) {
            $documents = Session::get('uploaded_documents', []);
            $currentDocument = null;
            
            if ($document) {
                $currentDocument = collect($documents)->firstWhere('id', (int)$document);
            }
            
            return view('admin.initial', compact('currentDocument'));
        })->name('initial');

        // FIXED: Changed from '/under-review' to '/under'
        Route::get('/under/{document?}', function ($document = null) {
            $documents = Session::get('uploaded_documents', []);
            $currentDocument = null;
            
            if ($document) {
                $currentDocument = collect($documents)->firstWhere('id', (int)$document);
            }
            
            return view('admin.under', compact('currentDocument'));
        })->name('under');

        // FIXED: Changed from '/final-processing' to '/final'
        Route::get('/final/{document?}', function ($document = null) {
            $documents = Session::get('uploaded_documents', []);
            $currentDocument = null;
            
            if ($document) {
                $currentDocument = collect($documents)->firstWhere('id', (int)$document);
            }
            
            return view('admin.final', compact('currentDocument'));
        })->name('final');

        Route::get('/completed', function () {
            $documents = Session::get('uploaded_documents', []);
            $completedDocuments = collect(array_filter($documents, fn($d) => $d['status'] === 'completed'));
            
            return view('admin.completed', compact('completedDocuments'));
        })->name('completed');

        // Documents list (persistent, visible to admin)
        Route::get('/documents', function () {
            $documents = \App\Models\Document::orderByDesc('id')->paginate(10);
            return view('admin.documents', compact('documents'));
        })->name('documents.index');

        // Maintenance mode controls (admin only)
        Route::post('/maintenance/down', function (Request $request) {
            $secret = $request->input('secret', 'admin-secret');
            $retry  = (int) $request->input('retry', 5);
            Artisan::call('down', [
                '--secret' => $secret,
                '--retry' => $retry,
            ]);
            return back()->with('success', "Maintenance mode enabled. Bypass: /{$secret}");
        })->name('maintenance.down');

        Route::post('/maintenance/up', function () {
            Artisan::call('up');
            return back()->with('success', 'Maintenance mode disabled.');
        })->name('maintenance.up');

        // Activity list
        Route::get('/activity', function () {
            $logs = ActivityLog::with('user')->orderByDesc('created_at')->paginate(20);
            return view('admin.activity', compact('logs'));
        })->name('activity');

        // 2FA Setup for admins
        Route::get('/2fa/setup', function () {
            $user = User::where('email', Session::get('user_email'))->first();
            if (!$user) return redirect()->route('admin.dashboard');
            $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
            if (empty($profile->two_factor_secret)) {
                $profile->two_factor_secret = Totp::generateSecret();
                $profile->save();
            }
            $qrUri = Totp::otpauthUri('4DOCS', $user->email, $profile->two_factor_secret);
            return view('admin.2fa-setup', compact('profile', 'qrUri'));
        })->name('2fa.setup');

        Route::post('/2fa/enable', function (Request $request) {
            $request->validate(['code' => ['required','digits:6']]);
            $user = User::where('email', Session::get('user_email'))->first();
            if (!$user) return back()->withErrors(['code' => 'User not found.']);
            $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
            if (empty($profile->two_factor_secret)) {
                return back()->withErrors(['code' => 'No secret configured. Visit setup first.']);
            }
            $ok = Totp::verify($profile->two_factor_secret, $request->input('code'));
            if (!$ok) {
                return back()->withErrors(['code' => 'Invalid code. Try again.']);
            }
            $profile->two_factor_enabled = true;
            $profile->save();
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'admin.2fa.enable',
                'details' => [],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return back()->with('success', '2FA enabled successfully!');
        })->name('2fa.enable');

        Route::post('/2fa/disable', function (Request $request) {
            $user = User::where('email', Session::get('user_email'))->first();
            if (!$user) return back();
            $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
            $profile->two_factor_enabled = false;
            $profile->save();
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'admin.2fa.disable',
                'details' => [],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return back()->with('success', '2FA disabled.');
        })->name('2fa.disable');

        // Document management routes
        Route::get('/documents/{document}', function ($document) {
            $doc = \App\Models\Document::findOrFail($document);
            return view('admin.document', ['document' => $doc]);
        })->name('documents.show');

        Route::post('/documents', function (Request $request) {
            $validated = $request->validate([
                'final_title' => ['required', 'string', 'max:255'],
                'version' => ['nullable', 'string', 'max:50'],
                'final_description' => ['nullable', 'string'],
                'tags' => ['nullable', 'string'],
                'access_level' => ['required', 'in:public,internal,restricted,confidential'],
                'document_file' => ['required', 'file', 'mimes:pdf,doc,docx,txt,xlsx,pptx', 'max:10240']
            ]);

            $file = $request->file('document_file');
            $filename = time() . '_final_' . $file->getClientOriginalName();
            $path = $file->storeAs('final_documents', $filename, 'local');

            return redirect()->route('admin.completed')->with('success', 'Document finalized and submitted successfully!');
        })->name('documents.store');

        // Workflow proceed endpoints - FIXED to handle integer conversion
        Route::post('/proceed/{step}', function (Request $request, string $step) {
            $document = $request->input('document');
            $action = $request->input('action', 'proceed');
            
            // Update document status in session
            if ($document) {
                $documents = Session::get('uploaded_documents', []);
                foreach ($documents as &$doc) {
                    if ($doc['id'] == (int)$document) {
                        switch ($step) {
                            case 'pending':
                            case 'initial':
                                $doc['status'] = ($action === 'proceed') ? 'reviewing' : 'pending';
                                break;
                            case 'under':
                                $doc['status'] = ($action === 'approve') ? 'final_processing' : 
                                               (($action === 'reject') ? 'pending' : 'reviewing');
                                break;
                            case 'final':
                                $doc['status'] = ($action === 'proceed') ? 'completed' : 'final_processing';
                                break;
                        }
                        break;
                    }
                }
                Session::put('uploaded_documents', $documents);
            }

            // Route mapping with document parameter
            $routeMap = [
                'pending' => 'admin.initial',
                'initial' => 'admin.under',
                'under' => ($action === 'approve') ? 'admin.final' : 
                          (($action === 'reject') ? 'admin.pending' : 'admin.under'),
                'final' => 'admin.completed',
            ];
            
            $nextRoute = $routeMap[$step] ?? 'admin.pending';
            
            // Add document parameter if moving forward
            if ($document && !in_array($action, ['reject'])) {
                return redirect()->route($nextRoute, ['document' => $document]);
            }
            
            return redirect()->route($nextRoute);
        })->name('proceed');

        // Additional admin routes
        Route::get('/upload', function () {
            return view('admin.upload');
        })->name('upload');

        Route::get('/reports', function () {
            // Totals
            $totalDocs = Document::count();

            // Average process time in days for completed docs
            $avgDays = 0;
            try {
                $avgSeconds = Document::where('status', 'completed')
                    ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds')
                    ->value('avg_seconds');
                if ($avgSeconds) {
                    $avgDays = round(((float)$avgSeconds) / 86400, 1);
                }
            } catch (\Throwable $e) {
                $avgDays = 0;
            }

            // Month over month document count change
            $thisMonth = Document::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
            $lastMonth = Document::whereBetween('created_at', [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()])->count();
            $monthChange = '0%';
            if ($lastMonth > 0) {
                $pct = round((($thisMonth - $lastMonth) / $lastMonth) * 100);
                $monthChange = ($pct >= 0 ? '+' : '') . $pct . '%';
            }

            // Active users in the last 30 days from activity logs
            $activeUsers = ActivityLog::where('created_at', '>=', now()->subDays(30))
                ->distinct('user_id')->count('user_id');

            $totals = [
                'documents' => $totalDocs,
                'avg_process_time_days' => $avgDays,
                'month_change' => $monthChange,
                'active_users' => $activeUsers,
            ];

            // Status distribution
            $rawStatus = Document::select('status', DB::raw('COUNT(*) as c'))
                ->groupBy('status')->pluck('c', 'status');
            $labelMap = [
                'pending' => 'Pending',
                'reviewing' => 'Under Review',
                'final_processing' => 'Final Processing',
                'completed' => 'Completed',
            ];
            $statusCounts = [];
            foreach ($rawStatus as $k => $v) {
                $label = $labelMap[$k] ?? ucfirst(str_replace('_', ' ', (string)$k));
                $statusCounts[$label] = (int) $v;
            }
            ksort($statusCounts);
            $colors = [
                'Pending' => '#eab308',
                'Under Review' => '#3b82f6',
                'Final Processing' => '#a855f7',
                'Completed' => '#22c55e',
            ];

            // Department counts (top 5)
            $departmentCounts = Document::select('department', DB::raw('COUNT(*) as c'))
                ->whereNotNull('department')
                ->groupBy('department')
                ->orderByDesc('c')
                ->limit(5)
                ->pluck('c', 'department')
                ->toArray();

            // Recent processing activity: last 5 updated documents
            $recentDocs = Document::orderByDesc('updated_at')->limit(5)->get();
            $recent = $recentDocs->map(function ($d) use ($labelMap) {
                $label = $labelMap[$d->status] ?? ucfirst(str_replace('_', ' ', (string)$d->status));
                return [
                    'title' => $d->title ?? $d->code ?? 'Untitled',
                    'department' => $d->department ?? '-',
                    'status' => $label,
                    'updated' => $d->updated_at ? $d->updated_at->diffForHumans() : '-',
                    'user' => '-',
                ];
            })->toArray();

            return view('admin.reports', compact('totals', 'statusCounts', 'departmentCounts', 'recent', 'colors'));
        })->name('reports');


        // Admin: All Users page
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');

        // Admin: View user details
        Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'showUser'])->name('users.show');

        // Admin: Delete user
        Route::delete('/users/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');

        // Create user (admin User Management: Add User)
        Route::post('/users', function (Request $request) {
            $data = $request->validate([
                'name' => ['required','string','max:255'],
                'email' => ['required','email','max:255','unique:users,email'],
                'role' => ['required','in:admin,user'],
                'nickname' => ['nullable','string','max:255'],
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => bcrypt(Str::random(16)),
            ]);

            if (!empty($data['nickname'])) {
                $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
                $profile->nickname = $data['nickname'];
                $profile->save();
            }

            ActivityLog::create([
                'user_id' => optional(User::where('email', Session::get('user_email'))->first())->id,
                'action' => 'admin.user.create',
                'details' => ['user_id' => $user->id, 'email' => $user->email, 'role' => $user->role],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()->with('success', 'User added successfully');
        })->name('users.store');

        Route::get('/settings', function () {
            $settings = [
                'two_factor_required' => AppSetting::getBool('two_factor_required', true),
                'sms_notifications' => AppSetting::getBool('sms_notifications', false),
                'daily_summary_reports' => AppSetting::getBool('daily_summary_reports', true),
            ];
            return view('admin.settings', compact('settings'));
        })->name('settings');

        // Save notification settings
        Route::post('/settings/notifications', function (Request $request) {
            AppSetting::setBool('two_factor_required', $request->boolean('two_factor_required'));
            AppSetting::setBool('sms_notifications', $request->boolean('sms_notifications'));
            AppSetting::setBool('daily_summary_reports', $request->boolean('daily_summary_reports'));
            
            ActivityLog::create([
                'user_id' => optional(User::where('email', Session::get('user_email'))->first())->id,
                'action' => 'admin.settings.save',
                'details' => [
                    'two_factor_required' => $request->boolean('two_factor_required'),
                    'sms_notifications' => $request->boolean('sms_notifications'),
                    'daily_summary_reports' => $request->boolean('daily_summary_reports'),
                ],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return back()->with('success', 'Notification settings saved successfully.');
        })->name('settings.notifications');

        // Export data
        Route::post('/export', function (Request $request) {
            set_time_limit(120); // Allow up to 2 minutes for large exports
            
            $filename = 'export_' . date('Ymd_His') . '.zip';
            $tempPath = storage_path('app/temp/' . $filename);
            
            // Create temp directory if it doesn't exist
            if (!file_exists(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }
            
            $zip = new \ZipArchive();
            if ($zip->open($tempPath, \ZipArchive::CREATE) === TRUE) {
                // Export users - optimized with chunk
                $usersCsv = "ID,Name,Email,Role,Created At,Nickname\n";
                User::with('profile')->chunk(100, function($users) use (&$usersCsv) {
                    foreach ($users as $user) {
                        $usersCsv .= sprintf("%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                            $user->id,
                            str_replace('"', '""', $user->name),
                            $user->email,
                            $user->role,
                            $user->created_at,
                            str_replace('"', '""', optional($user->profile)->nickname ?? '')
                        );
                    }
                });
                $zip->addFromString('users.csv', $usersCsv);
                
                // Export documents - optimized with chunk
                $docsCsv = "ID,Code,Title,Type,Handler,Department,Status,Created At\n";
                Document::select('id', 'code', 'title', 'type', 'handler', 'department', 'status', 'created_at')
                    ->chunk(200, function($documents) use (&$docsCsv) {
                    foreach ($documents as $doc) {
                        $docsCsv .= sprintf("%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                            $doc->id,
                            str_replace('"', '""', $doc->code ?? ''),
                            str_replace('"', '""', $doc->title ?? ''),
                            str_replace('"', '""', $doc->type ?? ''),
                            str_replace('"', '""', $doc->handler ?? ''),
                            str_replace('"', '""', $doc->department ?? ''),
                            $doc->status ?? '',
                            $doc->created_at ?? ''
                        );
                    }
                });
                $zip->addFromString('documents.csv', $docsCsv);
                
                // Export activity logs - limit to recent 500 logs for speed
                $logsCsv = "ID,User Email,Action,IP,Created At\n";
                ActivityLog::with('user:id,email')
                    ->select('id', 'user_id', 'action', 'ip', 'created_at')
                    ->orderByDesc('created_at')
                    ->limit(500)
                    ->chunk(100, function($logs) use (&$logsCsv) {
                    foreach ($logs as $log) {
                        $logsCsv .= sprintf("%d,\"%s\",\"%s\",\"%s\",\"%s\"\n",
                            $log->id,
                            optional($log->user)->email ?? '',
                            $log->action ?? '',
                            $log->ip ?? '',
                            $log->created_at ?? ''
                        );
                    }
                });
                $zip->addFromString('activity_logs.csv', $logsCsv);
                
                $zip->close();
            }
            
            ActivityLog::create([
                'user_id' => optional(User::where('email', Session::get('user_email'))->first())->id,
                'action' => 'admin.export.data',
                'details' => ['filename' => $filename],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return response()->download($tempPath, $filename)->deleteFileAfterSend();
        })->name('export.data');


        // System check
        Route::get('/system-check', function () {
            $checks = [];
            
            // Database connectivity
            try {
                DB::connection()->getPdo();
                $checks['database'] = ['status' => 'ok', 'message' => 'Database connection successful'];
            } catch (Exception $e) {
                $checks['database'] = ['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()];
            }
            
            // Storage link
            $storageLinked = is_link(public_path('storage')) || is_dir(public_path('storage'));
            $checks['storage'] = [
                'status' => $storageLinked ? 'ok' : 'warning',
                'message' => $storageLinked ? 'Storage link exists' : 'Storage link missing - run php artisan storage:link'
            ];
            
            // App version
            $checks['app_version'] = ['status' => 'info', 'message' => 'Laravel ' . app()->version()];
            
            // Queue driver
            $queueDriver = config('queue.default');
            $checks['queue'] = ['status' => 'info', 'message' => 'Queue driver: ' . $queueDriver];
            
            // Cache driver
            $cacheDriver = config('cache.default');
            $checks['cache'] = ['status' => 'info', 'message' => 'Cache driver: ' . $cacheDriver];
            
            return view('admin.system-check', compact('checks'));
        })->name('system.check');

        // Admin: manage document types
        Route::get('/types', function () {
            $types = DocumentType::orderBy('name')->get();
            return view('admin.types', compact('types'));
        })->name('types');
        Route::post('/types', function (Request $request) {
            $data = $request->validate(['name' => ['required','string','max:255']]);
            DocumentType::create(['name' => $data['name'], 'slug' => str()->slug($data['name'])]);
            return back()->with('success', 'Type added');
        })->name('types.store');
        Route::post('/types/delete', function (Request $request) {
            $id = $request->validate(['id' => ['required','integer']])['id'];
            DocumentType::where('id',$id)->delete();
            return back()->with('success', 'Type deleted');
        })->name('types.delete');

        // Admin: manage departments
        Route::get('/departments', function () {
            $departments = Department::orderBy('name')->get();
            return view('admin.departments', compact('departments'));
        })->name('departments');
        Route::post('/departments', function (Request $request) {
            $data = $request->validate(['name' => ['required','string','max:255']]);
            Department::create(['name' => $data['name'], 'slug' => str()->slug($data['name'])]);
            return back()->with('success', 'Department added');
        })->name('departments.store');
        Route::post('/departments/delete', function (Request $request) {
            $id = $request->validate(['id' => ['required','integer']])['id'];
            Department::where('id',$id)->delete();
            return back()->with('success', 'Department deleted');
        })->name('departments.delete');

    });
});

// Custom middleware for authentication check
Route::middleware(['web'])->group(function () {
    Route::any('{any?}', function () {
        // This is a catch-all, but won't execute due to route order
    });
});