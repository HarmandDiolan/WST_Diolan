<div class="modal fade" id="enrollStudentModal" tabindex="-1" aria-labelledby="enrollStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollStudentModalLabel">Enroll Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="enrollStudentForm" method="POST" action="{{ route('enrollments.store') }}">
                    @csrf
                    <input type="hidden" id="enrollStudentId" name="student_id">
                    
                    <label for="subjectSelect">Select Subject:</label>
                    <select id="subjectSelect" name="subject_id" class="form-control" required>
                        @if(isset($subjectList) && count($subjectList) > 0)
                            @foreach($subjectList as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->description }}</option>
                            @endforeach
                        @else
                            <option disabled>No subjects available</option>
                        @endif
                    </select>
                    
                    <br>
                    <button type="submit" id="confirmEnroll" class="btn btn-primary">Confirm Enrollment</button>
                </form>
            </div>
        </div>
    </div>
</div>
