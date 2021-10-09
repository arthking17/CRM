    <!-- Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Contact</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-contact" id="form_edit" method="POST" action="#"
                        data-parsley-validate="" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div id="edit-contactwizard">
                            <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                                <li class="nav-item">
                                    <a href="#edit-contact-class" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span class="d-none d-sm-inline">Contact</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="edit-nav-tab-info">
                                    <a href="#edit-personcontact" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-face-profile me-1"></i>
                                        <span class="d-none d-sm-inline">Contact Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#edit-custom-fields" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-tag-multiple me-1"></i>
                                        <span class="d-none d-sm-inline">Custom Field</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0 pt-0">

                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                    </div>
                                </div>

                                <div class="tab-pane" id="edit-contact-class">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="number" id="form_edit-id" name="id" hidden>
                                            <div class="row mb-3">
                                                <label for="form_edit-class"
                                                    class="col-4 col-xl-3 col-form-label">Class<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select class="form-select @error('class') parsley-error @enderror"
                                                        name="class" id="form_edit-class-disabled" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]"
                                                        disabled>
                                                        <option value="1">Person</option>
                                                        <option value="2">Company</option>
                                                    </select>
                                                    <input type="hidden" name="class" id="form_edit-class" />
                                                    @error('class')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('class') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-source"
                                                    class="col-4 col-xl-3 col-form-label">Source<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select class="form-select @error('source') parsley-error @enderror"
                                                        name="source" id="form_edit-source" required
                                                        data-parsley-type="integer" data-parsley-maxlength="10">
                                                        <option value="1">Telephone prospecting</option>
                                                        <option value="2">Landing pages</option>
                                                        <option value="3">Affiliation</option>
                                                        <option value="4">Database purchased</option>
                                                    </select>
                                                    @error('source')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('source') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-status"
                                                    class="col-4 col-xl-3 col-form-label">Status<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select class="form-select @error('status') parsley-error @enderror"
                                                        name="status" id="form_edit-status" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                        <option value="1">Lead</option>
                                                        <option value="2">Customer</option>
                                                        <option value="3">Not interested</option>
                                                    </select>
                                                    @error('status')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('status') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_edit-account_id"
                                                    class="col-4 col-xl-3 col-form-label">account<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    @if (Auth::user()->role == 2)
                                                        <input type="text" class="form-select d-none" name="account_id"
                                                            id="form_edit-account_id"
                                                            value="{{ Auth::user()->account_id }}">
                                                    @endif
                                                    <select
                                                        class="form-select @error('account_id') parsley-error @enderror"
                                                        name="account_id" @if (Auth::user()->role === 2) id="form_edit-account_id-disabled" @elseif (Auth::user()->role === 1) id="form_edit-account_id" @endif required
                                                        data-parsley-length="[1, 10]"
                                                        data-parsley-length-message="select an account"
                                                        @if (Auth::user()->role == 2) disabled @endif>
                                                        <option>select an account</option>
                                                        @foreach ($accounts as $key => $account)
                                                            <option value="{{ $account->id }}">{{ $account->name }}
                                                            </option>
                                                        @endforeach
                                                        @if (Auth::user()->role == 2)
                                                            <option value="{{ Auth::user()->account_id }}" selected>
                                                                {{ Auth::user()->account[0]->name }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-source_id"
                                                    class="col-4 col-xl-3 col-form-label">Source
                                                    Id<span class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="number"
                                                        class="form-control @error('source_id') parsley-error @enderror"
                                                        name="source_id" id="form_edit-source_id"
                                                        placeholder="Identifier of Source" required
                                                        data-parsley-type="integer" data-parsley-maxlength="10">
                                                    @error('source_id')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('source_id') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div> <!-- end row -->
                                </div>

                                <div class="tab-pane" id="edit-personcontact">
                                    <div class="row">
                                        <h3 class="mt-0 text-muted text-center">Person Contact</h3>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_edit-first_name"
                                                    class="col-4 col-xl-3 col-form-label">First
                                                    Name<span class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('first_name') parsley-error @enderror person-required"
                                                        name="first_name" id="form_edit-first_name"
                                                        placeholder="First Name" required data-parsley-minlength="2">
                                                    @error('first_name')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('first_name') }}</li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-nickname"
                                                    class="col-4 col-xl-3 col-form-label">Nickname</label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('nickname') parsley-error @enderror"
                                                        name="nickname" placeholder="Nickname" id="form_edit-nickname"
                                                        data-parsley-minlength="2">
                                                    @error('nickname')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('nickname') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-birthdate"
                                                    class="col-4 col-xl-3 col-form-label">Birthdate</label>
                                                <div class="col-8 col-xl-9">
                                                    <input
                                                        class="form-control birthdate-datepicker @error('birthdate') parsley-error @enderror"
                                                        type="date" name="birthdate" id="form_edit-birthdate"
                                                        data-parsley-maxdate="{{ date('m/d/Y') }}"
                                                        placeholder="yyyy-mm-dd">
                                                    @error('birthdate')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('birthdate') }}</li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-country"
                                                    class="col-4 col-xl-3 col-form-label">country</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select country @error('country') parsley-error @enderror"
                                                        name="person_country" id="form_edit-person_country"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a country</option>
                                                    </select>
                                                    @error('country')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('country') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_edit-last_name"
                                                    class="col-4 col-xl-3 col-form-label">Last
                                                    Name<span class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('last_name') parsley-error @enderror person-required"
                                                        name="last_name" id="form_edit-last_name"
                                                        placeholder="Last Name" required data-parsley-minlength="2">
                                                    @error('last_name')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('last_name') }}</li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="profile" class="col-4 col-xl-3 col-form-label">profile<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('profile') parsley-error @enderror person-required"
                                                        name="profile" id="form_edit-profile" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                        <option value="1">Engineer</option>
                                                        <option value="2">Designer</option>
                                                        <option value="3">Businessman</option>
                                                    </select>
                                                    @error('profile')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('profile') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-gender"
                                                    class="col-4 col-xl-3 col-form-label">gender<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('gender') parsley-error @enderror person-required"
                                                        name="gender" id="form_edit-gender" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                    </select>
                                                    @error('gender')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('gender') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-language"
                                                    class="col-4 col-xl-3 col-form-label">language</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('language') parsley-error @enderror"
                                                        name="person_language" id="form_edit-person_language"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a language</option>
                                                        <option value="ar">Arabic - العربية</option>
                                                        <option value="en">English</option>
                                                        <option value="fr">French - français</option>
                                                        <option value="es">Spanish - español</option>
                                                    </select>
                                                    @error('language')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('language') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div> <!-- end row -->
                                </div>

                                <div class="tab-pane" id="edit-companiescontact">
                                    <div class="row">
                                        <h3 class="mt-0 text-muted text-center">Companies Contact</h3>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_edit-class"
                                                    class="col-4 col-xl-3 col-form-label">Class<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('class') parsley-error @enderror companie-required"
                                                        name="companies_class" id="form_edit-companies_class" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                        <option value="1">One Person Companies</option>
                                                        <option value="2">Private Companies</option>
                                                        <option value="3">Public Companies</option>
                                                        <option value="4">Holding and Subsidiary Companies</option>
                                                        <option value="5">Associate Companies</option>
                                                    </select>
                                                    @error('class')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('class') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-name"
                                                    class="col-4 col-xl-3 col-form-label">Name<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('name') parsley-error @enderror companie-required"
                                                        name="name" placeholder="Name" id="form_edit-name" required
                                                        data-parsley-minlength="2">
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
                                                <label for="form_edit-registered_number"
                                                    class="col-4 col-xl-3 col-form-label">Registered number</label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('registered_number') parsley-error @enderror"
                                                        name="registered_number" id="form_edit-registered_number"
                                                        placeholder="Registered number" data-parsley-maxlength="128">
                                                    @error('registered_number')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('registered_number') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_edit-activity"
                                                    class="col-4 col-xl-3 col-form-label">Activity</label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="number"
                                                        class="form-control @error('activity') parsley-error @enderror"
                                                        name="activity" id="form_edit-activity"
                                                        placeholder="Identifier of activity" data-parsley-type="integer"
                                                        data-parsley-maxlength="10">
                                                    @error('activity')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('activity') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-country"
                                                    class="col-4 col-xl-3 col-form-label">country</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select country @error('country') parsley-error @enderror"
                                                        name="companies_country" id="form_edit-companies_country"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a country</option>
                                                    </select>
                                                    @error('country')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('country') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_edit-language"
                                                    class="col-4 col-xl-3 col-form-label">language</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('language') parsley-error @enderror"
                                                        name="companies_language" id="form_edit-companies_language"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a language</option>
                                                        <option value="ar">Arabic - العربية</option>
                                                        <option value="en">English</option>
                                                        <option value="fr">French - français</option>
                                                        <option value="es">Spanish - español</option>
                                                    </select>
                                                    @error('language')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('language') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="row mb-3">
                                            <label for="form_edit-logo"
                                                class="col-4 col-xl-3 col-form-label">Logo</label>
                                            <div class="col-8 col-xl-9">
                                                <div class="d-flex me-3 profile-pic">
                                                    <label class="-label" for="form_edit-logo">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span>Change</span>
                                                    </label>
                                                    <input id="form_edit-logo" type="file" name="photo"
                                                        onchange="updateContactCompanieLogoImg(event)"
                                                        data-parsley-fileextension='jpg,png,jpeg' />
                                                    <img id="form_edit-logo-img" class="rounded-circle avatar-lg"
                                                        src="" alt="Generic placeholder image">
                                                    @error('logo')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">{{ $errors->first('logo') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>

                                <div class="tab-pane" id="edit-custom-fields">
                                    @include('custom-fields.form-edit-custom-fields')
                                </div>

                                <ul class="list-inline mb-0 wizard">
                                    <li class="float-start">
                                        <a href="javascript: void(0);"
                                            class="btn btn-light waves-effect waves-light m-1"
                                            onclick="$('#edit-modal').modal('toggle')"><i
                                                class="fe-x me-1"></i>Cancel</a>
                                    </li>
                                    <li class="list-inline-item float-end">
                                        <button type="submit" id="btn-edit"
                                            class="btn btn-info waves-effect waves-light"><i
                                                class="mdi mdi-content-save"></i>Save</button>
                                    </li>
                                </ul>

                            </div> <!-- tab-content -->
                        </div> <!-- end #contactwizard-->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
