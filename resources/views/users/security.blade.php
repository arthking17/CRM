    <!-- Modal -->
    <div class="modal fade" id="add_permission-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-light" id="myCenterModalLabel">Add Permission</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-note" id="create-permissions" method="POST" action="#"
                        data-parsley-validate="" novalidate>
                        <div class="row">
                            @csrf
                            <input type="number" id="create-permissions-user_id" name="user_id" value="" hidden />
                            <div class="row mb-3">
                                <label for="username" class="col-4 col-xl-3 col-form-label">username</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control @error('username') parsley-error @enderror"
                                        id="create-permissions-username" name="username" placeholder="username" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-4 col-xl-3 col-form-label">Code<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control @error('code') parsley-error @enderror"
                                        id="code" name="code" placeholder="code" required>
                                    @error('code')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('code') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="dependency" class="col-4 col-xl-3 col-form-label">dependency<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('dependency') parsley-error @enderror"
                                        name="dependency" required data-parsley-type="integer"
                                        data-parsley-length="[1, 1]">
                                        <option value="0">Default</option>
                                        <option value="1">action need admin validation</option>
                                    </select>
                                    @error('dependency')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('dependency') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <button type="submit" id="btn-create_permissions"
                            class="btn btn-info waves-effect waves-light">Create</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
