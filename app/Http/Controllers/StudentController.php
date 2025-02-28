<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentList = Student::all();
        $subjectList = Subject::all();

        return view('admin.student.students', [
            'studentList' => $studentList,
            'subjectList' => $subjectList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());

        if($request -> expectsJson()){
            return response()->json([
                'confirmationMessage' => 'Student created successfully',
                'alertType' => 'success',
                'student' => $student,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {

        if (request()->expectsJson()) {
            return response()->json($student);
        }

        return view("student.students", [
            "student" => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view("student.edit", [
            "student" => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        
        return redirect()
            ->route('student.index')
            ->with([
                'confirmationMessage' => 'Student updated successfully.',
                'alertType' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('student.index')
            ->with([
                'confirmationMessage' => 'Student Deleted Successfully.',
                'alertType' => 'success'
            ]);
    }

    public function getStudentsBySection($sectionCode)
    {
        $students = Student::where('section_code', $sectionCode)->get();
        
        return response()->json(['students' => $students]);
    }
}
