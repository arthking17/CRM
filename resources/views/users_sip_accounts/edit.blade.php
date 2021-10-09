    <!-- Modal -->
    <div class="modal fade" id="edit-users_sip_account-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="modal-title">Edit User SIP Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" id="edit-users_sip_account" method="POST" action="#" data-parsley-validate=""
                    novalidate>
                    <div class="modal-body p-4">
                        <div class="row">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" id="edit-users_sip_account-id">
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
                                        <label for="edit-users_sip_account-user_id" class="form-label">User</label>
                                        <select class="form-select @error('user_id') parsley-error @enderror"
                                            name="user_id" id="edit-users_sip_account-user_id"
                                            required data-parsley-length="[1, 10]"
                                            data-parsley-length-message="select an account">
                                            <option>select an account</option>
                                            @foreach ($users as $key => $user)
                                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-users_sip_account-sipaccount_id" class="form-label">SIP Account</label>
                                        <select class="form-select @error('sipaccount_id') parsley-error @enderror"
                                            name="sipaccount_id" id="edit-users_sip_account-sipaccount_id"
                                            required data-parsley-length="[1, 10]"
                                            data-parsley-length-message="select an sip account">
                                            <option>select an sip account</option>
                                            @foreach ($sip_accounts as $key => $sip_account)
                                                <option value="{{ $sip_account->id }}">{{ $sip_account->name }} @if(isset($sip_account->users_sipaccount[0])) used @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-edit-users_sip_account" class="btn btn-info waves-effect waves-light"><i
                                class="mdi mdi-content-save"></i>Save</button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="$('#edit-users_sip_account-modal').modal('toggle')"><i
                                class="fe-x me-1"></i>Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
