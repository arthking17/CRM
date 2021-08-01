    <!-- Modal -->
    <div class="modal fade" id="security-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-light" id="myCenterModalLabel">Edit password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal needs-validation" id="edit-user-password" method="POST" action="#"
                        novalidate enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <input type="number" name="id" id="edit-user-password-id" hidden>
                                <label for="edit-user-password-pwd"
                                    class="col-4 col-xl-3 col-form-label">password</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                        <input type="password" id="edit-user-password-pwd" name="pwd"
                                            class="form-control @error('pwd') parsley-error @enderror"
                                            placeholder="Enter your password"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                                            data-parsley-pattern-message="This value should be a valid password" required>
                                        @error('pwd')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('pwd') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-user-password-confirm-pwd"
                                    class="col-4 col-xl-3 col-form-label">Confirm Password</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                        <input type="password" id="edit-user-password-confirm-pwd" name="confirm-pwd"
                                            class="form-control @error('confirm-pwd') parsley-error @enderror"
                                            placeholder="Re-Enter your password"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                                            data-parsley-pattern-message="This value should be a valid password" required>
                                        @error('confirm-pwd')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm-pwd') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <button type="submit" class="btn btn-info waves-effect waves-light">Edit</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light"
                            onclick="$('#security-modal').modal('toggle')">Cancel</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
