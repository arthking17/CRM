    <!-- Modal -->
    <div class="modal fade" id="create-contact-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Contact</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-contact" id="form_create" method="POST" action="#"
                        data-parsley-validate="" novalidate enctype="multipart/form-data">
                        @csrf
                        <div id="contactwizard">
                            <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                                <li class="nav-item" data-target-form="#classForm">
                                    <a href="#contact-class" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span class="d-none d-sm-inline">Contact</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#personForm" id="nav-tab-info">
                                    <a href="#personcontact" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-face-profile me-1"></i>
                                        <span class="d-none d-sm-inline">Contact Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#custom-fields" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-tag-multiple me-1"></i>
                                        <span class="d-none d-sm-inline">Custom Field</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#form_create">
                                    <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                                        <span class="d-none d-sm-inline">Finish</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0 pt-0">

                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                    </div>
                                </div>

                                <div class="tab-pane" id="contact-class">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_create-class"
                                                    class="col-4 col-xl-3 col-form-label">Class<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select class="form-select @error('class') parsley-error @enderror"
                                                        name="class" id="form_create-class" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                        <option value="1">Person</option>
                                                        <option value="2">Company</option>
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
                                                <label for="form_create-source"
                                                    class="col-4 col-xl-3 col-form-label">Source<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select class="form-select @error('source') parsley-error @enderror"
                                                        name="source" id="form_create-source" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
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
                                                <label for="form_create-status"
                                                    class="col-4 col-xl-3 col-form-label">Status<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select class="form-select @error('status') parsley-error @enderror"
                                                        name="status" id="form_create-status" required
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
                                                <label for="form_create-account_id"
                                                    class="col-4 col-xl-3 col-form-label">account<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    @if (Auth::user()->role == 2)
                                                        <input type="text" class="form-select d-none" name="account_id"
                                                            id="form_create-account_id"
                                                            value="{{ Auth::user()->account_id }}">
                                                    @endif
                                                    <select
                                                        class="form-select @error('account_id') parsley-error @enderror"
                                                        name="account_id" @if (Auth::user()->role === 2) id="form_create-account_id-disabled" @elseif (Auth::user()->role === 1) id="form_create-account_id" @endif required
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
                                                <label for="form_create-source_id"
                                                    class="col-4 col-xl-3 col-form-label">Source
                                                    Id<span class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="number"
                                                        class="form-control @error('source_id') parsley-error @enderror"
                                                        name="source_id" id="form_create-source_id"
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

                                <div class="tab-pane" id="personcontact">
                                    <div class="row">
                                        <h3 class="mt-0 text-muted text-center">Person Contact</h3>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_create-first_name"
                                                    class="col-4 col-xl-3 col-form-label">First
                                                    Name<span class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('first_name') parsley-error @enderror person-required"
                                                        name="first_name" id="form_create-first_name"
                                                        placeholder="First Name" required value="arthur"
                                                        data-parsley-minlength="2">
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
                                                <label for="form_create-nickname"
                                                    class="col-4 col-xl-3 col-form-label">Nickname</label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('nickname') parsley-error @enderror"
                                                        name="nickname" id="form_create-nickname" placeholder="Nickname"
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
                                                <label for="form_create-birthdate"
                                                    class="col-4 col-xl-3 col-form-label">Birthdate</label>
                                                <div class="col-8 col-xl-9">
                                                    <input
                                                        class="form-control birthdate-datepicker @error('birthdate') parsley-error @enderror"
                                                        type="date" name="birthdate" id="form_create-birthdate"
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
                                                <label for="form_create-person_country"
                                                    class="col-4 col-xl-3 col-form-label">country</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select country @error('person_country') parsley-error @enderror"
                                                        name="person_country" id="form_create-person_country"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a country</option>
                                                    </select>
                                                    @error('person_country')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('person_country') }}
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
                                                <label for="form_create-last_name"
                                                    class="col-4 col-xl-3 col-form-label">Last
                                                    Name<span class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('last_name') parsley-error @enderror person-required"
                                                        name="last_name" id="form_create-last_name"
                                                        placeholder="Last Name" required value="william"
                                                        data-parsley-minlength="2">
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
                                                <label for="form_create-profile"
                                                    class="col-4 col-xl-3 col-form-label">profile<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('profile') parsley-error @enderror person-required"
                                                        name="profile" id="form_create-profile" required
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
                                                <label for="form_create-gender"
                                                    class="col-4 col-xl-3 col-form-label">gender<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('gender') parsley-error @enderror person-required"
                                                        name="gender" id="form_create-gender" required
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
                                                <label for="form_create-person_language"
                                                    class="col-4 col-xl-3 col-form-label">language</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('person_language') parsley-error @enderror"
                                                        name="person_language" id="form_create-person_language"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a language</option>
                                                        <option value="ar">Arabic - العربية</option>
                                                        <option value="en">English</option>
                                                        <option value="fr">French - français</option>
                                                        <option value="es">Spanish - español</option>
                                                    </select>
                                                    @error('person_language')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('person_language') }}
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

                                <div class="tab-pane" id="companiescontact">
                                    <div class="row">
                                        <h3 class="mt-0 text-muted text-center">Companies Contact</h3>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <label for="form_create-companies_class"
                                                    class="col-4 col-xl-3 col-form-label">Class<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('companies_class') parsley-error @enderror companie-required"
                                                        name="companies_class" id="form_create-companies_class" required
                                                        data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                        <option value="1">One Person Companies</option>
                                                        <option value="2">Private Companies</option>
                                                        <option value="3">Public Companies</option>
                                                        <option value="4">Holding and Subsidiary Companies</option>
                                                        <option value="5">Associate Companies</option>
                                                    </select>
                                                    @error('companies_class')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('companies_class') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_create-name"
                                                    class="col-4 col-xl-3 col-form-label">Name<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('name') parsley-error @enderror companie-required"
                                                        name="name" placeholder="Name" id="form_create-name" required
                                                        value="arthur" data-parsley-minlength="2">
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
                                                <label for="form_create-registered_number"
                                                    class="col-4 col-xl-3 col-form-label">Registered number</label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="text"
                                                        class="form-control @error('registered_number') parsley-error @enderror"
                                                        name="registered_number" id="form_create-registered_number"
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
                                                <label for="form_create-activity"
                                                    class="col-4 col-xl-3 col-form-label">Activity</label>
                                                <div class="col-8 col-xl-9">
                                                    <input type="number"
                                                        class="form-control @error('activity') parsley-error @enderror"
                                                        name="activity" id="form_create-activity"
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
                                                <label for="form_create-companies_country"
                                                    class="col-4 col-xl-3 col-form-label">country</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select country @error('companies_country') parsley-error @enderror"
                                                        name="companies_country" id="form_create-companies_country"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a country</option>
                                                    </select>
                                                    @error('companies_country')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('companies_country') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="form_create-companies_language"
                                                    class="col-4 col-xl-3 col-form-label">language</label>
                                                <div class="col-8 col-xl-9">
                                                    <select
                                                        class="form-select @error('companies_language') parsley-error @enderror"
                                                        name="companies_language" id="form_create-companies_language"
                                                        data-parsley-length="[2, 2]">
                                                        <option value="">Select a language</option>
                                                        <option value="ar">Arabic - العربية</option>
                                                        <option value="en">English</option>
                                                        <option value="fr">French - français</option>
                                                        <option value="es">Spanish - español</option>
                                                    </select>
                                                    @error('companies_language')
                                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ $errors->first('companies_language') }}
                                                            </li>
                                                        </ul>
                                                    @else
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="row mb-3">
                                            <label for="form_create-logo"
                                                class="col-4 col-xl-3 col-form-label">Logo</label>
                                            <div class="col-8 col-xl-9">
                                                <input type="file"
                                                    class="form-control dropify @error('logo') parsley-error @enderror"
                                                    name="logo" id="form_create-logo" data-plugins="dropify"
                                                    data-parsley-fileextension='jpg,png,jpeg' data-height="100px">
                                                @error('logo')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('logo') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>

                                <div class="tab-pane" id="custom-fields">
                                    <div class="row">
                                        @php
                                            $nbr_custom_fields = $custom_fields->count();
                                            $key = -1;
                                        @endphp
                                        @foreach ($custom_fields as $custom_field)
                                            @php $key++; @endphp
                                            @if ($key === 0 || $key === (int) ($nbr_custom_fields / 2 + 1))
                                                <div class="col-lg-6">
                                            @endif
                                            <div class="row mb-3">
                                                <label for="form_create-{{ $custom_field->tag }}"
                                                    class="col-4 col-xl-3 col-form-label">
                                                    @if ($custom_field->field_type !== 'checkbox')
                                                        {{ $custom_field->name }}
                                                    @endif
                                                </label>
                                                <div class="col-8 col-xl-9">
                                                    @if ($custom_field->field_type === 'text' || $custom_field->field_type === 'number' || $custom_field->field_type === 'url' || $custom_field->field_type === 'date' || $custom_field->field_type === 'datetime')
                                                        <input type="{{ $custom_field->field_type }}"
                                                            class="form-control @if ($custom_field->field_type === 'datetime') datetimepicker @elseif($custom_field->field_type === 'date') datepicker @endif
                                                        @error($custom_field->tag) parsley-error @enderror"
                                                            name="{{ $custom_field->tag }}"
                                                            id="form_create-{{ $custom_field->tag }}"
                                                            placeholder="@if ($custom_field->field_type === 'datetime') yyyy-mm-dd hh:mm @elseif($custom_field->field_type === 'date') yyyy-mm-dd @else {{ $custom_field->name }} @endif">
                                                    @elseif($custom_field->field_type === 'month')
                                                        <input type="text" class="form-control"
                                                            data-provide="datepicker" data-date-format="MM yyyy"
                                                            placeholder="MM yyyy" data-date-min-view-mode="1"
                                                            name="{{ $custom_field->tag }}"
                                                            id="form_create-{{ $custom_field->tag }}">
                                                    @elseif($custom_field->field_type === 'color')
                                                        <input type="text" class="form-control colorpicker"
                                                            name="{{ $custom_field->tag }}"
                                                            id="form_create-{{ $custom_field->tag }}">
                                                    @elseif($custom_field->field_type === 'select')
                                                        <select
                                                            class="form-select @error($custom_field->tag) parsley-error @enderror"
                                                            name="{{ $custom_field->tag }}"
                                                            id="form_create-{{ $custom_field->tag }}">
                                                            <option value="">Select {{ $custom_field->tag }}</option>
                                                            @foreach ($select_options->where('field_id', $custom_field->id) as $key => $opt)
                                                                <option value="{{ $opt->id }}">
                                                                    {{ $opt->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($custom_field->field_type === 'checkbox')
                                                        <div class="form-check">
                                                            <label for="form_create-{{ $custom_field->tag }}"
                                                                class="form-check-label">{{ $custom_field->name }}</label>
                                                            <input type="checkbox" class="form-check-input"
                                                                name="{{ $custom_field->tag }}"
                                                                id="form_create-{{ $custom_field->tag }}">
                                                        </div>
                                                    @elseif($custom_field->field_type === 'file')
                                                        <input type="file" name="{{ $custom_field->tag }}"
                                                            id="form_create-{{ $custom_field->tag }}"
                                                            class="form-control @error($custom_field->tag) parsley-error @enderror">
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($key === (int) ($nbr_custom_fields / 2) || $custom_field->id === $custom_fields->last()->id)
                                    </div>
                                    @endif
                                    @endforeach
                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane" id="finish-2">
                                <div class="row">
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

                                            <div class="mb-3">
                                                <button type="submit" id="button-create"
                                                    class="btn btn-primary waves-effect waves-light"><i
                                                        class="mdi mdi-plus-circle"></i>Create</button>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <ul class="list-inline mb-0 wizard">
                                <li class="float-start">
                                    <button type="reset" class="btn btn-light waves-effect waves-light m-1"
                                        title="reset all inputs in form"><i class="fe-x me-1"></i>Reset</button>
                                </li>
                                <li class="previous list-inline-item">
                                    <a href="javascript: void(0);" class="btn btn-secondary">Previous</a>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <a href="javascript: void(0);" class="btn btn-secondary">Next</a>
                                </li>
                            </ul>

                        </div> <!-- tab-content -->
                </div> <!-- end #contactwizard-->
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
