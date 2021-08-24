<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($contact)
                @if ($contact->class === 1)
                    <div class="w-100" id="contacts-person-info1">
                        <h4 class="mt-0 mb-1">{{ $contact->first_name . ' ' . $contact->last_name }}</h4>
                        <p class="text-muted">{{ $contact->nickname }}</p>
                        <p class="text-muted"><i class="mdi mdi-office-building"></i>
                            {{ $accounts->find($contact->account_id)->name }}</p>
                        <p class="text-muted d-none"> {{ $contact->id }}</p>

                        <div class="btn-group mb-2">
                            <a href="javascript: void(0);" class="btn- btn-xs btn-info btn-sm dropdown-toggle"
                                title="New Email" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="mdi mdi-email-edit-outline"></i></a>
                            <div class="dropdown-menu">
                                @foreach ($email_accounts as $key => $email)
                                <a class="dropdown-item" href="#send-mail-modal"
                                data-backdrop="false" data-bs-toggle="modal" onclick="sendEmail('{{ $email->id }}', '{{ $contact->id }}', {{ getElementByName('contacts') }}, '{{ $email->email }}')">
                                <img src="{{ asset('images/contact_data/email.png') }}"
                                alt="contact-data-logo" height="12" class="me-1">{{ $email->email }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="btn-group mb-2">
                            <a href="javascript: void(0);" class="btn- btn-xs btn-info js--tippy" title="New Sms"><i
                                    class="mdi mdi-message-text-outline"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a href="javascript: void(0);" class="btn- btn-xs btn-success btn-sm dropdown-toggle"
                                title="Call" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="fe-phone-call"></i></a>
                            <div class="dropdown-menu">
                                @foreach ($sip_accounts as $key => $sip_account)
                                    <a id="button-call-one" class="dropdown-item" href="#call-one-modal" data-backdrop="false" data-bs-toggle="modal" 
                                    data-sipaccount-username="{{ $sip_account->username }}">
                                        <img src="{{ asset('images/contact_data/mobile.png') }}"
                                            alt="contact-data-logo" height="12" class="me-1">{{ $sip_account->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="btn-group mb-2">
                            <a id="edit-{{ $contact->id }}" class="btn- btn-xs btn-primary js--tippy" title="Edit Contact"
                                href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                                onclick="editContact({{ $contact->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a id="delete-{{ $contact->id }}" class="btn- btn-xs btn-danger js--tippy"
                                title="Delete Contact" href="javascript: void(0);"
                                onclick="deleteContact({{ $contact->id }});"><i class="mdi mdi-delete-circle"></i></a>
                        </div>
                        <div class="btn-group mb-2">
                            <a class="btn- btn-xs btn-info" title="Add Appointment" data-bs-toggle="modal"
                                data-bs-target="#create-appointment-modal" href="javascript: void(0);"
                                onclick="viewFormCreateAppointment('{{ $contact->id }}', '4')"><i
                                    class="mdi mdi-calendar-plus"></i></a>
                        </div>
                    </div>
                @endif
            @endisset
        </div>

        <div class="accordion custom-accordion" id="custom-accordion-contacts-person-info">
            <div class="card mb-0">
                <div id="heading-contacts-person-info">
                    <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                        href="#collapse-contacts-person-info" aria-expanded="true"
                        aria-controls="collapse-contacts-person-info">
                        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>
                            Personal Information<i class="mdi mdi-chevron-down accordion-arrow"></i></h5>
                    </a>
                </div>
                <div id="collapse-contacts-person-info" class="collapse show" aria-labelledby="headingFour"
                    data-bs-parent="#custom-accordion-contacts-person-info">
                    <div class="card-body">
                        @if (isset($contact))
                            @if ($contact->class === 1)
                                <h4 class="font-13 text-muted text-uppercase">Class :</h4>
                                <p class="mb-3">
                                    @if ($contact->class === 2)
                                        <span class="badge bg-success">Company</span>
                                    @elseif($contact->class === 1)
                                        <span class="badge bg-blue text-light">Person</span>
                                    @endif
                                </p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Source :</h4>
                                <p class="mb-3">
                                    @if ($contact->source === 1) <span
                                            class="badge label-table bg-danger">Telephone prospecting</span>
                                    @elseif($contact->source === 2)
                                        <span class="badge bg-warning">Landing pages</span>
                                    @elseif($contact->source === 3)
                                        <span class="badge bg-success">Affiliation</span>
                                    @elseif($contact->source === 4)
                                        <span class="badge bg-blue text-light">Database purchased</span>
                                    @endif
                                </p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Source ID :</h4>
                                <p class="mb-3"> {{ $contact->source_id }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
                                <p class="mb-3">
                                    @if ($contact->status === 1) <span
                                            class="badge label-table bg-success">Lead</span>
                                    @elseif($contact->status === 2)
                                        <span class="badge bg-blue text-light">Customer</span>
                                    @elseif($contact->status === 3)
                                        <span class="badge bg-danger">Not interested</span>
                                    @endif
                                </p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Profile :</h4>
                                <p class="mb-3">
                                    @if ($contact->profile === 1) <span
                                            class="badge label-table bg-success">Engineer</span>
                                    @elseif($contact->profile === 2)
                                        <span class="badge bg-blue text-light">Designer</span>
                                    @elseif($contact->profile === 3)
                                        <span class="badge bg-danger">Businessman</span>
                                    @endif
                                </p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Gender :</h4>
                                <p class="mb-3">
                                    @if ($contact->gender === 1) <span
                                            class="badge label-table bg-success">Male</span>
                                    @elseif($contact->gender === 2)
                                        <span class="badge bg-blue text-light">Female</span>
                                    @endif
                                </p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Birthdate :</h4>
                                <p class="mb-3"> {{ $contact->birthdate }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Country :</h4>
                                <p class="mb-3"> {{ getCountryName($contact->country) }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Language :</h4>
                                <p class="mb-3"> {{ getLanguageName($contact->language) }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Creation Date :</h4>
                                <p class="mb-3"> {{ $contact->creation_date }}</p>

                                @if ($contact->import_id)
                                    <h4 class="font-13 text-muted text-uppercase mb-1">Import Id :</h4>
                                    <p class="mb-3"> {{ $contact->import_id }}</p>
                                @endif
                            @endif
                        @else
                            <p class="text-center">empty</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion custom-accordion" id="custom-accordion-contacts-person-custom-field">
            <div class="card mb-0">
                <div id="heading-contacts-person-custom-field">
                    <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                        href="#collapse-contacts-person-custom-field" aria-expanded="true"
                        aria-controls="collapse-contacts-person-custom-field">
                        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-tag-multiple me-1"></i>
                            Custom Field<i class="mdi mdi-chevron-down accordion-arrow"></i></h5>
                    </a>
                </div>
                <div id="collapse-contacts-person-custom-field" class="collapse show" aria-labelledby="headingFour"
                    data-bs-parent="#custom-accordion-contacts-person-custom-field">
                    <div class="card-body">
                        @if (isset($contact_field) && $contact_field->count() > 0)
                            @foreach ($contact_field as $field)
                                <h4 class="font-13 text-muted text-uppercase">{{ $field->name }} :</h4>
                                @if ($field->field_type === 'file')
                                    <p class="mb-3"><a
                                            href="{{ asset('storage/custom_field/' . $field->field_value) }}"
                                            target="_blank">view {{ $field->tag }} content</a></p>
                                @elseif($field->field_type === 'checkbox')
                                    @if ($field->field_value === 'on')
                                        <p class="mb-3"> Yes </p>
                                    @endif
                                @elseif($field->field_type === 'select')
                                    <p class="mb-3"> {{ $field->option[0]->title }}</p>
                                @else
                                    <p class="mb-3"> {{ $field->field_value }}</p>
                                @endif
                            @endforeach
                        @else
                            <p class="text-center">empty</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-->
