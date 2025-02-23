<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addStudentForm" method="POST" action="{{ route('student.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addStudentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="addStudentName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="addStudentAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="addStudentAddress" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="addStudentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addStudentEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="addStudentAge" class="form-label">Age</label>
                        <input type="number" class="form-control" id="addStudentage" name="age" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
