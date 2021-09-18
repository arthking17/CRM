<table id="datatable-email_accounts" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Account</th>
            <th>Host</th>
            <th>Port</th>
            <th>Email</th>
            <th>SMTPAuth</th>
            <th>SMTPSecure</th>
            <th>Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
            <th>Username</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($email_accounts as $email_account)
            <tr id="email_accountid{{ $email_account->id }}">
                <td>{{ $email_account->id }}</td>
                <td>{{ $email_account->account[0]->name }}</td>
                <td>{{ $email_account->host }}</td>
                <td>{{ $email_account->port }}</td>
                <td data-bind="text: text()" class="text-truncate" style="max-width: 200px" title="{{ $email_account->email }}">{{ $email_account->email }}</td>
                <td>
                    @if ($email_account->smtpauth == 1) <span
                            class="badge bg-info text-light">Yes</span>
                    @elseif($email_account->smtpauth == 0) <span class="badge label-table bg-danger ">No</span> @endif
                </td>
                <td>
                    @if ($email_account->smtpsecure == 1) <span
                            class="badge bg-success text-light">TLS</span>
                    @elseif($email_account->smtpsecure == 2) <span class="badge bg-pink text-light">SSL</span>
                    @elseif($email_account->smtpsecure == 3) <span class="badge label-table bg-warning ">NOTLS</span>
                    @elseif($email_account->smtpsecure == 4) <span class="badge bg-blue text-light">STARTTLS</span>
                    @endif
                </td>
                <td>
                    @if ($email_account->type == 1)
                    Unitary @elseif($email_account->type == 0) Max Marketing
                    @endif
                </td>
                <td>{{ $email_account->start_date }}</td>
                <td>{{ $email_account->end_date }}</td>
                <td>
                    @if ($email_account->status === 1)
                        <span class="badge label-table bg-success">Active</span>
                    @elseif($email_account->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($email_account->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i
                                class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info" data-bs-toggle="modal"
                            data-bs-target="#edit-email_account-modal"
                            onclick="editEmailAccount({{ $email_account->id }});" data-toggle="modal"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" onclick="deleteEmailAccount({{ $email_account->id }});"
                            class="btn- btn-xs btn-danger">
                            <i class="mdi mdi-delete-circle"></i></a>
                    @endif
                </td>
                <td data-bind="text: text()" class="text-truncate" style="max-width: 200px" title="{{ $email_account->email }}">{{ $email_account->username }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th class="select">Account</th>
            <th>Host</th>
            <th>Port</th>
            <th>Email</th>
            <th class="select with-span">SMTPAuth</th>
            <th class="select with-span">SMTPSecure</th>
            <th class="select">Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="select with-span">Status</th>
            <th class="disabled"></th>
            <th>Username</th>
        </tr>
    </tfoot>
</table>
