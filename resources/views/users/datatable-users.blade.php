<table id="datatable-users" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="text-filter">Username</th>
            <th class="select-filter">role</th>
            <th>photo</th>
            <th class="select-filter">account</th>
            <th class="select-filter">status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr id="userid{{ $user->id }}" onclick="viewUser({{ $user->id }});">
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    @if ($user->role === 1) <span
                            class="badge label-table bg-danger">Admin</span>
                    @elseif($user->role === 2)
                        <span class="badge bg-success">User</span>
                    @elseif($user->role === 3)
                        <span class="badge bg-blue text-light">Visitor</span>
                    @endif
                </td>
                <td><img class="img-fluid avatar-sm rounded"
                        src="{{ asset('storage/images/users/' . $user->photo) }}" /></td>
                <td>{{ $user->account[0]->name }}</td>
                <td>
                    @if ($user->status === 1) <span
                        class="badge bg-success">Active</span> @elseif ($user->status === 0)
                        <span class="badge label-table bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary btn-sm dropdown-toggle"
                            title="New Email" href="javascript: void(0);" data-bs-target="#send-mail-modal"
                            data-bs-toggle="modal"
                            onclick="setToEmailValues({{ getElementByName('users') }}, {{ $user->id }});"><i
                                class="mdi mdi-email-edit-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary btn-sm dropdown-toggle"
                            title="New Sms" data-bs-target="#sms-modal" data-bs-toggle="modal"
                            onclick="setToContactValues({{ getElementByName('users') }}, {{ $user->id }});">
                            <i class="mdi mdi-message-text-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary btn-sm dropdown-toggle"
                            title="Call" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fe-phone-call"></i></a>
                        <div class="dropdown-menu">
                            @foreach ($sip_accounts as $key => $sip_account)
                                <a id="button-call-one" class="dropdown-item" href="#call-one-modal"
                                    data-backdrop="false" data-bs-toggle="modal"
                                    data-sipaccount-username="{{ $sip_account->username }}"
                                    onclick="setContactDataValues({{ getElementByName('users') }}, {{ $user->id }});">
                                    <img src="{{ asset('images/contact_data/mobile.png') }}" alt="contact-data-logo"
                                        height="12" class="me-1">{{ $sip_account->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    @if ($user->status == 0)
                        <div class="btn-group mb-2">
                            <a id="button-edit-{{ $user->id }}" class="btn- btn-xs btn-secondary"
                                href="javascript: void(0);" data-bs-toggle="" data-bs-target="#edit-modal" title="Edit"
                                onclick="#"><i class="mdi mdi-square-edit-outline"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a id="button-delete-{{ $user->id }}"
                                class="btn btn-danger btn-xs waves-effect waves-light" href="javascript: void(0);"
                                title="Delete" onclick="#"><i class="mdi mdi-delete-circle"></i></a>
                        </div>
                    @else
                        <div class="btn-group mb-2">
                            <a id="button-edit-{{ $user->id }}" class="btn- btn-xs btn-secondary"
                                href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                                title="Edit" onclick="editUser({{ $user->id }});"><i
                                    class="mdi mdi-square-edit-outline"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a id="button-delete-{{ $user->id }}"
                                class="btn btn-danger btn-xs waves-effect waves-light" href="javascript: void(0);"
                                title="Delete" onclick="deleteUser({{ $user->id }});"><i
                                    class="mdi mdi-delete-circle"></i></a>
                        </div>
                    @endif
                    <div class="btn-group mb-2">
                        <a class="btn btn-secondary btn-xs waves-effect waves-light"
                            href="{{ route('users.view', $user->id) }}" title="click here for more details"><i
                                class="fe-external-link"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>id</th>
            <th>username</th>
            <th class="select role">role</th>
            <th class="disabled">photo</th>
            <th class="select account">account</th>
            <th class="select status">status</th>
            <th class="disabled">Action</th>
        </tr>
    </tfoot>
</table>
