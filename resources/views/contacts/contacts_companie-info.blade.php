<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($contact)
                @if ($contact->class === 2)
                    <form id="form-edit-contact-companie-logo" method="POST" action="#" data-parsley-validate="" novalidate
                        enctype="multipart/form-data">
                        <div class="d-flex me-3 profile-pic">
                            @csrf
                            @method('PUT')
                            <input type="number" name="id" id="form-edit-contact-companie-logo-id"
                                value="{{ $contact->id }}" required data-parsley-fileextension='jpg,png,jpeg' hidden>
                            <label class="-label" for="form-edit-contact-companie-logo-file">
                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change</span>
                            </label>
                            <input id="form-edit-contact-companie-logo-file" type="file" name="logo"
                                onchange="updateContactCompanieLogo(event)" />
                        <img id="contact-companie-logo" class="rounded-circle avatar-lg" src="@if ($contact->logo) {{ asset('storage/images/logo/' . $contact->logo) }} @else
                            {{ asset('storage/images/logo/image-not-found.png') }} @endif" alt="contact
                            companie logo">
                        </div>
                    </form>
                    <div class="w-100" id="contacts-companie-info1">
                        <h4 class="mt-0 mb-1">{{ $contact->name }}</h4>
                        <p class="text-muted">{{ getCompanieClassName($contact->class) }}</p>
                        <p class="text-muted"><i class="mdi mdi-office-building"></i>
                            {{ $accounts->find($contact->account_id)->name }}</p>
                        <p class="text-muted d-none"> {{ $contact->id }}</p>

                        <a href="javascript: void(0);" class="btn- btn-xs btn-info" title="New Email"><i
                                class="mdi mdi-email-edit-outline"></i></a>
                        <a href="javascript: void(0);" class="btn- btn-xs btn-info" title="New Sms"><i
                                class="mdi mdi-message-text-outline"></i></a>
                        <a href="javascript: void(0);" class="btn- btn-xs btn-success" title="Call"><i
                                class="fe-phone-call"></i></a>
                        <a id="edit-{{ $contact->id }}" class="btn- btn-xs btn-primary" title="Edit Contact"
                            href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                            onclick="editContact({{ $contact->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                        <a id="delete-{{ $contact->id }}" class="btn- btn-xs btn-danger" title="Delete Contact"
                            href="javascript: void(0);" onclick="deleteContact({{ $contact->id }});"><i
                                class="mdi mdi-delete-circle"></i></a>
                    </div>
                @endif
            @endisset
        </div>

        <div class="accordion custom-accordion" id="custom-accordion-contacts-companie-info">
            <div class="card mb-0">
                <div id="heading-contacts-companie-info">
                    <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                        href="#collapse-contacts-companie-info" aria-expanded="true"
                        aria-controls="collapse-contacts-companie-info">
                        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>
                            Personal Information<i class="mdi mdi-chevron-down accordion-arrow"></i></h5>
                    </a>
                </div>
                <div id="collapse-contacts-companie-info" class="collapse show" aria-labelledby="headingFour"
                    data-bs-parent="#custom-accordion-contacts-companie-info" id="contacts-companie-info2">
                    <div class="card-body">
                        @isset($contact)
                            @if ($contact->class === 2)
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

                                <h4 class="font-13 text-muted text-uppercase mb-1">Activity :</h4>
                                <p class="mb-3"> {{ $contact->activity }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Registered number :</h4>
                                <p class="mb-3"> {{ $contact->registered_number }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Country :</h4>
                                <p class="mb-3"> {{ $contact->country }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Language :</h4>
                                <p class="mb-3"> {{ $contact->language }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Creation Date :</h4>
                                <p class="mb-3"> {{ $contact->creation_date }}</p>
                                
                                @if($contact->import_id)
                                <h4 class="font-13 text-muted text-uppercase mb-1">Import Id :</h4>
                                <p class="mb-3"> {{ $contact->import_id }}</p>
                                @endif
                            @endif
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion custom-accordion" id="custom-accordion-contacts-companie-custom-field">
            <div class="card mb-0">
                <div id="heading-contacts-companie-custom-field">
                    <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                        href="#collapse-contacts-companie-custom-field" aria-expanded="true"
                        aria-controls="collapse-contacts-companie-custom-field">
                        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-tag-multiple me-1"></i>
                            Custom Field<i class="mdi mdi-chevron-down accordion-arrow"></i></h5>
                    </a>
                </div>
                <div id="collapse-contacts-companie-custom-field" class="collapse show" aria-labelledby="headingFour"
                    data-bs-parent="#custom-accordion-contacts-companie-custom-field">
                    <div class="card-body">
                        @if (isset($contact_field) && $contact_field->count() > 0)
                            @foreach ($contact_field as $field)
                                <h4 class="font-13 text-muted text-uppercase">{{ $field->name }} :</h4>
                                @if ($field->field_type === 'file')
                                <p class="mb-3"><a href="{{ asset('storage/custom_field/'.$field->field_value) }}" target="_blank">view {{ $field->tag }} content</a></p>
                                @elseif($field->field_type === 'checkbox')
                                    @if($field->field_value === 'on')
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
