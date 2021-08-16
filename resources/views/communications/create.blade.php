    <!-- Modal -->
    <div class="modal fade" id="create-communication-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Communication</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal" id="create-communication" method="POST" action="#" data-parsley-validate=""
                        novalidate>
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
                            <div class="row mb-3">
                                <label for="create-communication-contact_id" class="col-4 col-xl-3 col-form-label">Contact<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('contact_id') parsley-error @enderror"
                                        name="contact_id" id="create-communication-contact_id" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                        <option value="">choose a contact</option>
                                        @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}">{{ $contact->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-communication-user_id" class="col-4 col-xl-3 col-form-label">User<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('user_id') parsley-error @enderror"
                                        name="user_id" id="create-communication-user_id" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                        <option value="">choose an user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-communication-class" class="col-4 col-xl-3 col-form-label">Class<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('class') parsley-error @enderror"
                                        name="class" id="create-communication-class" required
                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                        <option value="1">Call</option>
                                        <option value="2">Email</option>
                                        <option value="3">Sms</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-communication-channel" class="col-4 col-xl-3 col-form-label">Channel<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="number" class="form-control @error('channel') parsley-error @enderror"
                                        name="channel" id="create-communication-channel" placeholder="channel" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-communication-start_date" class="col-4 col-xl-3 col-form-label">Start Date<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control datetimepicker @error('start_date') parsley-error @enderror"
                                        name="start_date" id="create-communication-start_date" placeholder="Y-m-d H:i" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-communication-qualification" class="col-4 col-xl-3 col-form-label">Qualification</label>
                                <div class="col-8 col-xl-9">
                                    <input type="number" class="form-control @error('qualification') parsley-error @enderror"
                                        name="qualification" id="create-communication-qualification" placeholder="Qualification"
                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <button type="submit" id="btn-create-communication"
                            class="btn btn-info waves-effect waves-light">Create</button>
                        <button type="reset" class="btn btn-light waves-effect waves-light m-1"><i
                                class="fe-x me-1"></i>Reset</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
