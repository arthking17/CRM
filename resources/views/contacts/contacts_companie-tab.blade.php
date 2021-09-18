@if ($contact->class === 2)
    <div class="row">
        <div class="col-sm-3">
            <div class="d-flex align-items-start mb-3">
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
                        <img id="contact-companie-logo" class="rounded-circle avatar-lg" src="
                                                                    @if ($contact->logo)
                        {{ asset('storage/images/logo/' . $contact->logo) }}
                    @else
                        {{ asset('storage/images/logo/image-not-found.png') }} @endif" alt="contact
                        companie logo">
                    </div>
                </form>
                <div class="w-100" id="contacts-companie-info1">
                    <h4 class="mt-0 mb-1" title="name">{{ $contact->name }}</h4>
                    <p class="text-muted">{{ getCompanieClassName($contact->class) }}</p>
                    <p class="text-muted" title="account"><i class="mdi mdi-office-building"></i>
                        {{ $accounts->find($contact->account_id)->name }}</p>
                    <p class="text-muted d-none" id="contact_id">{{ $contact->id }}</p>

                    <div class="btn-group mb-2">
                        <a href="javascript: void(0);" class="btn- btn-xs btn-info btn-sm dropdown-toggle"
                            title="New Email" href="javascript: void(0);" data-bs-target="#send-mail-modal"
                            data-bs-toggle="modal" onclick="setToEmailValues({{ getElementByName('contacts') }}, {{ $contact->id }});"><i class="mdi mdi-email-edit-outline"></i></a>
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
                                <a id="button-call-one" class="dropdown-item" href="#call-one-modal" data-backdrop="false" data-bs-toggle="modal" 
                                data-sipaccount-username="{{ $sip_account->username }}">
                                    <img src="{{ asset('images/contact_data/mobile.png') }}"
                                        alt="contact-data-logo" height="12" class="me-1">{{ $sip_account->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn-group mb-2">
                        <a id="edit-{{ $contact->id }}" class="btn- btn-xs btn-info" title="Edit Contact"
                            href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal"
                            onclick="editContact({{ $contact->id }});"><i
                                class="mdi mdi-square-edit-outline"></i></a>
                    </div>
                    <div class="btn-group mb-2">
                        <a id="delete-{{ $contact->id }}" class="btn- btn-xs btn-danger" title="Delete Contact"
                            href="javascript: void(0);" onclick="deleteContact({{ $contact->id }});"><i
                                class="mdi mdi-delete-circle"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <h4 class="font-13 text-muted text-uppercase mb-1">Activity :</h4>
            <p class="mb-3"> {{ $contact->activity }}</p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Registered number :</h4>
            <p class="mb-3"> {{ $contact->registered_number }}</p>
        </div>

        <div class="col-sm-3">
            <h4 class="font-13 text-muted text-uppercase mb-1">Language :</h4>
            <p class="mb-3"> {{ getLanguageName($contact->language) }}</p>

            <h4 class="font-13 text-muted text-uppercase mb-1">Country :</h4>
            <p class="mb-3"> {{ getCountryName($contact->country) }}</p>
        </div>
        <div class="col-sm-3">
            <h4 class="font-13 text-muted text-uppercase mb-1">Creation Date :</h4>
            <p class="mb-3"> {{ $contact->creation_date }}</p>

            @if ($contact->import_id)
                <h4 class="font-13 text-muted text-uppercase mb-1">Import Id :</h4>
                <p class="mb-3"> {{ $contact->import_id }}</p>
            @endif
        </div>
    </div>

    <div class="row">
        <h4>Custom fields</h4>
        @if (isset($contact_field) && $contact_field->count() > 0)
            @php
                $i = (int) ($contact_field->count() / 3 + 1);
                $count = 0;
            @endphp
            @foreach ($contact_field as $key => $field)
            
                @if  ($count === 0 && $key !== 0)
                    </div>
                @endif
                @if ($count === 0 || $count === $i)
                    <div class="col-sm-4">
                @endif
                @php $count++; if($count == $i) $count = 0; @endphp
                
                <h4 class="font-13 text-muted text-uppercase">{{ $field->name }} :</h4>
                @if ($field->field_type === 'file')
                    <p class="mb-3"><a href="{{ asset('storage/custom_field/' . $field->field_value) }}"
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

                @if  ($key === $contact_field->count()-1)
                    </div>
                @endif
            @endforeach
        @else
            <p class="text-center">empty</p>
        @endif
    </div>

@endif