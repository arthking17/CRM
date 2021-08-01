<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($contact)
                @if ($contact->class === 1)
                    <div class="w-100" id="contact-info1">
                        <h4 class="mt-0 mb-1">{{ $contact->first_name . ' ' . $contact->last_name }}</h4>
                        <p class="text-muted">{{ $contact->nickname }}</p>
                        <p class="text-muted"><i class="mdi mdi-office-building"></i>
                            {{ $accounts->find($contact->account_id)->name }}</p>
                        <p class="text-muted d-none"> {{ $contact->id }}</p>

                        <a href="javascript: void(0);" class="btn- btn-xs btn-info js--tippy" title="New Email"><i class="mdi mdi-email-edit-outline"></i></a>
                        <a href="javascript: void(0);" class="btn- btn-xs btn-info js--tippy" title="New Sms"><i class="mdi mdi-message-text-outline"></i></a>
                        <a href="javascript: void(0);" class="btn- btn-xs btn-success js--tippy" title="Call"><i class="fe-phone-call"></i></a>
                        <a id="edit-{{ $contact->id }}" class="btn- btn-xs btn-primary js--tippy" title="Edit Contact" href="javascript: void(0);"
                            data-bs-toggle="modal" data-bs-target="#edit-modal"
                            onclick="editContact({{ $contact->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                        <a id="delete-{{ $contact->id }}" class="btn- btn-xs btn-danger js--tippy" title="Delete Contact" href="javascript: void(0);"
                            onclick="deleteContact({{ $contact->id }});"><i class="mdi mdi-delete-circle"></i></a>
                    </div>
                @endif
            @endisset
        </div>

        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>
            Personal Information</h5>
        <div class="" id="contact-info2">

            @isset($contact)
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
                    <p class="mb-3"> {{ $contact->country }}</p>

                    <h4 class="font-13 text-muted text-uppercase mb-1">Language :</h4>
                    <p class="mb-3"> {{ $contact->language }}</p>

                    <h4 class="font-13 text-muted text-uppercase mb-1">Creation Date :</h4>
                    <p class="mb-3"> {{ $contact->creation_date }}</p>
                @endif
            @endisset
        </div>
    </div>
</div> <!-- end card-->
