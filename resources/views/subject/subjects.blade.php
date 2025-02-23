@extends('layouts.dashboardlayout')

@section('title', 'Subject')

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
    @include('student.confirmation')
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">Add Subject</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject Code</th>
                            <th>Section Code</th>
                            <th>Subject Description</th>
                            <th>Units</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjectList as $subject)
                        <tr>
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->subjectCode }}</td>
                            <td>{{ $subject->sectionCode }}</td>
                            <td>{{ $subject->description }}</td>
                            <td>{{ $subject->units }}</td>
                            <td>
                                <!-- View Button triggers the modal -->
                                <a href="#" data-id="{{ $subject->id }}" class="viewSubject" data-toggle="modal" data-target="#viewSubjectModal">
                                    <i class="fa-solid fa-eye"></i>&nbsp;
                                </a>
                                <a href="#" data-id="{{ $subject->id }}" class="editSubject" data-bs-toggle="modal" data-bs-target="#editSubjectModal">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a href="#" onclick="deleteSubject('{{ $subject->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>&nbsp;
                                <form method="POST" action="{{route('subject.destroy', $subject->id)}}" id="subject-form-{{$subject->id}}">
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
    function deleteSubject(id){
        alert(id);

        form = document.getElementById("subject-form-" + id);
        form.submit();
    }
</script>

@endsection

@include('modal.viewSubject')
@include('modal.editSubject')
@include('modal.createSubject')

@section('scripts')
<script>
    //View 
    $(document).ready(function() {
        console.log("jQuery version:", $.fn.jquery); 

        // Existing view modal AJAX call
        $('.viewSubject').click(function(e) {
            e.preventDefault();
            var subjectId = $(this).data('id');
            $.ajax({
                url: "{{ url('subject') }}/" + subjectId,
                type: "GET",
                dataType: "json",
                success: function(response) {

                    var createdAtFormatted = moment(response.created_at).format("MMMM D, YYYY");
                    var updatedAtFormatted = moment(response.updated_at).format("MMMM D, YYYY");

                    $('#subjectId').text(response.id);
                    $('#subjectCode').text(response.subjectCode);
                    $('#sectionCode').text(response.sectionCode);
                    $('#description').text(response.description);
                    $('#units').text(response.units);
                    $('#subjectCreatedAt').text(createdAtFormatted);
                    $('#subjectUpdatedAt').text(updatedAtFormatted);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching student details:", error);
                }
            });
        });

        // Edit
        $('.editSubject').click(function(e) {
            e.preventDefault();
            console.log("Edit button clicked!");
            var subjectId = $(this).data('id');

            $('#editSubjectForm').attr('action', "{{ url('subject') }}/" + subjectId);

            var editModalEl = document.getElementById('editSubjectModal');
            var editModal = new bootstrap.Modal(editModalEl);
            editModal.show();

            $.ajax({
                url: "{{ url('subject') }}/" + subjectId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('#editSubjectId').val(response.id);
                    $('#editSubjectCode').val(response.subjectCode);
                    $('#editSectionCode').val(response.sectionCode);
                    $('#editSubjectDescription').val(response.description);
                    $('#editSubjectUnits').val(response.units);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching student details for edit:", error);
                }
            });
        });
    });

    $('#addSubjectForm').submit(function(e) {
        e.preventDefault(); 

        var formData = $(this).serialize();
        console.log(formData);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#addSubjectModal').modal('hide');
                $('#addSubjectForm')[0].reset();

                // Append new subject row to the table
                var newRow = '<tr>' +
                    '<td>' + response.subject.id + '</td>' +
                    '<td>' + response.subject.subjectCode + '</td>' +
                    '<td>' + response.subject.sectionCode + '</td>' +
                    '<td>' + response.subject.description + '</td>' +
                    '<td>' + response.subject.units + '</td>' +
                    '<td>' +
                        '<a href="#" data-id="' + response.subject.id + '" class="viewSubject" data-toggle="modal" data-target="#viewSubjectModal">' +
                            '<i class="fa-solid fa-eye"></i>&nbsp;' +
                        '</a>' +
                        '<a href="#" data-id="' + response.subject.id + '" class="editSubject" data-bs-toggle="modal" data-bs-target="#editSubjectModal">' +
                            '<i class="fa-solid fa-pencil"></i>' +
                        '</a>' +
                        '<a href="#" onclick="deleteSubject(\'' + response.subject.id + '\')">' +
                            '<i class="fa-solid fa-trash"></i>' +
                        '</a>' +
                        '<form method="POST" action="/subject/' + response.subject.id + '" id="subject-form-' + response.subject.id + '">' +
                            '@csrf @method("DELETE")' +
                        '</form>' +
                    '</td>' +
                '</tr>';

                $('#dataTable tbody').append(newRow);
            },
            error: function(xhr, status, error) {
                console.error("Error adding subject:", error);
            }
        });
    });

</script>

@endsection
