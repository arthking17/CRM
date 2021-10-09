<div class="card">
    <div class="card-body">
        @if (isset($group))
            <div class="d-flex align-items-start mb-3">
                <div class="w-100" id="group-info1">
                    <h4 class="mt-0 mb-1">{{ $group->name }}</h4>
                    <p class="text-muted">{{ $group->class }}</p>
                    <p class="text-muted"><i class="mdi mdi-office-building"></i>
                        {{ $group->account[0]->name }}</p>
                    <p class="text-muted d-none"> {{ $group->id }}</p>

                    <a id="edit-{{ $group->id }}" class="btn- btn-xs btn-success" href="javascript: void(0);"
                        data-bs-toggle="modal" data-bs-target="#edit-modal"
                        onclick="editGroup({{ $group->id }});">Edit</a>
                    <a id="delete-{{ $group->id }}" class="btn- btn-xs btn-danger" href="javascript: void(0);"
                        onclick="deleteGroup({{ $group->id }});">Delete</a>
                </div>
            </div>

            <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-contacts me-1"></i>List of
                Contacts
            </h5>
            <div class="card" id=" group-info2" data-simplebar style="max-height: 400px;">
                @if ($contacts->count() > 0)
                    @foreach ($contacts as $contact)
                        <div class="d-flex align-items-start mb-3 bg-light"
                            title="Click here for more detail about this contact">
                            <a href="{{ route('contacts.view', $contact->id) }}">
                                @if ($contact->class === 2)
                                    @php
                                        $contact_companie = $contacts_companies->where('id', $contact->id)->first();
                                    @endphp
                                    @if (isset($contact_companie) && $contact_companie !== null)
                                        <div class="d-flex me-3 profile-pic">
                                            <img id="contact-photo" class="d-flex me-3 rounded-circle avatar-lg"
                                                src="{{ asset('storage/images/logo/' . $contact_companie->logo) }}"
                                                alt="Generic placeholder image">
                                        </div>
                                        <div class="w-100" id="contact-info1">
                                            <h4 class="mt-0 mb-1">{{ $contact_companie->name }}
                                            </h4>
                                            <p class="text-muted" title="activity">
                                                {{ $contact_companie->activity }}
                                            </p>
                                        </div>
                                    @endif
                                @elseif ($contact->class === 1)
                                    @php
                                        $contact_person = $contacts_persons->where('id', $contact->id)->first();
                                    @endphp
                                    @if (isset($contact_person) && $contact_person !== null)
                                        <div class="d-flex me-3 profile-pic">
                                            <img id="contact-photo" class="d-flex me-3 rounded-circle avatar-lg"
                                                src="{{ asset('storage/images/users/unknow-profile-picture.png') }}"
                                                alt="Generic placeholder image">
                                        </div>
                                        <div class="w-100" id="contact-info1">
                                            <h4 class="mt-0 mb-1">
                                                {{ $contact_person->first_name . ' ' . $contact_person->last_name }}
                                            </h4>
                                            <p class="text-muted">
                                                @if ($contact_person->gender === 1)
                                                    <span class="badge label-table bg-success">Male</span>
                                                @elseif($contact_person->gender === 2)
                                                    <span class="badge bg-blue text-light">Female</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            </a>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">empty</p>
                @endif
            </div>
            <a href="{{ route('contacts') }}" class="btn- btn-xs" title="go to page list of contacts"><i class="mdi mdi-plus-circle me-1"></i>voir
                plus</a>
        @else
            <p class="text-center">
                click on a table groups row to view more details in that side.
            </p>
        @endif
    </div>
</div> <!-- end card-->
