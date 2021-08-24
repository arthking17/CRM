    <!-- Modal -->
    <div class="modal fade" id="create-sip_account-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Sip Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal" id="create-sip_account" method="POST" action="#"
                        data-parsley-validate="" novalidate>
                        <div class="row">
                            @csrf
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
                                        <label for="create-sip_account-account_id" class="form-label">Account</label>
                                        <select class="form-select"
                                            name="account_id" id="create-sip_account-account_id" disabled>
                                            <option value="">choose an account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}" @if(Auth::user()->account_id == $account->id) selected @endif>{{ $account->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-channel_id" class="form-label">Channel</label>
                                        <select class="form-select @error('channel_id') parsley-error @enderror"
                                            name="channel_id" id="create-sip_account-channel_id" required
                                            data-parsley-type="integer" data-parsley-length="[1, 10]">
                                            <option value="">choose a channel</option>
                                            @foreach ($channels as $channel)
                                                <option value="{{ $channel->id }}">{{ $channel->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-host" class="form-label">Host</label>
                                        <input type="text" class="form-control" id="create-sip_account-host" name="host"
                                            placeholder="Host" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-port" class="form-label">Port</label>
                                        <input type="number" class="form-control" id="create-sip_account-port"
                                            name="port" placeholder="Port" required>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="create-sip_account-username"
                                            name="username" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-pwd" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="create-sip_account-pwd"
                                            name="pwd" placeholder="Password" required>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-name" class="form-label">Name</label>
                                        <input type="name" class="form-control" id="create-sip_account-name" name="name"
                                            placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create-sip_account-priority" class="form-label">Priority</label>
                                        <select class="form-select @error('priority') parsley-error @enderror"
                                            name="priority" id="create-sip_account-priority" required
                                            data-parsley-length="[1, 1]"
                                            data-parsley-length-message="select a Priority">
                                            <option>select a priority</option>
                                            <option value="1">low</option>
                                            <option value="2">normal</option>
                                            <option value="3">high</option>
                                        </select>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="text-end">
                                <button type="submit" id="btn-create-sip_account"
                                    class="btn btn-info waves-effect waves-light">Create</button>
                                <button type="reset" class="btn btn-light waves-effect waves-light m-1"><i
                                        class="fe-x me-1"></i>Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
