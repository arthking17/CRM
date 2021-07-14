    <!-- Modal -->
    <div class="modal fade" id="logs-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myCenterModalLabel">Logs Activity</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <table class="table activate-select dt-responsive nowrap w-100 table-hover users-state-datatable" id="datatable-logs">
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
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->log_date }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ getElementName($log->element) }}</td>
                                    <td>{{ $log->element_id }}</td>
                                    <td>{{ $log->source }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>id</th>
                                <th>log_date</th>
                                <th>action</th>
                                <th>element</th>
                                <th>element_id</th>
                                <th>source</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
