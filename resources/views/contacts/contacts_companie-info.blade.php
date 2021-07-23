<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($contacts_companie)
                <img id="contact-photo" class="d-flex me-3 rounded-circle avatar-lg"
                    src="@if($contacts_companie->logo) {{ asset('storage/images/logo/' . $contacts_companie->logo) }} @else {{ asset('storage/images/logo/image-not-found.png') }} @endif" alt="Generic placeholder image">
                <div class="w-100" id="contact-info1">
                    <h4 class="mt-0 mb-1">{{ $contacts_companie->name }}</h4>
                    <p class="text-muted">{{ $contacts_companie->class }}</p>
                    <p class="text-muted"><i class="mdi mdi-office-building"></i>
                        {{ $contacts_companie->account_id }}</p>
                    <p class="text-muted d-none"> {{ $contacts_companie->id }}</p>

                    <a href="javascript: void(0);" class="btn- btn-xs btn-info">Send Email</a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-info">Send Sms</a>
                    <a href="javascript: void(0);" class="btn- btn-xs btn-secondary">Call</a>
                    <a id="edit-{{ $contacts_companie->id }}" class="btn- btn-xs btn-success"
                        href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                        onclick="editContact({{ $contacts_companie->id }});">Edit</a>
                    <a id="delete-{{ $contacts_companie->id }}" class="btn- btn-xs btn-danger"
                        href="javascript: void(0);" onclick="deleteContact({{ $contacts_companie->id }});">Delete</a>
                </div>
            @endisset
        </div>

        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>
            Personal Information</h5>
        <div class="" id="contact-info2">
            
            @isset($contacts_companie)
            
            <div class="btn-group mb-2">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-plus-circle me-1"></i>Add <i
                        class="mdi mdi-chevron-down"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Phone Number</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Mobile</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Fax Number</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Email Address</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Facebook</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Instagram</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Skype</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">WhatsApp</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Viber</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-contact-data-modal"
                        onclick="addContact_data({{ $contacts_companie->id }});">Messenger</a>
                </div>
            </div><!-- /btn-group -->

                <h4 class="font-13 text-muted text-uppercase">Class :</h4>
                <p class="mb-3">
                    @if ($contacts_companie->companies_class === 2)
                        <span class="badge bg-success">Company</span>
                    @elseif($contacts_companie->companies_class === 1)
                        <span class="badge bg-blue text-light">Person</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Source :</h4>
                <p class="mb-3">
                    @if ($contacts_companie->source === 1) <span
                            class="badge label-table bg-danger">Telephone prospecting</span>
                    @elseif($contacts_companie->source === 2)
                        <span class="badge bg-warning">Landing pages</span>
                    @elseif($contacts_companie->source === 3)
                        <span class="badge bg-success">Affiliation</span>
                    @elseif($contacts_companie->source === 4)
                        <span class="badge bg-blue text-light">Database purchased</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Source ID :</h4>
                <p class="mb-3"> {{ $contacts_companie->source_id }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
                <p class="mb-3">
                    @if ($contacts_companie->status === 1) <span
                            class="badge label-table bg-success">Lead</span>
                    @elseif($contacts_companie->status === 2)
                        <span class="badge bg-blue text-light">Customer</span>
                    @elseif($contacts_companie->status === 3)
                        <span class="badge bg-danger">Not interested</span>
                    @endif
                </p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Activity :</h4>
                <p class="mb-3"> {{ $contacts_companie->activity }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Registered number :</h4>
                <p class="mb-3"> {{ $contacts_companie->registered_number }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Country :</h4>
                <p class="mb-3"> {{ $contacts_companie->country }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Language :</h4>
                <p class="mb-3"> {{ $contacts_companie->language }}</p>

                <h4 class="font-13 text-muted text-uppercase mb-1">Creation Date :</h4>
                <p class="mb-3"> {{ $contacts_companie->creation_date }}</p>
            @endisset
        </div>
    </div>
</div> <!-- end card-->
