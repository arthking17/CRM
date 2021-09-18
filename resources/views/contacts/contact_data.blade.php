<div class="card mb-0" style="max-height: 500px" data-simplebar>
    <div class="card-body">
        @isset($contact_datas)
            @if(count($contact_datas) == 0)
            <p class="text-center"> empty</p>
            @else
                @php
                    $i = (int) (count($contact_datas) / 3);
                    $count = 0;
                @endphp

                <div class="row">
                    @foreach ($contact_datas as $key => $contact_data)

                        @if  ($count === 0 && $key-1 !== 0)
                            </div>
                        @endif
                        @if ($count === 0 || $count === $i)
                            <div class="col-sm-4">
                        @endif
                        @php $count++; if($count === $i) $count = 0; @endphp

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
                                    class="me-1">{{ str_replace('_', ' ', getContactTypeByClass($contact_data->class)) }}
                            </h4>
                            <p class="card-text">
                                {{ $contact_data->data }}
                            </p>
                        </div>

                        @if  ($key === count($contact_datas))
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endisset
    </div>
</div>
