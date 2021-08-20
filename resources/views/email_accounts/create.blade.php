    <!-- Modal -->
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Email Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="create-email-account" method="POST" action="#" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-host" class="form-label">Host</label>
                                    <input type="text" class="form-control" id="create-email-account-host" name="host"
                                        placeholder="Host" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="create-email-account-email" name="email"
                                        placeholder="Email" required>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="create-email-account-username"
                                        name="username" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-pwd" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="create-email-account-pwd"
                                        name="pwd" placeholder="Password" required>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-smtpauth" class="form-label">Do you want a SMTPAuth ?</label>
                                    <select class="form-select @error('smtpauth') parsley-error @enderror"
                                        name="smtpauth" id="create-email-account-smtpauth" required
                                        data-parsley-length="[1, 1]">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-smtpsecure" class="form-label">SMTPSecure</label>
                                    <select class="form-select @error('smtpsecure') parsley-error @enderror"
                                        name="smtpsecure" id="create-email-account-smtpsecure" required
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
                                    <label for="create-email-account-type" class="form-label">Email Type</label>
                                    <select class="form-select @error('type') parsley-error @enderror" name="type"
                                        id="create-email-account-type" required data-parsley-length="[1, 1]"
                                        data-parsley-length-message="select an email type">
                                        <option>select an email type</option>
                                        <option value="1">Unitary</option>
                                        <option value="0">Max Marketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="create-email-account-port" class="form-label">Port</label>
                                    <input type="number" class="form-control" id="create-email-account-port" name="port"
                                        placeholder="Port" required>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="text-end">
                            <button type="submit" id="btn-create-email-account"
                                class="btn btn-success waves-effect waves-light mt-2"><i
                                    class="mdi mdi-plus-circle"></i> Create</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
