@extends('layouts.app', ['title' => $name])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- third party css end -->

    <!-- country select css files -->
    <link rel="stylesheet" href="{{ asset('build/css/countrySelect.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <!-- country select css files end -->

    <!-- plugin css select with country flag -->
    <link rel="stylesheet" href="{{ asset('twilio/css/intlTelInput.min.css') }}">

    <!-- Edit contact companie logo css -->
    <link href="{{ asset('css/contacts/companie-logo.css') }}" rel="stylesheet" type="text/css" />

    <!-- Jquery Toast css -->
    <link href="{{ asset('libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- selectize js -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

    <!-- picker css -->
    <link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Plugins css -->
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('css/config/creative/bootstrap.min.css') }}" rel="stylesheet" type="text/css"
        id="bs-default-stylesheet" />
    <link href="{{ asset('css/config/creative/app.min.css') }}" rel="stylesheet" type="text/css"
        id="app-default-stylesheet" />

    <link href="{{ asset('css/config/creative/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css"
        id="bs-dark-stylesheet" />
    <link href="{{ asset('css/config/creative/app-dark.min.css') }}" rel="stylesheet" type="text/css"
        id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                                <li class="breadcrumb-item active">{{ $name }}</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Contact @if ($contact->class === 2)
                                Company
                            @elseif($contact->class === 1) Person @endif
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="card">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#user-info" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                Contact Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="appointments-link" href="#appointments" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link">
                                Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="communications-link" href="#communications" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link">
                                Communications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="contact_data-link" href="#contact_data" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link">
                                Contact Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="notes-link" href="#notes" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link">
                                Notes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="smsbox-link" href="#smsbox" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link">
                                SMS Box
                            </a>
                        </li>

                        <button id="global-btn-add" type="button" class="btn btn-primary d-none"
                            data-bs-toggle="modal" data-bs-target="#create-entity-modal"><i
                                class="mdi mdi-plus-circle me-1"></i> Add entity </button>


                        <div class="d-none" id="btn-add-contact_data">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-plus-circle me-1"></i>Add
                                    Contact Data<i class="mdi mdi-chevron-down"></i></button>
                                <div class="dropdown-menu">
                                    @for ($i = 0; $i < 10; $i++)
                                        @if ($i == 0 or $i == 1 or $i == 2 or $i == 7)
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#create-phone-data-modal" onclick="displayFormContactData('create-phone-data', {{ $contact->id }}, {{ getElementByName('contacts') }},
                                                                            {{ $i }});"><img
                                                    src="{{ asset('images/contact_data/' . getContactTypeByClass($i) . '.png') }}"
                                                    alt="phone-data-logo" height="12"
                                                    class="me-1">{{ str_replace('_', ' ', getContactTypeByClass($i)) }}</a>
                                        @else
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#create-contact-data-modal" onclick="displayFormContactData('create-contact-data', {{ $contact->id }}, {{ getElementByName('contacts') }},
                                                                            {{ $i }});"><img
                                                    src="{{ asset('images/contact_data/' . getContactTypeByClass($i) . '.png') }}"
                                                    alt="contact-data-logo" height="12"
                                                    class="me-1">{{ str_replace('_', ' ', getContactTypeByClass($i)) }}</a>
                                        @endif
                                    @endfor
                                </div>
                            </div><!-- /btn-group -->
                        </div>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="user-info">
                            <div class=" @if ($contact->class !== 1) d-none @endif" id="contacts_person-info-card">
                                @include('contacts.contacts_person-tab')
                            </div>
                            <div class=" @if ($contact->class !== 2) d-none @endif" id="contacts_companie-info-card">
                                @include('contacts.contacts_companie-tab')
                            </div>
                        </div>
                        <div class="tab-pane" id="appointments">
                            <div id="view-list-appointments">
                                @include('appointments.list')
                            </div>
                        </div>
                        <div class="tab-pane" id="communications">
                            <div id="view-list-communications">
                                @include('communications.list')
                            </div>
                        </div>
                        <div class="tab-pane" id="contact_data">
                            @include('contact_data.contact_data')
                        </div>
                        <div class="tab-pane" id="notes">
                            @include('notes.datatable-notes')
                        </div>
                        <div class="tab-pane" id="smsbox">
                            @include('sms_accounts.smsbox')
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('contacts.edit')
    @include('contact_data.create-phone')
    @include('contact_data.edit-phone')
    @include('contact_data.create')
    @include('contact_data.edit')

    @include('notes.create-ext')
    @include('notes.edit-ext')

    <div id="notes-div"></div>

    @include('notes.create-ext-modal')
    @include('notes.edit-ext-modal')

    @include('email_accounts.send-mail')

    @include('sip_accounts.call')

    @include('sms_accounts.sms')

    <!-- missing modal create && edit communication -->

    @include('communications.create')
    @include('communications.edit')


    <!-- missing modal create && edit appointment -->

    @include('appointments.create')
    @include('appointments.edit')
