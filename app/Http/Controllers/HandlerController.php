<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// No direct middleware reference needed here; handled in routes.
use App\Models\Document;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HandlerController extends Controller
{
	public function show($id)
	{
		$document = \App\Models\Document::findOrFail($id);
		return view('handler.document', compact('document'));
	}
	public function dashboard(Request $request)
	{
		$user = auth()->user();
		$profile = optional($user->profile);
		$department = trim(strtolower($profile->department ?? ''));
		// Stats for handler's department
		$stats = [
			'total' => \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])->count(),
			'pending' => \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])->where('status', 'pending')->count(),
			'reviewing' => \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])->where('status', 'reviewing')->count(),
			'approved' => \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])->where('status', 'approved')->count(),
			'rejected' => \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])->where('status', 'rejected')->count(),
		];
		// Recent activity for handler's department
		$recentActivity = \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('updated_at')->limit(3)->get()->map(function ($d) {
				return [
					'title' => $d->title ?? $d->code ?? 'Untitled',
					'uploaded_at' => $d->updated_at ? $d->updated_at->diffForHumans() : '-',
				];
			})->toArray();
		// Paginated document list for handler's department
		$docs = \App\Models\Document::whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('id')->paginate(10);
		return view('handler.dashboard', compact('stats', 'recentActivity', 'docs'));
	}

	public function pending()
	{
		$user = auth()->user();
		$department = trim(strtolower(optional($user->profile)->department));
		$department = trim(strtolower(optional(auth()->user()->profile)->department ?? ''));
		$pendingDocumentsRaw = \App\Models\Document::where('status', 'pending')
			->whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('id')->get();
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
		return view('handler.pending', compact('pendingDocuments', 'pendingDocumentsRaw'));
	}

	public function initial()
	{
		$user = auth()->user();
		$department = trim(strtolower(optional($user->profile)->department));
		$department = trim(strtolower(optional(auth()->user()->profile)->department ?? ''));
		$documentsRaw = \App\Models\Document::where('status', 'initial')
			->whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('id')->get();
		$documents = $documentsRaw->map(function($doc) {
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
		return view('handler.initial', compact('documents', 'documentsRaw'));
	}

	public function under()
	{
		$user = auth()->user();
		$department = trim(strtolower(optional($user->profile)->department));
		$department = trim(strtolower(optional(auth()->user()->profile)->department ?? ''));
		$reviewingDocumentsRaw = \App\Models\Document::where('status', 'reviewing')
			->whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('id')->get();
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
		return view('handler.under', compact('reviewingDocuments', 'reviewingDocumentsRaw'));
	}

	public function final()
	{
		$user = auth()->user();
		$department = trim(strtolower(optional($user->profile)->department));
		$department = trim(strtolower(optional(auth()->user()->profile)->department ?? ''));
		$documentsRaw = \App\Models\Document::where('status', 'final_processing')
			->whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('id')->get();
		$documents = $documentsRaw->map(function($doc) {
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
		return view('handler.final', compact('documents', 'documentsRaw'));
	}

	public function completed()
	{
		$user = auth()->user();
		$department = trim(strtolower(optional($user->profile)->department));
		$department = trim(strtolower(optional(auth()->user()->profile)->department ?? ''));
		$completedDocumentsRaw = \App\Models\Document::whereIn('status', ['completed', 'approved', 'rejected'])
			->whereRaw('LOWER(TRIM(department)) = ?', [$department])
			->orderByDesc('id')->get();
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
		return view('handler.completed', compact('completedDocuments', 'completedDocumentsRaw'));
	}
}
