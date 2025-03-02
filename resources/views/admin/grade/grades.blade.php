@extends('layouts.dashboardlayout')

@section('title', 'Enrolled Student')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">STUDENT</h1>
    <p class="mb-4">
        DataTables is a third-party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the 
        <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <div id="confirmationMessage" class="alert d-none"></div>
    @include('admin.student.confirmation')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Enrolled Students</h6>

            <!-- Section Code Dropdown -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="sectionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Section Code
                </button>
                <ul class="dropdown-menu" aria-labelledby="sectionDropdown">
                    @foreach($subjectList as $subject)
                        <li>
                            <a class="dropdown-item" href="#" onclick="fetchStudents('{{ $subject->sectionCode }}')">
                                {{ $subject->sectionCode }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Subject Code</th>
                            <th>Subject Description</th>
                            <th>Units</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <tr>
                            <td colspan="6" class="text-center">Select a section to view students</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('modal.createGrade')

<!-- JavaScript for Fetching Students -->
<script>
function fetchStudents(sectionCode) {
    let studentTableBody = document.getElementById("studentTableBody");
    studentTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>'; // Show loading state

    fetch(`/fetch-students/${sectionCode}`)
        .then(response => response.json())
        .then(data => {
            studentTableBody.innerHTML = ''; // Clear table body
            if (data.students.length > 0) {
                data.students.forEach(student => {
                    studentTableBody.innerHTML += `
                        <tr>
                            <td>${student.id}</td>
                            <td>${student.name}</td>
                            <td>${student.subjectCode}</td>
                            <td>${student.description}</td>
                            <td>${student.units}</td>
                            <td>${student.grade}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="openAddGradeModal('${student.id}', '${student.name}', '${student.subjectCode}', '${student.description}', '${student.units}', '${sectionCode}')">
                                    Add Grade
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                studentTableBody.innerHTML = '<tr><td colspan="6" class="text-center">No students enrolled</td></tr>';
            }
        })
        .catch(error => {
            console.error("Error fetching students:", error);
            studentTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading students</td></tr>';
        });
    }

    function openAddGradeModal(id, name, subjectCode, description, units, sectionCode) {
    // Populate modal fields with the data
    document.getElementById("studentId").value = id;
    document.getElementById("subjectCode").value = subjectCode;
    document.getElementById("sectionCode").value = sectionCode;

    // Show the modal
    var addGradeModal = new bootstrap.Modal(document.getElementById("addGradeModal"));
    addGradeModal.show();
}

// Handle the form submission via AJAX
document.getElementById("addGradeModalForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Get form data
    var formData = new FormData(this);
    var grade = document.getElementById("addGradeModalGrade").value;
    formData.append("grade", grade); // Add the grade value manually

    // Send the AJAX request to the server
    fetch("{{ route('grades.store') }}", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);  // Display success message
            $('#addGradeModal').modal('hide');  // Hide the modal
            // You may want to refresh the student list here
            fetchStudents(document.getElementById("sectionCode").value);  // Refresh the students list
        } else {
            alert('Failed to add grade. Please try again.');
        }
    })
    .catch(error => {
        console.error("Error adding grade:", error);
        alert("Error adding grade. Please try again.");
    });
});

</script>

@endsection
