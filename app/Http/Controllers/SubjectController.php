<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view('subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'  => 'required|string|max:20|unique:subjects,code',
            'name'  => 'required|string|max:255',
            'units' => 'required|integer|min:1|max:10',
        ]);
        Subject::create($data);
        return redirect()->route('subjects.index')->with('success', 'Subject added.');
    }
}