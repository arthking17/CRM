    <!-- Modal -->
    <div class="modal fade" id="create-appointment-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Appointment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" id="create-appointment" method="POST" action="#" data-parsley-validate=""
                    novalidate>
                    <div class="modal-body p-4">
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
                            <div class="row mb-3" id="create-appointment-row-contact_id">
                                <label for="create-appointment-contact_id"
                                    class="col-4 col-xl-3 col-form-label">Contact<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('contact_id') parsley-error @enderror"
                                        name="contact_id" id="create-appointment-contact_id" required
                                        data-parsley-type="integer" data-parsley-length="[1, 10]">
                                        <option value="">choose a contact</option>
                                        @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}">
                                                @if ($contact->class === 1)
                                                    (Person)
                                                    {{ $contacts_persons->where('id', $contact->id)->first()->first_name . ' ' . $contacts_persons->where('id', $contact->id)->first()->last_name }}
                                                @elseif($contact->class === 2)
                                                    (Companie)
                                                    {{ $contacts_companies->where('id', $contact->id)->first()->name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3" id="create-appointment-row-user_id">
                                <label for="create-appointment-user_id" class="col-4 col-xl-3 col-form-label">User<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('user_id') parsley-error @enderror" name="user_id"
                                        id="create-appointment-user_id" required data-parsley-type="integer"
                                        data-parsley-length="[1, 10]">
                                        <option value="">choose an user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-appointment-class" class="col-4 col-xl-3 col-form-label">Class<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-select @error('class') parsley-error @enderror" name="class"
                                        id="create-appointment-class" required data-parsley-type="integer"
                                        data-parsley-length="[1, 10]">
                                        <option value="1">Simple</option>
                                        <option value="2">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-appointment-subject"
                                    class="col-4 col-xl-3 col-form-label">subject<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control @error('subject') parsley-error @enderror"
                                        name="subject" id="create-appointment-subject" placeholder="subject" required
                                        data-parsley-minlength="3"
                                        data-parsley-pattern-message="This value should be a valid subject">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-appointment-start_date" class="col-4 col-xl-3 col-form-label">Start
                                    Date<span class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text"
                                        class="form-control datetimepicker @error('start_date') parsley-error @enderror"
                                        name="start_date" id="create-appointment-start_date" placeholder="Y-m-d H:i"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="create-appointment-end_date" class="col-4 col-xl-3 col-form-label">End
                                    Date<span class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text"
                                        class="form-control datetimepicker @error('end_date') parsley-error @enderror"
                                        name="end_date" id="create-appointment-end_date" placeholder="Y-m-d H:i"
                                        required>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-create-appointment"
                            class="btn btn-primary waves-effect waves-light"><i
                                class="mdi mdi-plus-circle"></i>Create</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"><i
                                class="fe-x me-1"></i>Reset</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
