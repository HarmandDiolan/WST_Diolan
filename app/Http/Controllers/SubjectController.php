<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjectList = Subject::all();

        return view('subject.subjects', [
            'subjectList' => $subjectList
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());

        if($request -> expectsJson()){
            return response()->json([
                'confirmationMessage' => 'Subject created successfully',
                'alertType' => 'success',
                'subject' => $subject,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        if(request()->expectsJson()){
            return response()->json($subject);
        }

        return view("subject.subjects", [
            'subject' => $subject
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subject.edit',[
            'subject' > $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        
        return redirect()
            ->route('subject.index')
            ->with([
                'confirmationMessage' => 'Subject has been updated successfully.',
                'alertType' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()
            ->route('subject.index')
            ->with([
                'confirmationMessage' => 'Subject has been deleted.' ,
                'alertType' => 'successs'
            ]);
    }
}
