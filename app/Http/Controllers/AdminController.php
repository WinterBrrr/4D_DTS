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
}
