@extends('layouts.dashboardlayout')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <h1>Your Grades</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Section Code</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr>
                    <td>{{ $grade->subject_code }}</td>
                    <td>{{ $grade->section_code }}</td>
                    <td>{{ $grade->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
