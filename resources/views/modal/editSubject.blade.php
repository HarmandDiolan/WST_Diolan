<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSubjectForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="editSubjectName" class="form-label">ID</label>
                    <input class="form-control" id="editSubjectId" name="id" value="" disabled>
                    <div class="mb-3">
                        <label for="editSubjectCode" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" id="editSubjectCode" name="subjectCode">
                    </div>
                    <div class="mb-3">
                        <label for="editSectionCode" class="form-label">Section Code</label>
                        <input type="text" class="form-control" id="editSectionCode" name="sectionCode">
                    </div>
                    <div class="mb-3">
                        <label for="editSubjectDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="editSubjectDescription" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="editSubjectUnits" class="form-label">Units</label>
                        <input type="number" class="form-control" id="editSubjectUnits" name="units">
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
