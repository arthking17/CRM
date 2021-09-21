<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($contact)
                @if ($contact->class === 1)
                    <div class="w-100" id="contacts-person-info1">
                        <h4 class="mt-0 mb-1">{{ $contact->first_name . ' ' . $contact->last_name }}</h4>
                        <p class="text-muted">{{ $contact->nickname }}</p>
                        <p class="text-muted"><i class="mdi mdi-office-building"></i>
                            {{ $account_name }}</p>
                        <p class="text-muted d-none"> {{ $contact->id }}</p>
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
                            <p class="text-center">
                                click on a table contacts row to view more details in that side.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-->
