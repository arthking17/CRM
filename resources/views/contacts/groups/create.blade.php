    <!-- Modal -->
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-user" id="create-user" method="POST" action="#"
                        data-parsley-validate="" novalidate enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <label for="create-user-username" class="col-4 col-xl-3 col-form-label">username<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="text"
                                            class="form-control @error('username') parsley-error @enderror"
                                            name="username" id="create-user-username" placeholder="username" required data-parsley-minlength="3"
                                            pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                            data-parsley-pattern-message="This value should be a valid username">
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
                                    <label for="create-user-login" class="col-4 col-xl-3 col-form-label">login<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="text" class="form-control @error('login') parsley-error @enderror"
                                            name="login" id="create-user-login" placeholder="login" required data-parsley-minlength="3"
                                            pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                            data-parsley-pattern-message="This value should be a valid login">
                                        @error('login')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('login') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="create-user-pwd" class="col-4 col-xl-3 col-form-label">password<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="password"
                                            class="form-control @error('pwd') parsley-error @enderror" name="pwd" id="create-user-pwd"
                                            placeholder="password" required data-parsley-minlength="3"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                                            data-parsley-pattern-message="This value should be a valid password">
                                        @error('pwd')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('pwd') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8 offset-4">
                                        <div class="checkbox checkbox-purple">
                                            <input id="create-user-showpwd" type="checkbox" onclick="showPassword('create-user-pwd');">
                                            <label for="create-user-showpwd">Show password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <label for="create-user-role" class="col-4 col-xl-3 col-form-label">role<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select class="form-select @error('role') parsley-error @enderror" name="role" id="create-user-role"
                                            required data-parsley-type="integer" data-parsley-length="[1, 1]">
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
                                    <label for="create-user-language" class="col-4 col-xl-3 col-form-label">language<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select class="form-select @error('language') parsley-error @enderror"
                                            name="language" id="create-user-language" required data-parsley-length="[2, 2]"
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
                                    <label for="create-user-account_id" class="col-4 col-xl-3 col-form-label">account<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select class="form-select @error('account_id') parsley-error @enderror"
                                            name="account_id" id="create-user-account_id" required data-parsley-type="integer" data-parsley-length="[1, 10]">
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
                            </div>
                            <div class="row mb-3">
                                <label for="create-user-photo" class="col-4 col-xl-3 col-form-label">photo<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9" id="div-photo">
                                    <input type="file"
                                        class="form-control dropify @error('photo') parsley-error @enderror"
                                        name="photo" id="create-user-photo" data-plugins="dropify" required
                                        data-parsley-fileextension='jpg,png,jpeg' data-height="100px">
                                    @error('photo')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('photo') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <button type="submit" id="btn-create" class="btn btn-info waves-effect waves-light">Create</button>
                        <button type="reset" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>Reset</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
