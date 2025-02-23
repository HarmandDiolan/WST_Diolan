<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addSubjectForm" method="POST" action="{{ route('subject.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addSubjectCode" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" id="addSubjectCode" name="subjectCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="addSectionCode" class="form-label">Section Code</label>
                        <input type="text" class="form-control" id="addSectionCode" name="sectionCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="addSubjectDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="addSubjectDescription" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="addSubjectUnits" class="form-label">Units</label>
                        <input type="number" class="form-control" id="addSubjectUnits" name="units" required>
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
