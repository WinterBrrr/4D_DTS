<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $logs = ActivityLog::latest()->limit(20)->get();
        return view('admin.dashboard', compact('users', 'logs'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
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
}
