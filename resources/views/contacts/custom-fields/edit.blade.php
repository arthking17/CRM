    <!-- Modal -->
    <div class="modal fade" id="edit-custom-field-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">edit Custom Field</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal" id="edit-custom-field" method="POST" action="#"
                        data-parsley-validate="" novalidate>
                        <div class="row">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" id="edit-custom-field-id">
                            <div class="row mb-3">
                                <label for="edit-custom-field-account_id"
                                    class="col-4 col-xl-3 col-form-label">account<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select
                                        class="form-select @error('account_id') parsley-error @enderror"
                                        name="account_id" id="edit-custom-field-account_id" required data-parsley-type="integer" data-parsley-maxlength="10">
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('account_id')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">
                                                {{ $errors->first('account_id') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-custom-field-name" class="col-4 col-xl-3 col-form-label">Name<span class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text"
                                        class="form-control @error('name') parsley-error @enderror"
                                        name="name" id="edit-custom-field-name" placeholder="Label " required>
                                    @error('name')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('name') }}
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="field_type" class="col-4 col-xl-3 col-form-label">Field Type<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('field_type') parsley-error @enderror" name="field_type"
                                        id="edit-custom-field-field_type" required>
                                        <option value="text">Text Field</option>
                                        <option value="date">Date Field</option>
                                        <option value="datetime">DateTime Field</option>
                                        <option value="month">Month Field</option>
                                        <option value="select">List Field</option>
                                        <option value="checkbox">Check Box Field</option>
                                        <option value="number">Number Field</option>
                                        <option value="file">File Field</option>
                                        <option value="url">Url Field</option>
                                        <option value="color">Color Field</option>
                                    </select>
                                    @error('field_type')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('field_type') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-custom-field-tag" class="col-4 col-xl-3 col-form-label">Tag<span
                                    class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text"
                                        class="form-control @error('tag') parsley-error @enderror"
                                        name="tag" id="edit-custom-field-tag" placeholder="Tag " required>
                                    @error('tag')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('tag') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-custom-field-select_option"
                                    class="col-4 col-xl-3 col-form-label">Option</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control @error('select_option') parsley-error @enderror"
                                        name="select_option" id="edit-custom-field-select_option">
                                    @error('select_option')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">
                                                {{ $errors->first('select_option') }}
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <button type="submit" id="btn-edit-custom-field"
                            class="btn btn-info waves-effect waves-light">Update</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
