    <!-- Modal -->
    <div class="modal fade" id="edit-note-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Note</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal parsley-note" id="edit-note" method="POST" action="#"
                    data-parsley-validate="" novalidate>
                    <div class="modal-body p-4">
                        <div class="row">
                            @csrf
                            @method('put')
                            <input type="number" name="id" id="edit-note-id" hidden />
                            <input type="number" name="element" id="edit-note-element" hidden />
                            <input type="number" name="element_id" id="edit-note-element_id" hidden />
                            <div class="row mb-3">
                                <label for="class" class="col-4 col-xl-3 col-form-label">Class<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('class') parsley-error @enderror" name="class"
                                        id="edit-note-class" required data-parsley-type="integer"
                                        data-parsley-length="[1, 1]">
                                        <option value="1">Description</option>
                                        <option value="2">Note</option>
                                        <option value="3">Task</option>
                                    </select>
                                    @error('class')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('class') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="visibility" class="col-4 col-xl-3 col-form-label">Visibility<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('visibility') parsley-error @enderror"
                                        name="visibility" id="edit-note-visibility" required data-parsley-type="integer"
                                        data-parsley-length="[1, 1]">
                                        <option value="1">All</option>
                                        <option value="0">Admin</option>
                                    </select>
                                    @error('visibility')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('visibility') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="content" class="col-4 col-xl-3 col-form-label">Content<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control @error('content') parsley-error @enderror"
                                        name="content" id="edit-note-content" placeholder="content" rows="3" required
                                        data-parsley-minlength="3"></textarea>
                                    @error('content')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('content') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-edit-note"
                            class="btn btn-info waves-effect waves-light"><i class="mdi mdi-content-save"></i>Save</button>
                            <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                                onclick="$('#edit-note-modal').modal('toggle')"><i class="fe-x me-1"></i>Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
