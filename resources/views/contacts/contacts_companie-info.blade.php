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
                            <img id="contact-companie-logo" class="rounded-circle avatar-lg" src="
                                               @if ($contact->logo)
                            {{ asset('storage/images/logo/' . $contact->logo) }}
                        @else
                            {{ asset('storage/images/logo/image-not-found.png') }} @endif" alt="contact
                            companie logo">
                        </div>
                    </form>
                    <div class="w-100" id="contacts-companie-info1">
                        <h4 class="mt-0 mb-1">{{ $contact->name }}</h4>
                        <p class="text-muted">{{ getCompanieClassName($contact->class) }}</p>
                        <p class="text-muted"><i class="mdi mdi-office-building"></i>
                            {{ $account_name }}</p>
                        <p class="text-muted d-none"> {{ $contact->id }}</p>

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
                        @if(isset($contact))
                            @if ($contact->class === 2)
                                <h4 class="font-13 text-muted text-uppercase mb-1">Activity :</h4>
                                <p class="mb-3"> {{ $contact->activity }}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">Registered number :</h4>
                                <p class="mb-3"> {{ $contact->registered_number }}</p>

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
