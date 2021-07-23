<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($contacts_person)
                <div class="w-100" id="contact-info1">
                    <h4 class="mt-0 mb-1">{{ $contacts_person->first_name . ' ' . $contacts_person->last_name }}</h4>
                    <p class="text-muted">{{ $contacts_person->nickname }}</p>
                    <p class="text-muted"><i class="mdi mdi-office-building"></i>
                        {{ $contacts_person->account_id }}</p>
                    <p class="text-muted d-none"> {{ $contacts_person->id }}</p>

                    <a href="javascript: void(0);" class="btn- btn-xs btn-info">Send Email</a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-info">Send Sms</a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-secondary">Call</a>
                    <a id="edit-{{ $contacts_person->id }}" class="btn- btn-xs btn-success" href="javascript: void(0);"
                        data-bs-toggle="modal" data-bs-target="#edit-modal"
                        onclick="editContact({{ $contacts_person->id }});">Edit</a>
                    <a id="delete-{{ $contacts_person->id }}" class="btn- btn-xs btn-danger" href="javascript: void(0);"
                        onclick="deleteContact({{ $contacts_person->id }});">Delete</a>
                </div>
            @endisset
        </div>

        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>
            Personal Information</h5>
        <div class="" id="contact-info2">
            
            @isset($contacts_person)
            
            <div class="btn-group mb-2">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-plus-circle me-1"></i>Add <i
                        class="mdi mdi-chevron-down"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 0);">Phone Number</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 1);">Mobile</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 2);">Fax Number</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 3);">Email Address</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 4);">Facebook</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 5);">Instagram</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 6);">Skype</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 7);">WhatsApp</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 8);">Viber</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="displayFormAddContactData({{ $contacts_person->id }}, 9);">Messenger</a>
                </div>
            </div><!-- /btn-group -->

                <h4 class="font-13 text-muted text-uppercase">Class :</h4>
                <p class="mb-3">
                    @if ($contacts_person->class === 2)
                        <span class="badge bg-success">Company</span>
                    @elseif($contacts_person->class === 1)
                        <span class="badge bg-blue text-light">Person</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Source :</h4>
                <p class="mb-3">
                    @if ($contacts_person->source === 1) <span
                            class="badge label-table bg-danger">Telephone prospecting</span>
                    @elseif($contacts_person->source === 2)
                        <span class="badge bg-warning">Landing pages</span>
                    @elseif($contacts_person->source === 3)
                        <span class="badge bg-success">Affiliation</span>
                    @elseif($contacts_person->source === 4)
                        <span class="badge bg-blue text-light">Database purchased</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Source ID :</h4>
                <p class="mb-3"> {{ $contacts_person->source_id }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
                <p class="mb-3">
                    @if ($contacts_person->status === 1) <span
                            class="badge label-table bg-success">Lead</span>
                    @elseif($contacts_person->status === 2)
                        <span class="badge bg-blue text-light">Customer</span>
                    @elseif($contacts_person->status === 3)
                        <span class="badge bg-danger">Not interested</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Profile :</h4>
                <p class="mb-3">
                    @if ($contacts_person->profile === 1) <span
                            class="badge label-table bg-success">Engineer</span>
                    @elseif($contacts_person->profile === 2)
                        <span class="badge bg-blue text-light">Designer</span>
                    @elseif($contacts_person->profile === 3)
                        <span class="badge bg-danger">Businessman</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Gender :</h4>
                <p class="mb-3">
                    @if ($contacts_person->gender === 1) <span
                            class="badge label-table bg-success">Male</span>
                    @elseif($contacts_person->gender === 2)
                        <span class="badge bg-blue text-light">Female</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Birthdate :</h4>
                <p class="mb-3"> {{ $contacts_person->birthdate }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Country :</h4>
                <p class="mb-3"> {{ $contacts_person->country }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Language :</h4>
                <p class="mb-3"> {{ $contacts_person->language }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Creation Date :</h4>
                <p class="mb-3"> {{ $contacts_person->creation_date }}</p>
            @endisset
        </div>
    </div>
</div> <!-- end card-->
