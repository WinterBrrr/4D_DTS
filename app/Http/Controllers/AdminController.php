<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    // ...existing code...

    // ...existing code...
    // ...existing code...

    // Add under review documents view
    public function under(Request $request)
    {
        $reviewingDocumentsRaw = \App\Models\Document::where('status', 'reviewing')->orderByDesc('id')->get();
        $reviewingDocuments = $reviewingDocumentsRaw->map(function($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'type' => $doc->type ?? '',
                'handler' => $doc->handler ?? '',
                'department' => $doc->department ?? '',
                'status' => $doc->status,
                'expected_completion_at' => $doc->expected_completion_at ?? '—',
                'uploader' => $doc->user ? $doc->user->name : 'Unknown',
                'uploaded_at' => $doc->created_at ? $doc->created_at->format('Y-m-d') : '',
            ];
        });
        return view('admin.under', compact('reviewingDocuments', 'reviewingDocumentsRaw'));
    }
    public function dashboard()
    {
        $users = User::all();
        $logs = ActivityLog::latest()->limit(20)->get();
        return view('admin.dashboard', compact('users', 'logs'));
    }

    public function users()
    {
        // Show only registered users in All Users
        $users = User::where('status', 'registered')->orderByDesc('id')->paginate(10);
        // Only show users with status 'pending' in Pending Approval
        $pendingUsers = User::where('status', 'pending')->orderByDesc('id')->get();

        // Load profiles and activity for All Users
        $userIds = $users->pluck('id')->all();
        $profiles = \App\Models\UserProfile::whereIn('user_id', $userIds)->get()->keyBy('user_id');
        $lastLogin = \App\Models\ActivityLog::selectRaw('user_id, MAX(created_at) as at')
            ->where('action', 'login')
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')->pluck('at', 'user_id');
        $dashAgg = \App\Models\ActivityLog::selectRaw('user_id, MAX(created_at) as at, COUNT(*) as cnt')
            ->where('action', 'dashboard.view')
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')->get()->keyBy('user_id');
        $loginCount = \App\Models\ActivityLog::selectRaw('user_id, COUNT(*) as cnt')
            ->where('action', 'login')
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')->pluck('cnt', 'user_id');

        // Load profiles/activity for pending users if needed in the view
        $pendingUserIds = $pendingUsers->pluck('id')->all();
        $pendingProfiles = \App\Models\UserProfile::whereIn('user_id', $pendingUserIds)->get()->keyBy('user_id');

        return view('admin.users', compact('users', 'pendingUsers', 'profiles', 'lastLogin', 'dashAgg', 'loginCount', 'pendingProfiles'));
    }

    public function activity()
    {
        $logs = ActivityLog::latest()->get();
        return view('admin.activity', compact('logs'));
    }

    // Add pending documents view
    public function pending(Request $request)
    {
        $pendingDocumentsRaw = \App\Models\Document::where('status', 'pending')->orderByDesc('id')->get();
        $pendingDocuments = $pendingDocumentsRaw->map(function($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'type' => $doc->type ?? '',
                'handler' => $doc->handler ?? '',
                'department' => $doc->department ?? '',
                'status' => $doc->status,
                'expected_completion_at' => $doc->expected_completion_at ?? '—',
                'uploader' => $doc->user ? $doc->user->name : 'Unknown',
                'uploaded_at' => $doc->created_at ? $doc->created_at->format('Y-m-d') : '',
            ];
        });
        return view('admin.pending', compact('pendingDocuments', 'pendingDocumentsRaw'));
    }

    // Add completed, rejected, and approved documents view
    public function completed(Request $request)
    {
        $completedDocumentsRaw = \App\Models\Document::whereIn('status', ['completed', 'rejected', 'approved'])->orderByDesc('id')->get();
        $completedDocuments = $completedDocumentsRaw->map(function($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'type' => $doc->type ?? '',
                'handler' => $doc->handler ?? '',
                'department' => $doc->department ?? '',
                'status' => $doc->status,
                'expected_completion_at' => $doc->expected_completion_at ?? '—',
                'uploader' => $doc->user ? $doc->user->name : 'Unknown',
                'uploaded_at' => $doc->created_at ? $doc->created_at->format('Y-m-d') : '',
            ];
        });
        return view('admin.completed', compact('completedDocuments', 'completedDocumentsRaw'));
    }

    // Approve a pending user
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->status === 'pending') {
            $user->status = 'registered';
            $user->save();
        }
        return redirect()->back()->with('success', 'User approved successfully.');
    }

    // Reject (delete) a pending user
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->status === 'pending') {
            $user->delete();
        }
        return redirect()->back()->with('success', 'User rejected and deleted.');
    }

    // Show user details
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $profile = \App\Models\UserProfile::where('user_id', $user->id)->first();
        return view('admin.user_show', compact('user', 'profile'));
    }

    // Delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
