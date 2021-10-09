<table id="datatable-users_sip_accounts" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>User</th>
            <th>SIP Account</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users_sip_accounts as $users_sip_account)
            <tr id="users_sip_accountid{{ $users_sip_account->id }}">
                <td>{{ $users_sip_account->id }}</td>
                <td>{{ $users_sip_account->user[0]->username }}</td>
                <td>{{ $users_sip_account->sipaccount[0]->name }}</td>
                <td>{{ $users_sip_account->start_date }}</td>
                <td>{{ $users_sip_account->end_date }}</td>
                <td>
                    @if ($users_sip_account->status === 1)
                        <span class="badge label-table bg-success">Active</span>
                    @elseif($users_sip_account->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($users_sip_account->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#edit-users_sip_account-modal" onclick="editUserSipAccount({{ $users_sip_account->id }});"
                            data-toggle="modal"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" onclick="deleteUserSipAccount({{ $users_sip_account->id }});"
                            class="btn- btn-xs btn-danger">
                            <i class="mdi mdi-delete-circle"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th class="select">User</th>
            <th class="select">SIP Account</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="select with-span">Status</th>
            <th class="disabled"></th>
        </tr>
    </tfoot>
</table>
