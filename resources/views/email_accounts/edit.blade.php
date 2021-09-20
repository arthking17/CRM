    <!-- Modal -->
    <div class="modal fade" id="edit-email_account-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Email Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-email-account" method="POST" action="#" data-parsley-validate="" novalidate>
                    <div class="modal-body p-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit-email-account-id" required>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-host" class="form-label">Host</label>
                                    <input type="text" class="form-control" id="edit-email-account-host" name="host"
                                        placeholder="Host" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-account_id" class="form-label">Account</label>
                                    @if (Auth::user()->role == 2)
                                        <input type="text" class="form-select d-none" name="account_id"
                                            id="edit-email-account-account_id"
                                            value="{{ Auth::user()->account_id }}">
                                    @endif
                                    <select class="form-select @error('account_id') parsley-error @enderror"
                                        name="account_id" @if (Auth::user()->role === 2) id="edit-email-account-account_id-disabled" @elseif (Auth::user()->role === 1) id="edit-email-account-account_id" @endif
                                        required data-parsley-length="[1, 10]"
                                        data-parsley-length-message="select an account" @if (Auth::user()->role == 2) disabled value="{{ Auth::user()->account_id }}" @endif>
                                        <option>select an account</option>
                                        @foreach ($accounts as $key => $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="edit-email-account-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit-email-account-email"
                                        name="email" placeholder="Email" required>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="edit-email-account-username"
                                        name="username" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-pwd" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="edit-email-account-pwd" name="pwd"
                                        placeholder="Password">
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-smtpauth" class="form-label">Do you want a
                                        SMTPAuth ?</label>
                                    <select class="form-select @error('smtpauth') parsley-error @enderror"
                                        name="smtpauth" id="edit-email-account-smtpauth" required
                                        data-parsley-length="[1, 1]">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-smtpsecure" class="form-label">SMTPSecure</label>
                                    <select class="form-select @error('smtpsecure') parsley-error @enderror"
                                        name="smtpsecure" id="edit-email-account-smtpsecure" required
                                        data-parsley-length="[1, 1]" data-parsley-length-message="select a SMTPSecure">
                                        <option>select a SMTPSecure</option>
                                        <option value="1">TLS</option>
                                        <option value="2">SSL</option>
                                        <option value="3">NOTLS</option>
                                        <option value="4">STARTTLS</option>
                                    </select>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-type" class="form-label">Email Type</label>
                                    <select class="form-select @error('type') parsley-error @enderror" name="type"
                                        id="edit-email-account-type" required data-parsley-length="[1, 1]"
                                        data-parsley-length-message="select an email type">
                                        <option>select an email type</option>
                                        <option value="1">Unitary</option>
                                        <option value="0">Max Marketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit-email-account-port" class="form-label">Port</label>
                                    <input type="number" class="form-control" id="edit-email-account-port" name="port"
                                        placeholder="Port" required>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-edit-email-account"
                            class="btn btn-info waves-effect waves-light"><i
                                class="mdi mdi-content-save"></i>Save</button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="$('#edit-email_account-modal').modal('toggle')"><i
                                class="fe-x me-1"></i>Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
