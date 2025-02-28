@extends('layouts.dashboardlayout')

@section('title', 'Student')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">STUDENT</h1>
    <p class="mb-4">
        DataTables is a third-party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>
    
    <div id="confirmationMessage" class="alert d-none"></div>
    @include('admin.student.confirmation')
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentList as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->address }}</td>
                            <td>
                                <!-- View Button triggers the modal -->
                                <a href="#" data-id="{{ $student->id }}" class="viewStudent" data-toggle="modal" data-target="#viewStudentModal">
                                    <i class="fa-solid fa-eye"></i>&nbsp;
                                </a>
                                <a href="#" data-id="{{ $student->id }}" class="editStudent" data-bs-toggle="modal" data-bs-target="#editStudentModal">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a href="#" onclick="deleteStudent('{{ $student->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>&nbsp;
                                <form method="POST" action="{{route('student.destroy', $student->id)}}" id="student-form-{{$student->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script>
    function deleteStudent(id){
        alert(id);

        form = document.getElementById("student-form-" + id);
        form.submit();
    }
</script>

@endsection

@include('modal.view')
@include('modal.edit')
@include('modal.create')

@section('scripts')
<script>
    //View 
    $(document).ready(function() {
        console.log("jQuery version:", $.fn.jquery); 

        // Existing view modal AJAX call
        $('.viewStudent').click(function(e) {
            e.preventDefault();
            var studentId = $(this).data('id');
            $.ajax({
                url: "{{ url('student') }}/" + studentId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var createdAtFormatted = moment(response.created_at).format("MMMM D, YYYY");
                    var updatedAtFormatted = moment(response.updated_at).format("MMMM D, YYYY");
                    $('#studentId').text(response.id);
                    $('#studentName').text(response.name);
                    $('#studentAddress').text(response.address);
                    $('#studentCreatedAt').text(createdAtFormatted);
                    $('#studentUpdatedAt').text(updatedAtFormatted);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching student details:", error);
                }
            });
        });

        // Edit
        $('.editStudent').click(function(e) {
            e.preventDefault();
            console.log("Edit button clicked!");
            var studentId = $(this).data('id');

            $('#editStudentForm').attr('action', "{{ url('student') }}/" + studentId);

            var editModalEl = document.getElementById('editStudentModal');
            var editModal = new bootstrap.Modal(editModalEl);
            editModal.show();

            $.ajax({
                url: "{{ url('student') }}/" + studentId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('#editStudentId').val(response.id);
                    $('#editStudentName').val(response.name);
                    $('#editStudentAddress').val(response.address);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching student details for edit:", error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('#addStudentForm').submit(function(e) {
            e.preventDefault(); 

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                $('#addStudentModal').modal('hide');
                $('#addStudentForm')[0].reset();
                
                
                // Create new row HTML using the response data
                var newRow = '<tr>' +
                    '<td>' + response.student.id + '</td>' +
                    '<td>' + response.student.name + '</td>' +
                    '<td>' + response.student.address + '</td>' +
                    '<td>' +
                        '<a href="#" data-id="' + response.student.id + '" class="viewStudent" data-toggle="modal" data-target="#viewStudentModal">' +
                            '<i class="fa-solid fa-eye"></i>&nbsp;' +
                        '</a>' +
                        '<a href="#" data-id="' + response.student.id + '" class="editStudent" data-bs-toggle="modal" data-bs-target="#editStudentModal">' +
                            '<i class="fa-solid fa-pencil"></i>' +
                        '</a>' +
                        '<a href="#" onclick="deleteStudent(\'' + response.student.id + '\')">' +
                            '<i class="fa-solid fa-trash"></i>' +
                        '</a>' +
                        '<form method="POST" action="/student/' + response.student.id + '" id="student-form-' + response.student.id + '">' +
                            '@csrf @method("DELETE")' +
                        '</form>' +
                    '</td>' +
                '</tr>';

                // Append new row to the table body
                $('#dataTable tbody').append(newRow);
            }
            });
        });
    });

</script>

@endsection
