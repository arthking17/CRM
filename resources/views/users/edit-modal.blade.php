    <!-- Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-user" id="edit-user" method="POST" action="#"
                        data-parsley-validate="" novalidate enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <input type="number" name="id" id="edit-user-id" hidden>
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <label for="edit-user-username" class="col-4 col-xl-3 col-form-label">username<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="text"
                                            class="form-control @error('username') parsley-error @enderror"
                                            id="edit-user-username" name="username" placeholder="username" required
                                            data-parsley-minlength="3"
                                            pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                            data-parsley-pattern-message="This value should be a valid username">
                                        <span class="parsley-errors-list username_error"></span>
                                        @error('username')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('username') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-user-login" class="col-4 col-xl-3 col-form-label">login<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="text" class="form-control @error('login') parsley-error @enderror"
                                            id="edit-user-login" name="login" placeholder="login" required
                                            data-parsley-minlength="3"
                                            pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                            data-parsley-pattern-message="This value should be a valid login">
                                        <span class="parsley-errors-list login_error"></span>
                                        @error('login')
                                            <ul class="parsley-errors-list filled" id="error-login" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('login') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" id="success-login" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-user-pwd" class="col-4 col-xl-3 col-form-label">password</label>
                                    <div class="col-8 col-xl-9">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                            <input type="password" id="edit-user-pwd" name="pwd" class="form-control @error('pwd') parsley-error @enderror" 
                                            placeholder="Enter your password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                                                data-parsley-pattern-message="This value should be a valid password">
                                            @error('pwd')
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('pwd') }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <label for="edit-user-role" class="col-4 col-xl-3 col-form-label">role<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select class="form-select @error('role') parsley-error @enderror" name="role"
                                            id="edit-user-role" required data-parsley-type="integer"
                                            data-parsley-length="[1, 1]">
                                            <option value="1">admin</option>
                                            <option value="2">user</option>
                                            <option value="3">visitor</option>
                                        </select>
                                        @error('role')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('role') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-user-language" class="col-4 col-xl-3 col-form-label">language<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select class="form-select @error('language') parsley-error @enderror"
                                            name="language" id="edit-user-language" required
                                            data-parsley-length="[2, 2]"
                                            data-parsley-length-message="select a language">
                                            <option>Select a language</option>
                                            <option value="ar">Arabic - العربية</option>
                                            <option value="en">English</option>
                                            <option value="fr">French - français</option>
                                            <option value="es">Spanish - español</option>
                                        </select>
                                        @error('language')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('language') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-user-account_id" class="col-4 col-xl-3 col-form-label">account<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select class="form-select @error('account_id') parsley-error @enderror"
                                            name="account_id" id="edit-user-account_id" required
                                            data-parsley-type="integer" data-parsley-length="[1, 10]">
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('account_id')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('account_id') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <input name="status" value="1" hidden>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-user-photo" class="col-4 col-xl-3 col-form-label">photo<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <div class="d-flex me-3 profile-pic">
                                        <label class="-label" for="edit-user-photo">
                                            <span class="glyphicon glyphicon-camera"></span>
                                            <span>Change</span>
                                        </label>
                                        <input id="edit-user-photo" type="file" name="photo"
                                            onchange="updateUserPhotoImg(event)"
                                            data-parsley-fileextension='jpg,png,jpeg' />
                                        <img id="edit-user-photo-img" class="rounded-circle avatar-lg" src=""
                                            alt="Generic placeholder image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <button type="submit" id="btn-edit" class="btn btn-info waves-effect waves-light">Edit</button>
                        <button type="button" id="btn-delete" class="btn btn-danger waves-effect waves-light"
                            onclick="deleteUser({{ $user->id }});">Delete</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
