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

        // Consistent stats for user's documents only
        $total = (clone $query)->count();
        $pending = (clone $query)->where('status', 'pending')->count();
        $reviewing = (clone $query)->where('status', 'reviewing')->count();
        $approved = (clone $query)->where('status', 'approved')->count();
        $rejected = (clone $query)->where('status', 'rejected')->count();

        $lastAccessedTitle = optional((clone $query)->orderByDesc('updated_at')->first())->title
            ?? optional((clone $query)->orderByDesc('id')->first())->title
            ?? '—';

    return view('user.dashboard', [
            'documents' => $documents,
            'stats' => [
                'total' => $total,
                'pending' => $pending,
                'reviewing' => $reviewing,
                'approved' => $approved,
                'rejected' => $rejected,
                'lastAccessedTitle' => $lastAccessedTitle,
            ],
        ]);
    }
}


