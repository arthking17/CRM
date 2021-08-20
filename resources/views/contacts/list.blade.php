@extends('layouts.app', ['title' => 'Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- country select css files -->
    <link rel="stylesheet" href="build/css/countrySelect.css">
    <link rel="stylesheet" href="/css/custom-style.css">
    <!-- country select css files end -->

    <!-- plugin css select with country flag -->
    <link rel="stylesheet" href="/twilio/css/intlTelInput.min.css">

    <!-- Edit contact companie logo css -->
    <link href="/css/contacts/companie-logo.css" rel="stylesheet" type="text/css" />

    <!-- Jquery Toast css -->
    <link href="/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css" />

    <!-- selectize js -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

    <!-- picker css -->
    <link href="/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
    <link href="/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <!-- send email modal -->
    <link href="/css/contacts/data/send-mail.css" rel="stylesheet" type="text/css" />

    <!-- jquery-ui 
                        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->

    <!-- quill css 
                    <link href="/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
                    <link href="/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />-->

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- App css -->
    <link href="/css/config/creative/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="/css/config/creative/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="/css/config/creative/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="/css/config/creative/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />
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
                                <li class="breadcrumb-item active">Contacts</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Contacts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-2">
                    <div class="card" id="contact_data-info-card">
                        @include('contacts.contact_data')
                    </div>
                    <div class="card" id="notes-info-card">
                        @include('notes.notes-info-card')
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <div class="text-sm-end">
                                        <button type="button"
                                            class="btn btn-danger btn-rounded waves-effect waves-light mb-3"
                                            data-bs-toggle="modal" data-bs-target="#create-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add Contact</button>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#create-custom-field-modal"
                                            class="btn btn-light mb-2 me-1" title="Create Custom Field"><i
                                                class="fe-plus"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="" data-bs-target="#custom-fields-modal"
                                            onclick="viewCustomFields()" class="btn btn-light mb-2 me-1">View Custom Fields
                                        </a>
                                        <a href="{{ route('contacts.import') }}" data-bs-toggle=""
                                            data-bs-target="#upload-modal" class="btn btn-success mb-2 me-1">
                                            <i class="mdi mdi-cloud-upload-outline"></i>
                                        </a>
                                        <a href="{{ route('contacts.search') }}" data-bs-toggle="modal"
                                            data-bs-target="#search-modal" class="btn btn-light mb-2 me-1">
                                            <i class="fe-search"></i>
                                        </a>
                                    </div>
                                </div><!-- end col-->
                            </div>
                            <div id="contacts-result" data-simplebar>
                                <table id="datatable-contacts"
                                    class="table table-center dt-responsive nowrap table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-filter">Id</th>
                                            <th class="select-filter">Account</th>
                                            <th class="select-filter">Class</th>
                                            <th class="select-filter">Source</th>
                                            <th class="text-filter">Creation Date</th>
                                            <th class="select-filter">Status</th>
                                            <th class="text-filter">Source Id</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($contacts as $contact_itr)
                                            <tr id="contactid{{ $contact_itr->id }}"
                                                onclick="viewContact({{ $contact_itr->id }}, {{ $contact_itr->class }});">
                                                <td>{{ $contact_itr->id }}</td>
                                                <td>{{ $contact_itr->account[0]->name }}</td>
                                                <td>
                                                    @if ($contact_itr->class === 2)
                                                        <span class="badge bg-success">Company</span>
                                                    @elseif($contact_itr->class === 1)
                                                        <span class="badge bg-blue text-light">Person</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($contact_itr->source === 1)
                                                        <span class="badge label-table bg-danger">Telephone
                                                            prospecting</span>
                                                    @elseif($contact_itr->source === 2)
                                                        <span class="badge bg-warning">Landing pages</span>
                                                    @elseif($contact_itr->source === 3)
                                                        <span class="badge bg-success">Affiliation</span>
                                                    @elseif($contact_itr->source === 4)
                                                        <span class="badge bg-blue text-light">Database purchased</span>
                                                    @endif
                                                </td>
                                                <td>{{ $contact_itr->creation_date }}</td>
                                                <td>
                                                    @if ($contact_itr->status === 1)
                                                        <span class="badge label-table bg-success">Lead</span>
                                                    @elseif($contact_itr->status === 2)
                                                        <span class="badge bg-blue text-light">Customer</span>
                                                    @elseif($contact_itr->status === 3)
                                                        <span class="badge bg-danger">Not interested</span>
                                                    @endif
                                                </td>
                                                <td>{{ $contact_itr->source_id }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="">Id</th>
                                            <th class="select account">Account</th>
                                            <th class="select">Class</th>
                                            <th class="select">Source</th>
                                            <th class="">Creation Date</th>
                                            <th class="select">Status</th>
                                            <th class="">Source Id</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
                @if (isset($contact))
                    <div class="col-lg-3 @if ($contact->class !== 1) d-none @endif" id="contacts_person-info-card">
                        @include('contacts.contacts_person-info')
                    </div>
                    <div class="col-lg-3 @if ($contact->class !== 2) d-none @endif" id="contacts_companie-info-card">
                        @include('contacts.contacts_companie-info')
                    </div>
                @endif
                <div class="col-lg-3 @if (isset($contact)) d-none @endif"
                    id="contacts_info_not_found">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                            </div>
                            <div class="accordion custom-accordion" id="custom-accordion-contacts-person-info">
                                <div class="card mb-0">
                                    <div id="heading-contacts-person-info">
                                        <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                                            href="#collapse-contacts-person-info" aria-expanded="true"
                                            aria-controls="collapse-contacts-person-info">
                                            <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i
                                                    class="mdi mdi-account-circle me-1"></i>
                                                Personal Information<i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </h5>
                                        </a>
                                    </div>
                                    <div id="collapse-contacts-person-info" class="collapse show"
                                        aria-labelledby="headingFour"
                                        data-bs-parent="#custom-accordion-contacts-person-info">
                                        <div class="card-body">
                                            <p class="text-center">empty</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('contacts.create')
    @include('contacts.search-modal')
    @include('contacts.edit')
    @include('contacts.data.create-phone')
    @include('contacts.data.edit-phone')
    @include('contacts.data.create')
    @include('contacts.data.edit')
    @include('notes.add_note-modal')
    @include('notes.edit-note-ext')
    <div id="notes-div">
        @include('notes.notes-list-modal')
    </div>
    <div id="custom-fields-div">
    </div>
    @include('contacts.custom-fields.create')
    @include('contacts.custom-fields.edit')

    @include('appointments.create')

    @include('email_accounts.send-mail')
@endsection

@section('js')
    <!-- Vendor js -->
    <script src="/js/vendor.min.js"></script>

    <!-- Plugin js-->
    <script src="/libs/parsleyjs/parsley.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- third party js -->
    <script src="/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <!-- button pdf copy -->
    <script src="/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <!-- style button -->
    <script src="/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <!-- style button end -->
    <!-- button print -->
    <script src="/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <!-- not use -->
    <script src="/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <!-- not use end -->
    <!-- pdf -->
    <script src="/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="/libs/pdfmake/build/vfs_fonts.js"></script>
    <!-- third party js ends -->

    <!-- Plugins js-->
    <script src="/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

    <script src="/twilio/js/intlTelInput.min.js"></script>
    <script src="/twilio/js/intlTelInput-jquery.min.js"></script>
    <script src="/twilio/js/utils.js"></script>
    <script src="/twilio/js/data.min.js"></script>

    <!-- Plugins js -->
    <script src="/libs/dropzone/min/dropzone.min.js"></script>
    <script src="/libs/dropify/js/dropify.min.js"></script>

    <!-- Tippy js-->
    <script src="/libs/tippy.js/tippy.all.min.js"></script>

    <!-- selectize js -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/selectize.min.js">
    </script>

    <!-- picker js -->
    <script src="/libs/spectrum-colorpicker2/spectrum.min.js"></script>
    <script src="/libs/flatpickr/flatpickr.min.js"></script>
    <script src="/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/form-pickers.init.js"></script>

    <!-- Edit contact companie logo js -->
    <script src="/js/contacts/companie-logo.js"></script>

    <!-- custom js files -->
    <script src="/js/contacts/form-edit-wizard.js"></script>
    <script src="/js/contacts/form-add-wizard.js"></script>
    <script src="/js/contacts/contacts-validation.js"></script>

    <script src="/js/contacts/datatable-contacts.init.js"></script>
    <script src="/js/contacts/contacts-list.js"></script>

    <script src="/js/contacts/country-select.js"></script>

    <script src="/js/custom-parsley.js"></script>
    <script src="/js/helpers.js"></script>

    <script src="/js/form-validation-laravel.js"></script>

    <script src="/js/contacts/data/contact-data.js"></script>
    <script src="/js/contacts/data/add-phone-data.js"></script>
    <script src="/js/contacts/data/edit-phone-data.js"></script>

    <script src="/js/notes/notes-module-ext.js"></script>

    <script src="/js/contacts/search/form-search-wizard.js"></script>
    <script src="/js/contacts/search/search-module.js"></script>

    <script src="/js/contacts/custom-fields/form-create.js"></script>
    <script src="/js/contacts/custom-fields/custom-fields.js"></script>

    <!-- appointments -->
    <script src="/js/appointments/ajax-crud.js"></script>

    <!-- send email modal -->
    <script src="/js/contacts/data/send-mail.js"></script>

    <!-- jquery-ui 
                                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Quill js 
                            <script src="/libs/quill/quill.min.js"></script>-->

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

    <script>
        url_logo = '{{ URL::asset('/storage/images/logo/') }}';
        url_custom_field = '{{ URL::asset('/storage/custom_field/') }}';
        url_contact_image = '{{ URL::asset('images/contact_data/') }}';
        url_jsfile = '{{ URL::asset('/js/contacts/') }}';
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
    </script>

    <script>
        var editor = new Quill('#snow-editor', {
            theme: 'snow'
        });
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="/js/app.min.js"></script>
@endsection
