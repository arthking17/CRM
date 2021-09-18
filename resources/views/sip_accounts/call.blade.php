<!-- Modal -->
<div id="call-one-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="multiple-oneModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="multiple-oneModalLabel">Select a contact to call</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="contacts-to-call">
                    @foreach ($contact_datas->whereIn('class', [0, 1, 2]) as $contact_data)
                        <a href="javascript: void(0);" class="" data-bs-toggle=" modal" data-bs-target="#call-two-modal"
                            data-bs-dismiss="modal"
                            onclick="call({{ $contact_data->id }}, '{{ $contact_data->data }}');">
                            <div class="card product-box" id="{{ $contact_data->id }}">
                                <br>
                                <h4 class="card-title text-success text-center">
                                    <img src="{{ asset('images/contact_data/' . getContactTypeByClass($contact_data->class) . '.png') }}"
                                        alt="contact-data-logo" height="12"
                                        class="me-1">{{ $contact_data->data }}
                                </h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div id="call-two-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="multiple-twoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div id="call-two-modal-content" class="modal-content modal-filled" style="background-color: #FFA500">
            <div id="call-two-modal-header" class="modal-header" style="background-color: #FFA500">
                <h4 class="modal-title text-light" id="multiple-twoModalLabel">Call Info</h4>
                <button id="button-call-two-close" type="button" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 id="call-number" class="text-light">phone number</h4>
                    <h5 id="call-duration" class="text-light">Dialing...</h5><br>
                    <div class="call-avatar-box">
                        <div class="call-avatar">
                            <img src="{{ asset('images/contact_data/unknow-profile-picture.png') }}"
                                alt="contact-data-logo" height="200" class="me-1">
                        </div>
                    </div>
                    <button id="button-call-two-stop-call" type="button"
                        class="btn btn-danger btn-rounded waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-phone-remove-outline"></i></span>End Call
                    </button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
