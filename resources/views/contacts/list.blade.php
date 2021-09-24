@extends('layouts.app', ['title' => 'Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

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
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('css/config/creative/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('css/config/creative/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('css/config/creative/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('css/config/creative/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- custom style css files -->
    <link rel="stylesheet" href="{{ asset('build/css/countrySelect.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <!-- custom style css files end -->
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="text-sm-end">
                                    <h4 class="page-title">Contacts &nbsp;
                                        <a href="{{ route('contacts.import') }}" class="btn- btn-xs btn-success">
                                            <i class="mdi mdi-cloud-upload-outline"></i> Import
                                        </a> &nbsp;
                                        <a href="{{ route('contacts.search') }}" class="btn- btn-xs btn-secondary">
                                            <i class="fe-search"></i> Search
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ config('app.name') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">Contacts</li>
                                    </ol>
                                </div>
                            </div><!-- end col-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div id="contacts-result">
                                @include('contacts.datatable-contacts')
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
                <div class="col-lg-3" id="contacts_person-info-card">
                    @include('contacts.contacts_person-info')
                </div>
                <div class="col-lg-3 d-none" id="contacts_companie-info-card">
                    @include('contacts.contacts_companie-info')
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('contacts.create')
    @include('contacts.edit')

    @include('notes.create-ext')
    @include('notes.edit-ext')

    @include('appointments.create')

    @include('email_accounts.send-mail')

    @include('sip_accounts.call')

    @include('sms_accounts.sms')
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
    <script src="{{ asset('js/contacts/form-add-wizard.js') }}"></script>

    <script src="{{ asset('js/contacts/datatable-contacts.init.js') }}"></script>
    <script src="{{ asset('js/contacts/contacts-list.js') }}"></script>

    <script src="{{ asset('js/contacts/country-select.js') }}"></script>

    <script src="{{ asset('js/custom-parsley.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>

    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>

    <!-- appointments -->
    <script src="{{ asset('js/appointments/create-ext.js') }}"></script>

    <!-- send email modal -->
    <script src="{{ asset('js/email_accounts/send-mail.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

    <!-- call voip modal -->
    <script src="{{ asset('js/sip_accounts/sip_accounts.js') }}"></script>

    <!-- send sms modal -->
    <script src="{{ asset('js/sms_accounts/sms.js') }}"></script>

    <script>
        url_logo = '{{ URL::asset('/storage/images/logo/') }}';
        url_custom_field = '{{ URL::asset('/storage/custom_field/') }}';
        url_contact_image = '{{ URL::asset('images/contact_data/') }}';
        url_jsfile = '{{ URL::asset('/js/contacts/') }}';
        url_audio = '{{ URL::asset('/audio') }}';
        var form_create_errors = null
        var form_edit_errors = null
        var create_contact_data_errors = null
        var edit_contact_data_errors = null
        var create_note_errors = null
        var edit_note_errors = null
        var search_contact_errors = null
        var errors_create_phone_data = null
        var errors_edit_phone_data = null
        var iti = null
        var edit_iti = null
        var skipErrors = 0
        var errors_create_custom_field = null
        var errors_edit_custom_field = null
        var create_appointment_errors = null
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
