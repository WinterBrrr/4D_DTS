<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HandlerController extends Controller
{
	public function dashboard(Request $request)
	{
		$user = auth()->user();
		$stats = [
			'assigned' => \App\Models\Document::where('handler', $user->name)->count(),
			'pending' => \App\Models\Document::where('handler', $user->name)->where('status', 'pending')->count(),
			'reviewing' => \App\Models\Document::where('handler', $user->name)->where('status', 'reviewing')->count(),
			'approved' => \App\Models\Document::where('handler', $user->name)->where('status', 'approved')->count(),
			'rejected' => \App\Models\Document::where('handler', $user->name)->where('status', 'rejected')->count(),
		];
		$documents = \App\Models\Document::where('handler', $user->name)->orderByDesc('updated_at')->get();
		return view('handler.dashboard', compact('stats', 'documents'));
	}

	public function pending()
	{
		$user = auth()->user();
		$documents = \App\Models\Document::where('handler', $user->name)
			->where('status', 'pending')
			->orderByDesc('updated_at')
			->get();
		return view('handler.pending', compact('documents'));
	}

	public function initial()
	{
		$user = auth()->user();
		$documents = \App\Models\Document::where('handler', $user->name)
			->where('status', 'initial')
			->orderByDesc('updated_at')
			->get();
		return view('handler.initial', compact('documents'));
	}

	public function under()
	{
		$user = auth()->user();
		$documents = \App\Models\Document::where('handler', $user->name)
			->where('status', 'reviewing')
			->orderByDesc('updated_at')
			->get();
		return view('handler.under', compact('documents'));
	}

	public function final()
	{
		$user = auth()->user();
		$documents = \App\Models\Document::where('handler', $user->name)
			->where('status', 'final_processing')
			->orderByDesc('updated_at')
			->get();
		return view('handler.final', compact('documents'));
	}

	public function completed()
	{
		$user = auth()->user();
		$documents = \App\Models\Document::where('handler', $user->name)
			->whereIn('status', ['completed', 'approved', 'rejected'])
			->orderByDesc('updated_at')
			->get();
		return view('handler.completed', compact('documents'));
	}
}
