<div class="row">
    <div class="col-sm-4">
        <div class="d-flex align-items-start mb-3">
            @isset($user)
                <form id="form-edit-user-photo" method="POST" action="#" data-parsley-validate="" novalidate
                    enctype="multipart/form-data">
                    <div class="d-flex me-3 profile-pic">
                        @csrf
                        @method('PUT')
                        <input type="number" name="id" id="form-edit-user-photo-id" value="{{ $user->id }}" required
                            data-parsley-fileextension='jpg,png,jpeg' hidden>
                        <label class="-label" for="form-edit-user-photo-file">
                            <span class="glyphicon glyphicon-camera"></span>
                            <span>Change</span>
                        </label>
                        <input id="form-edit-user-photo-file" type="file" name="photo" onchange="updateUserPhoto(event)" />
                        <img id="user-photo" class="rounded-circle avatar-lg"
                            src="{{ asset('storage/images/users/' . $user->photo) }}" alt="Generic placeholder image">
                    </div>
                </form>
                <div class="w-100" id="user-info1">
                    <h4 class="mt-0 mb-1">{{ $user->username }}</h4>
                    <p class="text-muted">{{ $user->login }}</p>
                    <p class="text-muted"><i class="mdi mdi-office-building"></i>
                        {{ $user->account->name }}</p>
                    <p id="user_id" class="text-muted d-none">{{ $user->id }}</p>

                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary btn-sm dropdown-toggle" title="New Email"
                            href="javascript: void(0);" data-bs-target="#send-mail-modal" data-bs-toggle="modal"
                            onclick="setToEmailValues({{ getElementByName('users') }}, {{ $user->id }});"><i
                                class="mdi mdi-email-edit-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary btn-sm dropdown-toggle" title="New Sms"
                            data-bs-target="#sms-modal" data-bs-toggle="modal"
                            onclick="setToContactValues({{ getElementByName('users') }}, {{ $user->id }});">
                            <i class="mdi mdi-message-text-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary btn-sm dropdown-toggle" title="Call"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fe-phone-call"></i></a>
                        <div class="dropdown-menu">
                            @foreach ($sip_accounts as $key => $sip_account)
                                <a id="button-call-one" class="dropdown-item" href="#call-one-modal" data-backdrop="false"
                                    data-bs-toggle="modal" data-sipaccount-username="{{ $sip_account->username }}"
                                    onclick="setContactDataValues({{ getElementByName('users') }}, {{ $user->id }});">
                                    <img src="{{ asset('images/contact_data/mobile.png') }}" alt="contact-data-logo"
                                        height="12" class="me-1">{{ $sip_account->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    @if ($user->status == 0)
                        <div class="btn-group mb-2">
                            <a id="btn-edit-{{ $user->id }}" class="btn- btn-xs btn-secondary" href="javascript: void(0);"
                                title="edit user"><i class="mdi mdi-square-edit-outline"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a id="delete-{{ $user->id }}" class="btn- btn-xs btn-danger" title="Delete User"
                                href="javascript: void(0);"><i class="mdi mdi-delete-circle"></i></a>
                        </div>
                    @else
                        <div class="btn-group mb-2">
                            <a id="btn-edit-{{ $user->id }}" class="btn- btn-xs btn-secondary" title="edit user"
                                href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                                onclick="editUser({{ $user->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a id="delete-{{ $user->id }}" class="btn- btn-xs btn-danger" title="Delete User"
                                href="javascript: void(0);" onclick="deleteUser({{ $user->id }});"><i
                                    class="mdi mdi-delete-circle"></i></a>
                        </div>
                    @endif
                </div>

            @endisset
        </div>
        <div class="d-flex justify-content-center">
            <a href="javascript: void(0);" class="btn- btn-xs btn-danger" data-bs-toggle="modal"
                onclick="$('#edit-user-password-id').val({{ $user->id }})" data-bs-target="#security-modal"><i
                    class="mdi mdi-account-key-outline"></i> Edit
                password</a>
        </div>
        <br>
    </div>

    @isset($user)
        <div class="col-sm-2">
            <h4 class="font-13 text-muted text-uppercase">Role :</h4>
            <p class="mb-3">
                @if ($user->role === 1)
                    <span class="badge label-table bg-danger">Admin</span>
                @elseif($user->role === 2)
                    <span class="badge bg-success">User</span>
                @elseif($user->role === 3)
                    <span class="badge bg-blue text-light">Visitor</span>
                @endif
            </p>

            <h4 class="font-13 text-muted text-uppercase mb-1">language :</h4>
            <p class="mb-3"> {{ getLanguageName($user->language) }}</p>
        </div>

        <div class="col-sm-2">

            <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
            <p class="mb-3" id="user-status">
                @if ($user->status === 1) <span class="badge bg-success">Active</span>
                @elseif ($user->status === 0)
                    <span class="badge label-table bg-danger">Disabled</span>
                @endif
            </p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Ip Address :</h4>
            <p class="mb-3"> {{ $user->ip_address }}</p>
        </div>
        <div class="col-sm-2">

            <h4 class="font-13 text-muted text-uppercase mb-1">Last Authentification :</h4>
            <p class="mb-3"> {{ $user->last_auth }}</p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Timezone :</h4>
            <p class="mb-3"> {{ $user->timezone }}</p>
        </div>
        <div class="col-sm-2">

            <h4 class="font-13 text-muted text-uppercase mb-1">Browser :</h4>
            <p class="mb-3"> {{ $user->browser }}</p>
        </div>
    @endisset
</div>
