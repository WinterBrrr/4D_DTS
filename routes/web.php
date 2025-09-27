<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;

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

        // Enhanced demo auth with role checking
        Session::put('logged_in', true);
        Session::put('user_email', $validated['email']);
        
        // Determine user role (in real app, this would be from database)
        $userRole = ($validated['email'] === 'admin@example.com') ? 'admin' : 'user';
        Session::put('user_role', $userRole);
        Session::put('user_name', $userRole === 'admin' ? 'Admin User' : 'Regular User');

        // Redirect based on role
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('dashboard');
    })->name('login.attempt');

    Route::post('/logout', function () {
        Session::forget(['logged_in', 'user_email', 'user_role', 'user_name']);
        Session::flush();
        return redirect()->route('login');
    })->name('logout');

    // Password reset and registration
    Route::get('/password/reset', function () {
        return redirect('/login')->with('info', 'Password reset not yet implemented. Contact support.');
    })->name('password.request');

    Route::get('/register', function () {
        return redirect('/login')->with('info', 'Registration not yet available. Contact admin.');
    })->name('register');

    // Protected user routes
    Route::middleware(['check.auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/status', function () {
            return view('status');
        })->name('status');

        Route::get('/upload', function () {
            return view('upload');
        })->name('upload');

        Route::post('/upload', function (Request $request) {
            $validated = $request->validate([
                'document_type' => ['required', 'string'],
                'department' => ['required', 'string'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'file' => ['required', 'file', 'mimes:pdf,doc,docx,txt,xlsx,pptx', 'max:10240'], // 10MB max
            ]);

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'local');

            // Store document info in session (in real app, save to database)
            $documents = Session::get('uploaded_documents', []);
            $documents[] = [
                'id' => count($documents) + 1,
                'title' => $validated['title'],
                'type' => $validated['document_type'],
                'department' => $validated['department'],
                'description' => $validated['description'],
                'filename' => $filename,
                'path' => $path,
                'uploaded_at' => now()->format('Y-m-d H:i:s'),
                'status' => 'pending',
                'submitter' => Session::get('user_name', 'Unknown User')
            ];
            Session::put('uploaded_documents', $documents);

            return back()->with('success', 'Document uploaded successfully')->with('uploaded_path', $path);
        })->name('upload.store');
    });

    // Admin routes with proper protection
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', function () {
            $documents = Session::get('uploaded_documents', []);
            $stats = [
                'pending' => count(array_filter($documents, fn($d) => $d['status'] === 'pending')),
                'reviewing' => count(array_filter($documents, fn($d) => $d['status'] === 'reviewing')),
                'completed' => count(array_filter($documents, fn($d) => $d['status'] === 'completed')),
                'total' => count($documents)
            ];
            
            $recentActivity = array_slice(array_reverse($documents), 0, 3);
            
            return view('admin.dashboard', compact('stats', 'recentActivity'));
        })->name('dashboard');

        // Document workflow pages - FIXED ROUTE NAMES
        Route::get('/pending', function () {
            $documents = Session::get('uploaded_documents', []);
            $pendingDocuments = collect(array_filter($documents, fn($d) => $d['status'] === 'pending'));
            $totalPending = $pendingDocuments->count();
            
            return view('admin.pending', compact('pendingDocuments', 'totalPending'));
        })->name('pending');

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

        // Document management routes
        Route::get('/documents/{document}', function ($document) {
            $documents = Session::get('uploaded_documents', []);
            $currentDocument = collect($documents)->firstWhere('id', (int)$document);
            
            if (!$currentDocument) {
                abort(404, 'Document not found');
            }
            
            return view('admin.document-view', compact('currentDocument'));
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
            return view('admin.reports');
        })->name('reports');

        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');

        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');

        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['web', 'check.auth']);

    });
});

// Custom middleware for authentication check
Route::middleware(['web'])->group(function () {
    Route::any('*', function () {
        // This is a catch-all, but won't execute due to route order
    });
});