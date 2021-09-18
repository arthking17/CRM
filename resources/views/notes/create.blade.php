    <!-- Modal -->
    <div class="modal fade" id="create-note-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Note</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" id="create-note" method="POST" action="#" data-parsley-validate=""
                    novalidate>
                    <div class="modal-body p-4">
                        <div class="row">
                            @csrf
                            <div class="row mb-3">
                                <label for="create-note-element_id" class="col-4 col-xl-3 col-form-label">Element
                                    Id<span class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="number"
                                        class="form-control @error('element_id') parsley-error @enderror"
                                        name="element_id" id="create-note-element_id"
                                        placeholder="Identifier of Element" required data-parsley-type="integer"
                                        data-parsley-maxlength="10">
                                    @error('element_id')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('element_id') }}
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="element" class="col-4 col-xl-3 col-form-label">Element<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('element') parsley-error @enderror" name="element"
                                        id="create-note-element" required data-parsley-type="integer"
                                        data-parsley-length="[1, 2]">
                                        <option value="{{ getElementByName('accounts') }}">Account</option>
                                        <option value="{{ getElementByName('appointments') }}">Appointment</option>
                                        <option value="{{ getElementByName('communications') }}">Communication
                                        </option>
                                        <option value="{{ getElementByName('contact_data') }}">Contact Data</option>
                                        <option value="{{ getElementByName('contacts') }}">Contact</option>
                                        <option value="{{ getElementByName('contacts_companies') }}">Contacts Companie
                                        </option>
                                        <option value="{{ getElementByName('contacts_persons') }}">Contacts Person
                                        </option>
                                        <option value="{{ getElementByName('email_accounts') }}">Email Account
                                        </option>
                                        <option value="{{ getElementByName('fax_accounts') }}">Fax Account</option>
                                        <option value="{{ getElementByName('groups') }}">Group</option>
                                        <option value="{{ getElementByName('imports') }}">Import</option>
                                        <option value="{{ getElementByName('logs') }}">Log</option>
                                        <option value="{{ getElementByName('notes') }}">Note</option>
                                        <option value="{{ getElementByName('sip_accounts') }}">Sip Account</option>
                                        <option value="{{ getElementByName('sms_accounts') }}">Sms Account</option>
                                        <option value="{{ getElementByName('users') }}">User</option>
                                        <option value="{{ getElementByName('users_permissions') }}">Users Permission
                                        </option>
                                    </select>
                                    @error('element')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('element') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-note-class" class="col-4 col-xl-3 col-form-label">Class<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('class') parsley-error @enderror" name="class"
                                        id="create-note-class" required data-parsley-type="integer"
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
                                        name="visibility" id="create-note-visibility" required
                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
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
                                        name="content" id="create-note-content" placeholder="content" rows="3" required
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
                        <button type="submit" id="btn-create"
                            class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle"></i>Create</button>
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"><i
                                    class="fe-x me-1"></i>Reset</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
