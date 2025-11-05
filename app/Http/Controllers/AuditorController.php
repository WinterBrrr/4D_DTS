<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
    public function completed(Request $request)
    {
        // Fetch documents with status 'completed' or 'rejected'
        $completedDocumentsRaw = Document::whereIn('status', ['completed', 'rejected'])->orderByDesc('id')->get();
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
        return view('auditor.completed', compact('completedDocuments', 'completedDocumentsRaw'));
    }
}
