<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <div id="view-list">
                    @include('notes.datatable-notes')
                </div>
            </div>
        </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-lg-4" id="note-info-card">
        @include('notes.note-info')
    </div>
</div>
<!-- end row -->
