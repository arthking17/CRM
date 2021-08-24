<table id="datatable-sip_accounts" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Account</th>
            <th>Channel</th>
            <th>Priority</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($sip_accounts as $sip_account)
            <tr id="sip_accountid{{ $sip_account->id }}" onclick="viewSipAccount({{ $sip_account->id }})">
                <td>{{ $sip_account->id }}</td>
                <td>{{ $sip_account->account[0]->name }}</td>
                <td>{{ $sip_account->channel[0]->name }}</td>
                <td>
                    @if ($sip_account->priority === 1)
                        <span class="badge bg-danger">Low</span>
                    @elseif($sip_account->priority === 2)
                        <span class="badge bg-success text-light">Normal</span>
                    @elseif($sip_account->priority === 3)
                        <span class="badge bg-info text-light">High</span>
                    @endif
                </td>
                <td>{{ $sip_account->start_date }}</td>
                <td>{{ $sip_account->end_date }}</td>
                <td>
                    @if ($sip_account->status === 1)
                        <span class="badge label-table bg-success">Active</span>
                    @elseif($sip_account->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($sip_account->status === 0)
                        <a href="javascript:void(0);" class="action-icon"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                    @else
                        <a href="javascript:void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#edit-sip_account-modal" onclick="editSipAccount({{ $sip_account->id }});"
                            data-toggle="modal"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" onclick="deleteSipAccount({{ $sip_account->id }});"
                            class="action-icon">
                            <i class="mdi mdi-delete"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th class="select">Account</th>
            <th class="select">Channel</th>
            <th class="select with-span">Priority</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="select with-span">Status</th>
            <th class="disabled"></th>
        </tr>
    </tfoot>
</table>
