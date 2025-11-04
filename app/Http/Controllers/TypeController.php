<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentType;

class TypeController extends Controller
{
    public function index()
    {
        $types = DocumentType::all();
        return view('admin.types', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        DocumentType::create(['name' => $request->name]);
        return back()->with('success', 'Type added.');
    }
}
