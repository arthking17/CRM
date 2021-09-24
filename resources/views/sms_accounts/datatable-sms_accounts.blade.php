<table id="datatable-sms_accounts" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Account</th>
            <th>Name</th>
            <th>Username</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($sms_accounts as $sms_account)
            <tr id="sms_accountid{{ $sms_account->id }}">
                <td>{{ $sms_account->id }}</td>
                <td>{{ $sms_account->account[0]->name }}</td>
                <td>{{ $sms_account->name }}</td>
                <td>{{ $sms_account->username }}</td>
                <td>{{ $sms_account->start_date }}</td>
                <td>{{ $sms_account->end_date }}</td>
                <td>
                    @if ($sms_account->status === 1)
                        <span class="badge label-table bg-success">Active</span>
                    @elseif($sms_account->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($sms_account->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#edit-sms_account-modal" onclick="editSMSAccount({{ $sms_account->id }});"
                            data-toggle="modal"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" onclick="deleteSMSAccount({{ $sms_account->id }});"
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
            <th class="select">Account</th>
            <th class="select">Name</th>
            <th class="select">Username</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="select with-span">Status</th>
            <th class="disabled"></th>
        </tr>
    </tfoot>
</table>
