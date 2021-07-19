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
    <!-- country select css files end -->

    <!-- Jquery Toast css -->
    <link href="/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />

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
                <div class="col-lg-8">
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
                                        <a href="{{ route('contacts.upload') }}" data-bs-toggle="" data-bs-target="#upload-modal"
                                            class="btn btn-success mb-2 me-1">
                                            <i class="mdi mdi-cloud-upload-outline"></i>
                                        </a>
                                        <a href="{{ route('contacts.search') }}" data-bs-toggle="" data-bs-target="#search-modal"
                                            class="btn btn-light mb-2 me-1">
                                            <i class="fe-search"></i>
                                        </a>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <table id="datatable-contacts"
                                class="table table-center dt-responsive nowrap table-hover w-100">
                                <thead>
                                    <tr>
                                        <th class="text-filter">Id</th>
                                        <th class="select-filter">Account</th>
                                        <th class="select-filter">Class</th>
                                        <th class="select-filter">Source</th>
                                        <th class="text-filter">Source Id</th>
                                        <th class="text-filter">Creation Date</th>
                                        <th class="select-filter">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr id="contactid{{ $contact->id }}"
                                            onclick="viewContact({{ $contact->id }}, {{ $contact->class }});">
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->account[0]->name }}</td>
                                            <td>
                                                @if ($contact->class === 2)
                                                    <span class="badge bg-success">Company</span>
                                                @elseif($contact->class === 1)
                                                    <span class="badge bg-blue text-light">Person</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contact->source === 1) <span
                                                        class="badge label-table bg-danger">Telephone prospecting</span>
                                                @elseif($contact->source === 2)
                                                    <span class="badge bg-warning">Landing pages</span>
                                                @elseif($contact->source === 3)
                                                    <span class="badge bg-success">Affiliation</span>
                                                @elseif($contact->source === 4)
                                                    <span class="badge bg-blue text-light">Database purchased</span>
                                                @endif
                                            </td>
                                            <td>{{ $contact->source_id }}</td>
                                            <td>{{ $contact->creation_date }}</td>
                                            <td>
                                                @if ($contact->status === 1) <span
                                                        class="badge label-table bg-success">Lead</span>
                                                @elseif($contact->status === 2)
                                                    <span class="badge bg-blue text-light">Customer</span>
                                                @elseif($contact->status === 3)
                                                    <span class="badge bg-danger">Not interested</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="">Id</th>
                                        <th class="select account">Account</th>
                                        <th class="select">Class</th>
                                        <th class="select">Source</th>
                                        <th class="">Source Id</th>
                                        <th class="">Creation Date</th>
                                        <th class="select">Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-lg-4 @if ($contact->class !== 1) d-none @endif" id="contacts_person-info-card">
                    @include('contacts.contacts_person-info')
                </div>
                <div class="col-lg-4 @if ($contact->class !== 2) d-none @endif" id="contacts_companie-info-card">
                    @include('contacts.contacts_companie-info')
                </div>
            </div>
            <!-- end row -->
            @include('contacts.create')
            @if ($contacts->count() > 0)
                @include('contacts.edit')
            @endif
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

            <!-- country select js files -->
            <script src="build/js/countrySelect.min.js"></script>
            <script>
                $("#country").countrySelect();
            </script>
            <!-- country select js files end -->

            <!-- Plugin js-->
            <script src="/libs/parsleyjs/parsley.min.js"></script>

            <!-- Sweet Alerts js -->
            <script src="/libs/sweetalert2/sweetalert2.all.min.js"></script>

            <!-- Plugins js -->
            <script src="/libs/dropzone/min/dropzone.min.js"></script>
            <script src="/libs/dropify/js/dropify.min.js"></script>

            <!-- custom js files -->
            <script src="/js/contacts/form-wizard.init.js"></script>
            <script src="/js/contacts/contacts-list.js"></script>
            <script src="/js/contacts/country-select.js"></script>
            <script src="/js/contacts/contacts-validation.js"></script>
            <script src="/js/form-validation-laravel.js"></script>
            <script>
                url_photo = '{{ URL::asset('/storage/images/logo/') }}';
                var form_create_errors = null
                var form_edit_errors = null
            </script>
            <!-- custom js files end -->

            <!-- App js -->
            <script src="/js/app.min.js"></script>
        @endsection
