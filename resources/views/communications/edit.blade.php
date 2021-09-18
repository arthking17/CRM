    <!-- Modal -->
    <div class="modal fade" id="edit-communication-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Communication</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" id="edit-communication" method="POST" action="#" data-parsley-validate=""
                    novalidate>
                <div class="modal-body p-4">
                        <div class="row">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" id="edit-communication-id">
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
                                <label for="edit-communication-contact_id" class="col-4 col-xl-3 col-form-label">Contact<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('contact_id') parsley-error @enderror"
                                        name="contact_id" id="edit-communication-contact_id" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                        <option value="">choose a contact</option>
                                        @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}">
                                                @if ($contact->class === 1)
                                                    (Person) {{ $contacts_persons->where('id', $contact->id)->first()->first_name . ' ' . $contacts_persons->where('id', $contact->id)->first()->last_name }}
                                                @elseif($contact->class === 2)
                                                    (Companie) {{ $contacts_companies->where('id', $contact->id)->first()->name }}
                                                @endif
                                            </option>
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('contact_id')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('contact_id') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-communication-user_id" class="col-4 col-xl-3 col-form-label">User<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('user_id') parsley-error @enderror"
                                        name="user_id" id="edit-communication-user_id" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                        <option value="">choose an user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('user_id') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-communication-class" class="col-4 col-xl-3 col-form-label">Class<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('class') parsley-error @enderror"
                                        name="class" id="edit-communication-class" required
                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                        <option value="1">Call</option>
                                        <option value="2">Email</option>
                                        <option value="3">Sms</option>
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
                                <label for="edit-communication-channel" class="col-4 col-xl-3 col-form-label">Channel<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="number" class="form-control @error('channel') parsley-error @enderror"
                                        name="channel" id="edit-communication-channel" placeholder="channel" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                        @error('channel')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('channel') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-communication-start_date" class="col-4 col-xl-3 col-form-label">Start Date<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control datetimepicker @error('start_date') parsley-error @enderror"
                                        name="start_date" id="edit-communication-start_date" placeholder="Y-m-d H:i" required>
                                        @error('start_date')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('start_date') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="edit-communication-qualification" class="col-4 col-xl-3 col-form-label">Qualification</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('qualification') parsley-error @enderror"
                                        name="qualification" id="edit-communication-qualification" required
                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                        <option value="1">completed with success</option>
                                        <option value="2">interruption during call</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" id="btn-edit-communication"
                        class="btn btn-info waves-effect waves-light"><i class="mdi mdi-content-save"></i>Save</button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="$('#edit-communication-modal').modal('toggle')"><i class="fe-x me-1"></i>Cancel</button>
                        </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
