<div class="accordion custom-accordion" id="custom-accordion-contact-data-info">
    <div class="card mb-0">
        <div class="card-header" id="heading-contact-data-info">
            <h5 class="m-0 position-relative">
                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                    href="#collapse-contact-data-info" aria-expanded="true" aria-controls="collapse-contact-data-info">
                    <h4 class="mb-1 mt-1 text-uppercase p-1"><i class="mdi mdi-contacts-outline me-1"></i>Contact Data<i
                            class="mdi mdi-chevron-down accordion-arrow"></i></h4>
                </a>
            </h5>
        </div>

        <div id="collapse-contact-data-info" class="collapse show" aria-labelledby="headingFour"
            data-bs-parent="#custom-accordion-contact-data-info">
            <div class="card-body @if(!count($contact_datas) == 0)border-success border @endif mb-3">
                @isset($contact_datas)
                    @if(count($contact_datas) == 0)
                    <p class="text-center"> empty</p>
                    @endif
                    @foreach ($contact_datas as $contact_data)
                        <div class="card product-box" id="{{ $contact_data->id }}">
                            <div class="product-action">
                                @if ($contact_data->class == 0 or $contact_data->class == 1 or $contact_data->class == 2 or $contact_data->class == 7)
                                    <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#edit-phone-data-modal"
                                        onclick="editContactData({{ $contact_data->id }}, 'edit-phone-data');"><i
                                            class="mdi mdi-pencil"></i></a>
                                @else
                                    <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#edit-contact-data-modal"
                                        onclick="editContactData({{ $contact_data->id }}, 'edit-contact-data');"><i
                                            class="mdi mdi-pencil"></i></a>
                                @endif
                                <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light"
                                    onclick="deleteContactData({{ $contact_data->id }});"><i
                                        class="mdi mdi-close"></i></a>
                            </div>
                            <h4 class="card-title text-success">
                                <img src="{{ asset('images/contact_data/' . getContactTypeByClass($contact_data->class) . '.png') }}"
                                    alt="contact-data-logo" height="12"
                                    class="me-1">{{ getContactTypeByClass($contact_data->class) }}
                            </h4>
                            <p class="card-text">
                                {{ $contact_data->data }}
                            </p>
                        </div>
                    @endforeach
                @endisset
            </div>

            @isset($contact)
                <div class=" text-center">
                    <div class="btn-group mb-2">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-plus-circle me-1"></i>Add <i
                                class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu">
                            @for ($i = 0; $i < 10; $i++)
                                @if ($i == 0 or $i == 1 or $i == 2 or $i == 7) <a
                                class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#create-phone-data-modal"
                                onclick="displayFormContactData('create-phone-data', {{ $contact->id }},
                                {{ $i }});"><img
                                src="{{ asset('images/contact_data/' . getContactTypeByClass($i) . '.png') }}"
                                alt="phone-data-logo" height="12"
                                class="me-1">{{ str_replace('_', ' ', getContactTypeByClass($i)) }}</a>
                            @else
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#create-contact-data-modal"
                                onclick="displayFormContactData('create-contact-data', {{ $contact->id }},
                                {{ $i }});"><img
                                src="{{ asset('images/contact_data/' . getContactTypeByClass($i) . '.png') }}"
                                alt="contact-data-logo" height="12"
                                class="me-1">{{ str_replace('_', ' ', getContactTypeByClass($i)) }}</a> @endif
                            @endfor
                        </div>
                    </div><!-- /btn-group -->
                </div>
            @endisset
        </div>
    </div>
</div>
