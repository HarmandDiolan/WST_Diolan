<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\User;  // Ensure User model is imported
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch users with 'student' role from the User model
        $students = User::where('role', 'student')->get();  // This is fetching users with role 'student'
        
        // Fetching all students from the Student model for other information
        $studentList = User::all();
        $subjectList = Subject::all();

        return view('admin.student.students', [
            'students' => $students,       // Passing the fetched users as 'students'
            'studentList' => $studentList, // List of students from Student model
            'subjectList' => $subjectList  // Subject list if needed
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
        // Store the user data in the 'users' table first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,  // Store the email
            'address' => $request->address,  // Store the address
            'password' => $request->password,  // This is already hashed by the request
            'role' => $request->role,  // Role is always 'student'
        ]);
    
        // Store the student data in the 'students' table, linking to the created user
        $student = Student::create([
            'user_id' => $user->id, // Link the student to the created user
            'section_code' => $request->section_code, // Assuming section_code is part of the student data
            // Add any other student-specific data here if needed
        ]);
    
        // Return a response depending on the request type (JSON or standard response)
        if ($request->expectsJson()) {
            return response()->json([
                'confirmationMessage' => 'Student created successfully',
                'alertType' => 'success',
                'student' => $student,
                'user' => $user, // Return user data as well
            ]);
        }
    
        // Redirect back or to another page for a standard form submission
        return redirect()->route('student.index')->with([
            'confirmationMessage' => 'Student created successfully.',
            'alertType' => 'success'
        ]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $student)
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
    public function update(UpdateStudentRequest $request, User $student)
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
    public function destroy(User $student)
    {
        $student->delete();

        return redirect()
            ->route('student.index')
            ->with([
                'confirmationMessage' => 'Student Deleted Successfully.',
                'alertType' => 'success'
            ]);
    }

    /**
     * Fetch students by their section code.
     */
    public function getStudentsBySection($sectionCode)
    {
        // Fetch students based on section code
        $students = Student::where('section_code', $sectionCode)->get();

        return response()->json(['students' => $students]);
    }
}
