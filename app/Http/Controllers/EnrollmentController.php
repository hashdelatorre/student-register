<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $students = Student::with('subjects')->orderBy('last_name')->get();
        $subjects = Subject::orderBy('code')->get();
        return view('enrollments.index', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'subject_id'  => 'required|exists:subjects,id',
            'school_year' => 'required|string|max:20',
        ]);

        $student = Student::findOrFail($data['student_id']);

        $already = $student->subjects()
            ->where('subjects.id', $data['subject_id'])
            ->wherePivot('school_year', $data['school_year'])
            ->exists();

        if ($already) {
            return back()->withErrors(['subject_id' => 'Student is already enrolled in that subject for this school year.'])->withInput();
        }

        $student->subjects()->attach($data['subject_id'], ['school_year' => $data['school_year']]);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment added.');
    }
}