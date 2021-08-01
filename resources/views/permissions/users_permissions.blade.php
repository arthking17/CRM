    <!-- Modal -->
    <div class="modal fade" id="users_permissions-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h4 class="modal-title text-light" id="myCenterModalLabel">Users Permissions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <table class="table activate-select dt-responsive nowrap w-100 users-state-datatable"
                        id="datatable-users_permissions">
                        <thead>
                            <tr>
                                <th>User Id</th>
                                <th>Code</th>
                                <th>Dependency</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($users_permissions as $users_permission)
                            <tr id="user_permission-{{ str_replace('.', '', $users_permission->code) }}">
                                <td>{{ $users_permission->user_id }}</td>
                                <td>{{ $users_permission->code }}</td>
                                <td>
                                    @if ($users_permission->dependency === 0) <span
                                            class="badge bg-success">All</span>
                                    @elseif ($users_permission->dependency === 1)
                                        <span class="badge label-table bg-danger">action need admin validation</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($users_permission->status === 1) <span
                                            class="badge bg-success">Active</span>
                                    @elseif ($users_permission->status === 0)
                                        <span class="badge label-table bg-danger">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($users_permission->status === 1)
                                        <a href="javascript:void(0);" class="action-icon"
                                            onclick="deleteUsers_Permission('{{ $users_permission->user_id }}', '{{ $users_permission->code }}');"> <i
                                                class="mdi mdi-delete"></i></a>
                                    @elseif ($users_permission->status === 0)
                                        <a href="javascript:void(0);" class="action-icon"> <i
                                                class="mdi mdi-delete"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
