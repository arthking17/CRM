    <!-- Modal -->
    <div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">
                        Notes
                        <button id="btn-add-note-2" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#create-note-2-modal">
                            <i class="mdi mdi-plus-circle me-1"></i> Add Note
                        </button>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @include('notes.datatable-notes-modal')
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
