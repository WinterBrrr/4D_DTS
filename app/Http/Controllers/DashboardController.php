<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();
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

        return view('dashboard', [
            'documents' => $documents,
        ]);
    }
}


