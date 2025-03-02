<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('admin.enrolled.enrolledStudent', [
            'studentList' => $students,
            'subjectList' => $subjects
        ]);
        dd($subjects);
    }

    public function enrolledStud()
    {   
        return view('admin.enrolled.enrolledStudent');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enrollments = Enrollment::all(); 
        return view('grades.create', compact('enrollments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        try {
            $validated = $request->validated();
    
            $enrollment = Enrollment::create([
                'student_id' => $validated['student_id'],
                'subject_id' => $validated['subject_id'],
            ]);
    
            return response()->json([
                'message' => 'Enrollment successful!',
                'data' => $enrollment
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getEnrolledStudents($sectionCode)
    {
        $enrollments = Enrollment::whereHas('subject', function ($query) use ($sectionCode) {
            $query->where('sectionCode', $sectionCode);
        })
        ->with(['student', 'subject', 'student.grades']) // Ensure relationship is correct
        ->get();
        
        if ($enrollments->isEmpty()) {
            return response()->json(['students' => []]); // Return empty array if no students found
        }
    
        return response()->json([
            'students' => $enrollments->map(function ($enrollment) {
                // Ensure grades are being loaded correctly
                $grades = $enrollment->student->grades;
    
                // If no grades are found, return 'No grade'
                $grade = $grades->firstWhere('subject_code', $enrollment->subject->subjectCode);
                return [
                    'id' => $enrollment->student->id,
                    'name' => $enrollment->student->name,
                    'subjectCode' => $enrollment->subject->subjectCode,
                    'description' => $enrollment->subject->description,
                    'units' => $enrollment->subject->units,
                    'grade' => $grade ? $grade->grade : 'No grade', // Handle case where no grade is found
                ];
            })
        ]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
