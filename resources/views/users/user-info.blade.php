<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($user)
                <img id="user-photo" class="d-flex me-3 rounded-circle avatar-lg"
                    src="{{ asset('storage/images/users/' . $user->photo) }}" alt="Generic placeholder image">
                <div class="w-100" id="user-info1">
                    <h4 class="mt-0 mb-1">{{ $user->username }}</h4>
                    <p class="text-muted">{{ $user->login }}</p>
                    <p class="text-muted"><i class="mdi mdi-office-building"></i>
                        {{ $user->account[0]->name }}</p>
                    <p class="text-muted d-none"> {{ $user->id }}</p>

                    <a href="javascript: void(0);" class="btn- btn-xs btn-info">Send Email</a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-info">Send Sms</a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-secondary">Call</a>
                    @if ($user->status == 0)
                        <a id="button-edit-{{ $user->id }}" class="btn- btn-xs btn-secondary"
                            href="javascript: void(0);" data-bs-toggle="" data-bs-target="#edit-modal" onclick="#">Edit</a>
                    @else
                        <a id="button-edit-{{ $user->id }}" class="btn- btn-xs btn-secondary"
                            href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                            onclick="editUser({{ $user->id }});">Edit</a>
                    @endif
                </div>
            @endisset
        </div>

        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>
            Personal Information</h5>
        <div class="" id="user-info2">
            @isset($user)
                <h4 class="font-13 text-muted text-uppercase">Role :</h4>
                <p class="mb-3">
                    @if ($user->role === 1) <span
                            class="badge label-table bg-danger">Admin</span>
                    @elseif($user->role === 2)
                        <span class="badge bg-success">User</span>
                    @elseif($user->role === 3)
                        <span class="badge bg-blue text-light">Visitor</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">language :</h4>
                <p class="mb-3"> {{ $user->language }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Timezone :</h4>
                <p class="mb-3"> {{ $user->timezone }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Browser :</h4>
                <p class="mb-3"> {{ $user->browser }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Ip Address :</h4>
                <p class="mb-3"> {{ $user->ip_address }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
                <p class="mb-3">
                    @if ($user->status === 1) <span class="badge bg-success">Active</span>
                    @elseif ($user->status === 0)
                        <span class="badge label-table bg-danger">Disabled</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Last Authentification :</h4>
                <p class="mb-3"> {{ $user->last_auth }}</p>

                <a href="javascript: void(0);" class="btn- btn-xs btn-warning" data-bs-toggle=""
                    onclick="viewLogs({{ $user->id }});" data-bs-target="#logs-modal"><i
                        class="mdi mdi-history me-1"></i>View activity
                    logs</a>
                <a href="javascript: void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle=""
                    onclick="viewUsers_Permissions({{ $user->id }});" data-bs-target="#users_permissions-modal"><i
                        class="mdi mdi-key-chain me-1"></i>View permissions</a>
                <a href="javascript: void(0);" class="btn- btn-xs btn-danger" data-bs-toggle="modal"
                    onclick="addPermission({{ $user->id }}, '{{ $user->username }}');"
                    data-bs-target="#create-permission-modal"><i class="mdi mdi-key-plus me-1"></i>Add permission</a>
                <a href="javascript: void(0);" class="btn- btn-xs btn-info" data-bs-toggle=""
                    onclick="viewNotification({{ $user->id }});" data-bs-target="#notification-modal"><i
                        class="mdi mdi-bell-plus-outline me-1"></i>Notification</a>
                <a href="javascript: void(0);" class="btn- btn-xs btn-danger" data-bs-toggle="modal" onclick="#"
                    data-bs-target="#security-modal"><i class="mdi mdi-account-key-outline me-1"></i>Security</a>
            @endisset
        </div>
    </div>
</div> <!-- end card-->
<div class="card">
    <div class="card-body" id="card-note">
        <h4 class="mb-1 mt-1 text-uppercase bg-light p-1"><i class="mdi mdi-note-text-outline me-1"></i>
            Note</h4>
        <div class="card border-success border mb-3">
            <div class="card-body" id="card-note-body">
                @isset($user)
                    @foreach ($notes as $note)
                        @if ($note->element_id === $user->id)
                            <h4 class="card-title text-success">{{ getNoteClassName($note->class) }}</h4>
                            <p class="card-text">
                                {{ $note->content }}
                            </p>
                        @break
                    @endif
                    @endforeach
                @endisset
            </div>
        </div>
        @isset($user)
            <a href="javascript: void(0);" class="btn- btn-xs btn-success" data-bs-toggle="modal"
                data-bs-target="#add_note-modal" data-id="{{ $user->id }}" data-element="16"><i
                    class="mdi mdi-plus-circle me-1"></i>Add note</a>
            <a href="javascript: void(0);" class="btn- btn-xs" data-bs-toggle="" data-bs-target="#notes-modal"
                onclick="viewNotes({{ $user->id }});"><i class="mdi mdi-plus-circle me-1"></i>voir plus</a>
        @endisset
    </div>
</div>
