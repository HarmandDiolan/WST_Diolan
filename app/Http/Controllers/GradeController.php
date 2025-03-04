<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjectList = Subject::all(); // Fetch all subjects from the database
        return view('admin.grade.grades', compact('subjectList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $validated = $request->validated();
    
        // Create the grade
        $grade = new Grade();
        $grade->student_id = $validated['studentId'];
        $grade->subject_code = $validated['subjectCode'];
        $grade->section_code = $validated['sectionCode'];
        $grade->grade = $validated['grade'];
        $grade->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Grade added successfully!',
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Get the authenticated student
        $student = auth()->guard('student')->user();
    
        // Debug: Check if the student is authenticated
        if (!$student) {
            abort(403, 'You must be logged in as a student.');
        }
    
        // Debug: Check if the authenticated user is an instance of Student
        if (!$student instanceof \App\Models\Student) {
            abort(403, 'Invalid user type.');
        }
    
        // Find the grade
        $grade = Grade::findOrFail($id);
    
        // Debug: Check if the grade belongs to the student
        if ($student->id !== $grade->student_id) {
            abort(403, 'You do not have permission to view this grade.');
        }
    
        // Authorize the action using the Gate
        if (Gate::forUser($student)->denies('view', $grade)) {
            abort(403, 'Unauthorized access.');
        }
    
        // Return the grade as JSON
        return response()->json($grade);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        //
    }
    public function showGrades()
    {
        $student = Auth::user(); // Get the currently authenticated user (student)
    
        // Fetch the grades related to the student
        $grades = $student->grades; // Assuming 'grades' is a relationship on the User model
    
        // Check if grades are available before passing to the view
        if (!$grades) {
            // If no grades, set an empty collection
            $grades = collect();
        }
    
        return view('index', compact('grades'));
    }
}
