    <!-- Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="form-horizontal parsley-account" id="edit-account" method="POST" action="#"
                    data-parsley-validate="" novalidate>
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Edit Account</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        @csrf
                        @method('PUT')
                        <input type="number" name="id" id="edit-account-id" hidden>
                        <div class="mb-3">
                            <label for="edit-account-name" class="col-4 col-xl-3 col-form-label">Name<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <input type="text" class="form-control @error('name') parsley-error @enderror"
                                    id="edit-account-name" name="name" placeholder="Name" required
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
                        <div class="mb-3">
                            <label for="edit-account-url" class="col-4 col-xl-3 col-form-label">Url<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <input type="url" class="form-control @error('url') parsley-error @enderror"
                                    id="edit-account-url" name="url" placeholder="Url" required data-parsley-type="url"
                                    data-parsley-maxlength="128">
                                @error('url')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('url') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-account-state" class="col-4 col-xl-3 col-form-label">Status<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <select class="form-select @error('status') parsley-error @enderror" name="status"
                                    id="edit-account-status" required data-parsley-type="integer"
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
                        <button type="submit" class="btn btn-success waves-effect waves-light save"
                            id="btn-edit"><i class="mdi mdi-content-save"></i>Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light"
                            onclick="$('#edit-modal').modal('toggle');">Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
