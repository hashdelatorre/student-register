<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['department', 'profile'])->latest()->get();
        $departments = Department::orderBy('name')->get();
        return view('students.index', compact('students', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'student_no'    => 'required|string|max:30|unique:students,student_no',
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'required|email|unique:students,email',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:30',
            'birthdate'     => 'required|date',
        ]);

        $student = Student::create([
            'department_id' => $data['department_id'],
            'student_no'    => $data['student_no'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
        ]);

        $student->profile()->create([
            'address'   => $data['address'],
            'phone'     => $data['phone'],
            'birthdate' => $data['birthdate'],
        ]);

        return redirect()->route('students.index')->with('success', 'Student registered.');
    }
}