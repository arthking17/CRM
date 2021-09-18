    <!-- Modal -->
    <div class="modal fade" id="edit-sms_account-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="modal-title">Edit an SMS Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" id="edit-sms_account" method="POST" action="#" data-parsley-validate=""
                    novalidate>
                    <div class="modal-body p-4">
                        <div class="row">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" id="edit-sms_account-id">
                            <div class="col-12">
                                <div class="text-center">
                                    <div class="alert alert-warning d-none fade show">
                                        <h4 class="mt-0 text-warning">Oh snap!</h4>
                                        <p class="mb-0">This form seems to be invalid :(</p>
                                        <p class="mb-0">Go back and check your data</p>
                                    </div>

                                    <div class="alert alert-info d-none fade show">
                                        <h4 class="mt-0 text-info">Yay!</h4>
                                        <p class="mb-0">Everything seems to be ok :)</p>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-sms_account-account_id" class="form-label">Account</label>
                                        <input type="text" class="form-select" name="account_id"
                                            id="edit-sms_account-account_id" disabled
                                            value="{{ Auth::user()->account[0]->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-sms_account-name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="edit-sms_account-name" name="name"
                                            placeholder="Name" required>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-sms_account-username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="edit-sms_account-username"
                                            name="username" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-sms_account-pwd" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="edit-sms_account-pwd"
                                            name="pwd" placeholder="Password">
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-edit-sms_account"
                            class="btn btn-info waves-effect waves-light"><i class="mdi mdi-content-save"></i>Save</button>
                            <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                                onclick="$('#edit-sms_account-modal').modal('toggle')"><i
                                    class="fe-x me-1"></i>Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
