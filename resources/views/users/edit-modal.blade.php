    <!-- Modal -->
    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-user" id="create-user" method="POST" action="{{ route('user.create') }}"
                                data-parsley-validate="" novalidate  enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="username" class="col-4 col-xl-3 col-form-label">username<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="text"
                                                    class="form-control @error('username') parsley-error @enderror"
                                                    id="username" name="username" placeholder="username" required
                                                    data-parsley-minlength="3" pattern="[a-z]{2,}[0-9]*"
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
                                            <label for="login" class="col-4 col-xl-3 col-form-label">login<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="text"
                                                    class="form-control @error('login') parsley-error @enderror"
                                                    id="login" name="login" placeholder="login" required
                                                    data-parsley-minlength="3" pattern="[a-z]{2,}[0-9]*"
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
                                            <label for="pwd" class="col-4 col-xl-3 col-form-label">password<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="password"
                                                    class="form-control @error('pwd') parsley-error @enderror"
                                                    id="pwd" name="pwd" placeholder="password" required
                                                    data-parsley-minlength="3"
                                                    pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?).{8,}$"
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
                                            <label for="role" class="col-4 col-xl-3 col-form-label">role<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('role') parsley-error @enderror"
                                                    name="role" required data-parsley-type="integer"
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
                                            <label for="language" class="col-4 col-xl-3 col-form-label">language<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('language') parsley-error @enderror"
                                                    name="language" id="language" required
                                                    data-parsley-length="[2, 5]">
                                                    <option>Select a language</option>
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
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="timezone" class="col-4 col-xl-3 col-form-label">timezone<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('timezone') parsley-error @enderror"
                                                    name="timezone" id="timezone" required>
                                                        <option value="">Select a timezone</option>
                                                </select>
                                                @error('timezone')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('timezone') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="browser" class="col-4 col-xl-3 col-form-label">browser<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="browser"
                                                    class="form-control @error('browser') parsley-error @enderror"
                                                    id="browser" name="browser" placeholder="browser" required>
                                                @error('browser')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('browser') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="ip_address" class="col-4 col-xl-3 col-form-label">ip_address<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="ip_address"
                                                    class="form-control @error('ip_address') parsley-error @enderror"
                                                    id="ip_address" name="ip_address" placeholder="ip_address" required
                                                    pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^(?:(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-fA-F]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:(?:[0-9a-fA-F]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,1}(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:(?:[0-9a-fA-F]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,2}(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:(?:[0-9a-fA-F]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,3}(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:[0-9a-fA-F]{1,4})):)(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,4}(?:(?:[0-9a-fA-F]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,5}(?:(?:[0-9a-fA-F]{1,4})))?::)(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,6}(?:(?:[0-9a-fA-F]{1,4})))?::))))$"
                                                    pattern="^(?=\d+\.\d+\.\d+\.\d+$)(?:(?:25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])\.?){4}$"
                                                    data-parsley-pattern-message="This value should be a valid ip address">
                                                @error('ip_address')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('ip_address') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="account_id" class="col-4 col-xl-3 col-form-label">account<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('account_id') parsley-error @enderror"
                                                    name="account_id" required data-parsley-type="integer">
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
                                        <div class="row mb-3">
                                            <label for="photo" class="col-4 col-xl-3 col-form-label">photo<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="file"
                                                    class="form-control @error('photo') parsley-error @enderror"
                                                    id="photo" name="photo" placeholder="photo" required
                                                    data-parsley-fileextension='jpg,png,jpeg'>
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
                                </div>
                                <!-- end row-->
                                <button type="submit" id="create"
                                    class="btn btn-info waves-effect waves-light">Create</button>
                            </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
