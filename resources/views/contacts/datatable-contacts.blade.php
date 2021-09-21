<table id="datatable-contacts" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="select-filter">Account</th>
            <th class="select-filter">Class</th>
            <th class="select-filter">Source</th>
            <th class="text-filter">Creation Date</th>
            <th class="select-filter">Status</th>
            <th class="text-filter">Source Id</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($contacts as $contact)
            <tr id="contactid{{ $contact->id }}"
                onclick="viewContact({{ $contact->id }}, {{ $contact->class }});">
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->account[0]->name }}</td>
                <td>
                    @if ($contact->class === 2)
                        <span class="badge bg-success">Company</span>
                    @elseif($contact->class === 1)
                        <span class="badge bg-blue text-light">Person</span>
                    @endif
                </td>
                <td>
                    @if ($contact->source === 1)
                        <span class="badge label-table bg-danger">Telephone
                            prospecting</span>
                    @elseif($contact->source === 2)
                        <span class="badge bg-warning">Landing pages</span>
                    @elseif($contact->source === 3)
                        <span class="badge bg-success">Affiliation</span>
                    @elseif($contact->source === 4)
                        <span class="badge bg-blue text-light">Database purchased</span>
                    @endif
                </td>
                <td>{{ $contact->creation_date }}</td>
                <td>
                    @if ($contact->status === 1)
                        <span class="badge label-table bg-success">Lead</span>
                    @elseif($contact->status === 2)
                        <span class="badge bg-blue text-light">Customer</span>
                    @elseif($contact->status === 3)
                        <span class="badge bg-secondary">Not interested</span>
                    @elseif($contact->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>{{ $contact->source_id }}</td>
                <td>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-info btn-sm dropdown-toggle"
                            title="New Email" href="javascript: void(0);" data-bs-target="#send-mail-modal"
                            data-bs-toggle="modal"
                            onclick="setToEmailValues({{ getElementByName('contacts') }}, {{ $contact->id }});"><i
                                class="mdi mdi-email-edit-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-info btn-sm dropdown-toggle"
                            title="New Sms" data-bs-target="#sms-modal" data-bs-toggle="modal"
                            onclick="setToContactValues({{ getElementByName('contacts') }}, {{ $contact->id }});">
                            <i class="mdi mdi-message-text-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-success btn-sm dropdown-toggle"
                            title="Call" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fe-phone-call"></i></a>
                        <div class="dropdown-menu">
                            @foreach ($sip_accounts as $key => $sip_account)
                                <a id="button-call-one" class="dropdown-item" href="#call-one-modal"
                                    data-backdrop="false" data-bs-toggle="modal"
                                    data-sipaccount-username="{{ $sip_account->username }}"
                                    onclick="setContactDataValues({{ getElementByName('contacts') }}, {{ $contact->id }});">
                                    <img src="{{ asset('images/contact_data/mobile.png') }}" alt="contact-data-logo"
                                        height="12" class="me-1">{{ $sip_account->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn-group mb-2">
                        <a class="btn- btn-xs btn-info" title="Add Appointment" data-bs-toggle="modal"
                            data-bs-target="#create-appointment-modal" href="javascript: void(0);"
                            onclick="viewFormCreateAppointment('{{ $contact->id }}', '4')"><i
                                class="mdi mdi-calendar-plus"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a id="edit-{{ $contact->id }}" class="btn- btn-xs btn-info js--tippy" title="Edit Contact"
                            href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                            onclick="editContact({{ $contact->id }});"><i
                                class="mdi mdi-square-edit-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a id="delete-{{ $contact->id }}" class="btn- btn-xs btn-danger js--tippy"
                            title="Delete Contact" href="javascript: void(0);"
                            onclick="deleteContact({{ $contact->id }});"><i class="mdi mdi-delete-circle"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a class="btn btn-secondary btn-xs waves-effect waves-light" title="click here for more details"
                            href="{{ route('contacts.view', $contact->id) }}"><i class="fe-external-link"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="">Id</th>
            <th class=" select account">Account</th>
            <th class="select">Class</th>
            <th class="select">Source</th>
            <th class="">Creation Date</th>
            <th class=" select">Status</th>
            <th class="">Source Id</th>
            <th class=" disabled">Action</th>
        </tr>
    </tfoot>
</table>
