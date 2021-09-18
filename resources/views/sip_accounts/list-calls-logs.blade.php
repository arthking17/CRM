    <!-- Modal -->
    <div class="modal fade" id="calls-logs-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myCenterModalLabel">Calls Logs Activity</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <table
                        class="table activate-select dt-responsive nowrap w-100 table-hover"
                        id="datatable-calls-logs">
                        <thead>
                            <tr>
                                <th>Destination</th>
                                <th>Contact ID</th>
                                <th>Contact Name</th>
                                <th>Contact Phone number</th>
                                <th>Status</th>
                                <th>Extension</th>
                                <th>User</th>
                                <th>Duration</th>
                                <th>Recorded call</th>
                                <th>Qualification</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($call_logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->log_date }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->element_id }}</td>
                                    <td>{{ $log->source }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->element_id }}</td>
                                    <td>{{ $log->source }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="select with-span">Destination</th>
                                <th>Contact ID</th>
                                <th>Contact Name</th>
                                <th>Contact Phone number</th>
                                <th class="select with-span">Status</th>
                                <th>Extension</th>
                                <th>User</th>
                                <th>Duration</th>
                                <th>Recorded call</th>
                                <th class="select">Qualification</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
