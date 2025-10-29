<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Log dashboard view if a user is in session
        $email = (string) $request->session()->get('user_email', '');
        if ($email) {
            if ($user = User::where('email', $email)->first()) {
                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'dashboard.view',
                    'details' => [],
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
        }
        $query = Document::query();
        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('code', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%")
                    ->orWhere('handler', 'like', "%{$q}%")
                    ->orWhere('department', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            });
        }

        $documents = $query->orderByDesc('id')->paginate(10)->withQueryString();

        // Dynamic stats
        $total = Document::count();
        $processing = Document::where(function ($qb) {
            $qb->where('status', 'like', '%review%')
               ->orWhere('status', 'like', '%process%');
        })->count();
        $completed = Document::where('status', 'like', '%complete%')->count();

        $lastAccessedTitle = optional(Document::orderByDesc('updated_at')->first())->title
            ?? optional(Document::orderByDesc('id')->first())->title
            ?? '—';

        return view('dashboard', [
            'documents' => $documents,
            'stats' => [
                'total' => $total,
                'processing' => $processing,
                'completed' => $completed,
                'lastAccessedTitle' => $lastAccessedTitle,
            ],
        ]);
    }
}


