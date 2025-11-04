<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HandlerController extends Controller
{
    // Approve/Reject document
    public function reviewDocument(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected,reviewing']);
        $document = Document::findOrFail($id);
        if ($document->handler !== Auth::user()->name) {
            abort(403, 'Unauthorized');
        }
        $document->status = $request->status;
        $document->save();
        Session::flash('success', 'Document status updated.');
        return back();
    }

    // Add feedback/comment
    public function addComment(Request $request, $id)
    {
        $request->validate(['comment' => 'required|string|max:1000']);
        $document = Document::findOrFail($id);
        if ($document->handler !== Auth::user()->name) {
            abort(403, 'Unauthorized');
        }
        Comment::create([
            'document_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);
        Session::flash('success', 'Comment added.');
        return back();
    }

    // Forward to next handler
    public function forwardDocument(Request $request, $id)
    {
        $request->validate(['next_handler' => 'required|string|max:255']);
        $document = Document::findOrFail($id);
        if ($document->handler !== Auth::user()->name) {
            abort(403, 'Unauthorized');
        }
        $document->handler = $request->next_handler;
        $document->save();
        Session::flash('success', 'Document forwarded to next handler.');
        return back();
    }

    // Update expected completion date
    public function updateTimeline(Request $request, $id)
    {
        $request->validate(['expected_completion_at' => 'required|date']);
        $document = Document::findOrFail($id);
        if ($document->handler !== Auth::user()->name) {
            abort(403, 'Unauthorized');
        }
        $document->expected_completion_at = $request->expected_completion_at;
        $document->save();
        Session::flash('success', 'Expected completion date updated.');
        return back();
    }
}
