<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Department;
use App\Models\DocumentType;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public static $ALLOWED_TYPES = [
        'Policy', 'Procedures(SOP)', 'Guidelines', 'Manuals', 'Report', 'Plans', 'Memo', 'Others'
    ];
    public static $ALLOWED_DEPARTMENTS = [
        'CIT', 'COE', 'COM', 'CAS', 'ICJE', 'COT', 'CE', 'ADMIN'
    ];

    /**
     * Show the inspect view for a document.
     */
    public function inspect(Document $document)
    {
        return view('inspect', ['document' => $document]);
    }

    public function index()
    {
        $documents = Document::with(['department', 'type', 'user'])->get();
        return view('admin.documents', compact('documents'));
    }

    public function create()
    {
        $departments = Department::all();
        $types = DocumentType::all();
        // If user is admin, use admin upload view; else use user upload_user view
        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.upload', compact('departments', 'types'));
        }
        return view('upload_user', compact('departments', 'types'));
    }

    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['auth' => 'You must be logged in to upload documents.']);
        }
        // DEBUG: Confirm controller entry
        session()->flash('debug', 'DocumentController@store called');
        // Validate all required fields
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type_id' => 'required|string',
            'department_id' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,txt,xlsx,pptx,png,jpg,jpeg|max:10240',
        ]);

        $type = $request->input('type_id');
        $department = $request->input('department_id');

        // Manual validation for type and department
        if (!in_array($type, self::$ALLOWED_TYPES)) {
            session()->flash('debug', 'Invalid type: ' . $type);
            return back()->withErrors(['type_id' => 'The selected type is invalid.'])->withInput();
        }
        if (!in_array($department, self::$ALLOWED_DEPARTMENTS)) {
            session()->flash('debug', 'Invalid department: ' . $department);
            return back()->withErrors(['department_id' => 'The selected department is invalid.'])->withInput();
        }

        // Try file upload
        try {
            // Store in public disk so it's accessible via /storage symlink
            $path = $request->file('file')->store('documents', 'public');
            session()->flash('debug', 'File uploaded to: ' . $path);
        } catch (\Exception $e) {
            session()->flash('debug', 'File upload failed: ' . $e->getMessage());
            return back()->withErrors(['file' => 'File upload failed: ' . $e->getMessage()])->withInput();
        }

        // Try database write
        try {
            $document = Document::create([
                'code' => 'DOC_' . uniqid(),
                'title' => $request->title,
                'type' => $type,
                'handler' => Auth::user()->name ?? 'Unknown',
                'department' => $department,
                'user_id' => Auth::id(),
                'file_path' => $path,
                'status' => 'pending',
                'description' => $request->input('description'),
            ]);
            session()->flash('debug', 'Document created: ' . json_encode($document->toArray()));
        } catch (\Exception $e) {
            session()->flash('debug', 'Document creation failed: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Document creation failed: ' . $e->getMessage()])->withInput();
        }

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Uploaded document',
            'document_id' => $document->id,
        ]);

        // Success feedback
        session()->flash('debug', 'Upload complete.');
        return redirect()->route('dashboard')->with('success', 'Document uploaded successfully.')->with('uploaded_path', $path);
    }

    public function show($id)
    {
        $document = Document::with(['department', 'type', 'user', 'statusLogs'])->findOrFail($id);
        return view('admin.document', compact('document'));
    }

    public function updateStatus(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $request->validate([
            'status' => 'required|string',
        ]);
        $document->status = $request->status;
        $document->save();
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Changed status to ' . $request->status,
            'document_id' => $document->id,
        ]);
        return back()->with('success', 'Status updated.');
    }
}