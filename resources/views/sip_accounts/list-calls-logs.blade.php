    <!-- Modal -->
    <div class="modal fade" id="calls-logs-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myCenterModalLabel">Calls Logs Activity</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="table-responsive" data-simplebar>
                        <table
                            class="table activate-select dt-responsive nowrap w-100 table-hover"
                            id="datatable-calls-logs">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Call Date</th>
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
                                    <th class="select">action</th>
                                    <th class="select">element</th>
                                    <th>element_id</th>
                                    <th class="select">source</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
