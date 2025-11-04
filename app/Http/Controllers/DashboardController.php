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
        $user = null;
        if ($email) {
            $user = User::where('email', $email)->first();
        }
        $query = Document::query();
        if ($user) {
            if ($user->role === 'admin') {
                // Admin sees all documents
            } else {
                // Regular user sees only their documents
                $query->where('user_id', $user->id);
            }
        } else {
            // No user, no documents
            $query->whereRaw('0=1');
        }
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

        // Dynamic stats for user's documents only
        $total = $query->count();
        $processing = $query->where(function ($qb) {
            $qb->where('status', 'like', '%review%')
               ->orWhere('status', 'like', '%process%');
        })->count();
        $completed = $query->where('status', 'like', '%complete%')->count();

        $lastAccessedTitle = optional($query->orderByDesc('updated_at')->first())->title
            ?? optional($query->orderByDesc('id')->first())->title
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


