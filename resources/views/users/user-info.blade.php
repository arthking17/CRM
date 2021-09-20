<div class="row">
    <div class="col-sm-3">
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
                        {{ $user->account[0]->name }}</p>
                    <p id="user_id" class="text-muted d-none"> {{ $user->id }}</p>

                    <a href="javascript: void(0);" class="btn- btn-xs btn-info" title="New Email"><i
                            class="mdi mdi-email-edit-outline"></i></a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-info" title="New Sms"><i
                            class="mdi mdi-message-text-outline"></i></a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-info" title="Call"><i
                            class="fe-phone-call"></i></a>
                    @if ($user->status == 0)
                        <a id="delete-{{ $user->id }}" class="btn- btn-xs btn-danger" title="Delete User"
                            href="javascript: void(0);"><i
                                class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a id="delete-{{ $user->id }}" class="btn- btn-xs btn-danger" title="Delete User"
                            href="javascript: void(0);" onclick="deleteUser({{ $user->id }});"><i
                                class="mdi mdi-delete-circle"></i></a>
                    @endif
                </div>

                @if ($user->status == 0)
                    <a id="btn-edit-{{ $user->id }}" class="btn-primary-outline" href="javascript: void(0);" title="edit user"><i
                            class="mdi mdi-square-edit-outline"></i></a>
                @else
                    <a id="btn-edit-{{ $user->id }}" class="btn-primary-outline" title="edit user"
                        href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                        onclick="editUser({{ $user->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                @endif

            @endisset
        </div>
        <div class="d-flex justify-content-center">
            <a href="javascript: void(0);" class="btn- btn-xs btn-danger" data-bs-toggle="modal"
                onclick="$('#edit-user-password-id').val({{ $user->id }})" data-bs-target="#security-modal"><i
                    class="mdi mdi-account-key-outline"></i> Edit
                password</a>
        </div>
    </div>

    @isset($user)
        <div class="col-sm-3">
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
            <p class="mb-3"> {{ getLanguageName($user->language) }}</p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Timezone :</h4>
            <p class="mb-3"> {{ $user->timezone }}</p>
        </div>

        <div class="col-sm-3">

            <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
            <p class="mb-3" id="user-status">
                @if ($user->status === 1) <span class="badge bg-success">Active</span>
                @elseif ($user->status === 0)
                    <span class="badge label-table bg-danger">Disabled</span>
                @endif
            </p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Ip Address :</h4>
            <p class="mb-3"> {{ $user->ip_address }}</p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Last Authentification :</h4>
            <p class="mb-3"> {{ $user->last_auth }}</p>
        </div>
        <div class="col-sm-3">

            <h4 class="font-13 text-muted text-uppercase mb-1">Browser :</h4>
            <p class="mb-3"> {{ $user->browser }}</p>
        </div>
    @endisset
</div>
