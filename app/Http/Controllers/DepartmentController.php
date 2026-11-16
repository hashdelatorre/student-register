<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('students')->latest()->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255|unique:departments,name']);
        Department::create($data);
        return redirect()->route('departments.index')->with('success', 'Department added.');
    }
}