    <!-- Modal -->
    <div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myCenterModalLabel">Notes</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <table class="table activate-select dt-responsive nowrap w-100 users-state-datatable" id="datatable-notes">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Class</th>
                                <th>Visibility</th>
                                <th>Content</th>
                                <th>Element</th>
                                <th>Element Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                                <tr>
                                    <td>{{ $note->id }}</td>
                                    <td>{{ getNoteClassName($note->class) }}</td>
                                    <td>
                                        @if ($note->visibility === 1) <span
                                                class="badge bg-success">Visible for all</span>
                                        @elseif ($note->visibility === 0)
                                            <span class="badge label-table bg-danger">Visible only for admin</span>
                                        @endif
                                    </td>
                                    <td>{{ $note->content }}</td>
                                    <td>{{ getElementName($note->element) }}</td>
                                    <td>{{ $note->element_id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
