    <!-- Modal -->
    <div class="modal fade" id="logs-modal-{{ $user_id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myCenterModalLabel">Logs Activity</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <table class="table activate-select dt-responsive nowrap w-100 users-state-datatable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Log Date</th>
                                <th>Action</th>
                                <th>Element</th>
                                <th>Element Id</th>
                                <th>Source</th>
                            </tr>
                        </thead>
                        @foreach ($logs as $log)
                            @if ($log->user_id === $user_id)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->log_date }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ getElementName($log->element) }}</td>
                                    <td>{{ $log->element_id }}</td>
                                    <td>{{ $log->source }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
