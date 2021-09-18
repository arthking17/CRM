    <!-- Modal -->
    <div class="modal fade" id="create-account-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="form-horizontal parsley-account" id="create-account" method="POST" action="#"
                    data-parsley-validate="" novalidate>
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Add Account</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        @csrf
                        <div class="row mb-3">
                            <label for="create-account-name" class="col-4 col-xl-3 col-form-label">Name<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <input type="text" class="form-control @error('name') parsley-error @enderror"
                                    id="create-account-name" name="name" placeholder="Name" required
                                    data-parsley-minlength="3">
                                @error('name')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('name') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="create-account-url" class="col-4 col-xl-3 col-form-label">Url<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <input type="url" class="form-control @error('url') parsley-error @enderror"
                                    id="create-account-url" name="url" placeholder="Url" required
                                    data-parsley-type="url" data-parsley-maxlength="128">
                                @error('url')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('url') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="create-account-status" class="col-4 col-xl-3 col-form-label">Status<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <select class="form-select @error('status') parsley-error @enderror" name="status"
                                    id="create-account-status" required data-parsley-type="integer"
                                    data-parsley-length="[1, 1]">
                                    <option value="1">Active</option>
                                    <option value="2">Legit</option>
                                    <option value="3">Invoicing</option>
                                </select>
                                @error('status')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('status') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-create" class="btn btn-info waves-effect waves-light"><i
                                class="mdi mdi-plus-circle"></i>Create</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"><i
                                class="fe-x me-1"></i>Reset</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
