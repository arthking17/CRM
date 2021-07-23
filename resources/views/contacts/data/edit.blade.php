    <!-- Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Group</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal" id="edit-group" method="POST" action="#" data-parsley-validate=""
                        novalidate enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit-group-id">
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
                            <div class="row mb-3">
                                <label for="edit-group-account_id" class="col-4 col-xl-3 col-form-label">account<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('account_id') parsley-error @enderror"
                                        name="account_id" id="edit-group-account_id" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
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
                            <div class="row mb-3">
                                <label for="edit-group-name" class="col-4 col-xl-3 col-form-label">Name<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control @error('name') parsley-error @enderror"
                                        name="name" id="edit-group-name" placeholder="name" required
                                        data-parsley-minlength="3"
                                        data-parsley-pattern-message="This value should be a valid name">
                                    @error('name')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('name') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>



                        </div>
                        <!-- end row-->
                        <button type="submit" id="btn-edit" class="btn btn-info waves-effect waves-light">Save</button>
                        <a id="btn-delete" href="javascript: void(0);" onclick="$('#edit-modal').modal('toggle')"
                            class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>Cancel</a>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