@endsection

@section('js')
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- Plugin js-->
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <!-- button pdf copy -->
    <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- style button -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <!-- style button end -->
    <!-- button print -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <!-- not use -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <!-- not use end -->
    <!-- pdf -->
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <!-- Plugins js-->
    <script src="{{ asset('libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('twilio/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('twilio/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('twilio/js/utils.js') }}"></script>
    <script src="{{ asset('twilio/js/data.min.js') }}"></script>

    <!-- Plugins js -->
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>

    <!-- Tippy js-->
    <script src="{{ asset('libs/tippy.js/tippy.all.min.js') }}"></script>

    <!-- selectize js -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/selectize.min.js">
    </script>

    <!-- picker js -->
    <script src="{{ asset('libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/form-pickers.init.js') }}"></script>

    <!-- Edit contact companie logo js -->
    <script src="{{ asset('js/contacts/companie-logo.js') }}"></script>

    <!-- custom js files -->
    <script src="{{ asset('js/contacts/form-edit-wizard.js') }}"></script>

    <script src="{{ asset('js/contacts/contacts-list.js') }}"></script>

    <script src="{{ asset('js/contacts/country-select.js') }}"></script>

    <script src="{{ asset('js/custom-parsley.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>

    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>

    <script src="{{ asset('js/contact_data/contact-data.js') }}"></script>
    <script src="{{ asset('js/contact_data/add-phone-data.js') }}"></script>
    <script src="{{ asset('js/contact_data/edit-phone-data.js') }}"></script>

    <!-- send email modal -->
    <script src="{{ asset('js/email_accounts/send-mail.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

    <!-- call voip modal -->
    <script src="{{ asset('js/sip_accounts/sip_accounts.js') }}"></script>

    <!-- send sms modal -->
    <script src="{{ asset('js/sms_accounts/sms.js') }}"></script>

    <script src="{{ asset('js/appointments/datatable-appointments.init.js') }}"></script>
    <script src="{{ asset('js/appointments/appointments.js') }}"></script>
    <script src="{{ asset('js/appointments/create.js') }}"></script>
    <script src="{{ asset('js/appointments/edit-ext.js') }}"></script>
    <script src="{{ asset('js/appointments/appointments-ext.js') }}"></script>

    <script src="{{ asset('js/communications/datatable-communications.init.js') }}"></script>
    <script src="{{ asset('js/communications/communications.js') }}"></script>
    <script src="{{ asset('js/communications/create.js') }}"></script>
    <script src="{{ asset('js/communications/edit.js') }}"></script>
    <script src="{{ asset('js/communications/communications-ext.js') }}"></script>

    <script src="{{ asset('js/notes/datatable-notes.init.js') }}"></script>
    <script src="{{ asset('js/notes/notes-module-ext.js') }}"></script>
    <script src="{{ asset('js/notes/notes-module-ext-in-modal.js') }}"></script>

    <script src="{{ asset('js/contacts/tab-pane.js') }}"></script>

    <script>
        url_logo = '{{ URL::asset('/storage/images/logo/') }}';
        url_custom_field = '{{ URL::asset('/storage/custom_field/') }}';
        url_contact_image = '{{ URL::asset('images/contact_data/') }}';
        url_jsfile = '{{ URL::asset('/js/contacts/') }}';
        url_audio = '{{ URL::asset('/audio') }}';
        url_jsfile_notes = '{{ URL::asset('/js/notes/') }}';

        var form_create_errors = null
        var form_edit_errors = null

        var create_note_errors = null
        var edit_note_errors = null

        var create_contact_data_errors = null
        var edit_contact_data_errors = null

        var errors_create_phone_data = null
        var errors_edit_phone_data = null
        var iti = null
        var edit_iti = null
        var skipErrors = 0

        var errors_create_custom_field = null
        var errors_edit_custom_field = null

        var myTimer = null

        url_jsfile_appointments = '{{ URL::asset('/js/appointments/') }}';
        var create_appointment_errors = null
        var edit_appointment_errors = null

        url_jsfile_communications = '{{ URL::asset('/js/communications/') }}';
        var create_communication_errors = null
        var edit_communication_errors = null
    </script>

    <script>
        var editor = new Quill('#snow-editor', {
            theme: 'snow'
        });
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
@endsection
