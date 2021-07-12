    <!-- Modal -->
    <div class="modal fade" id="users_permissions-modal-{{ $user_id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h4 class="modal-title text-light" id="myCenterModalLabel">Users Permissions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <table class="table activate-select dt-responsive nowrap w-100 users-state-datatable">
                        <thead>
                            <tr>
                                <th>User Id</th>
                                <th>Code</th>
                                <th>Dependency</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        @foreach ($users_permissions as $users_permission)
                            @if ($users_permission->user_id === $user_id)
                                <tr>
                                    <td>{{ $users_permission->user_id }}</td>
                                    <td>{{ $users_permission->code }}</td>
                                    <td>{{ $users_permission->dependency }}</td>
                                    <td>{{ $users_permission->status }}</td>
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
