<div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addGradeModalForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGradeModalLabel">Add Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addGradeModalGrade" class="form-label">Grade</label>
                        <input type="number" class="form-control" id="addGradeModalGrade" name="grade" required>
                    </div>
                    <input type="hidden" id="studentId" name="studentId"> <!-- Hidden student ID -->
                    <input type="hidden" id="subjectCode" name="subjectCode"> <!-- Hidden subject code -->
                    <input type="hidden" id="sectionCode" name="sectionCode"> <!-- Hidden section code -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>