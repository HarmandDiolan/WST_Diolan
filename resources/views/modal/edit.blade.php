<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editStudentForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="editStudentName" class="form-label">ID</label>
                    <input class="form-control" id="editStudentId" name="id" value="" disabled>
                    <div class="mb-3">
                        <label for="editStudentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editStudentName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="editStudentAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="editStudentAddress" name="address">
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
