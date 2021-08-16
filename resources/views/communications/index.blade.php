@extends('layouts.app', ['title' => 'Communications'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- picker css -->
    <link href="/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
    <link href="/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

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
                                <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                                <li class="breadcrumb-item active">Communications</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Communications</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-3">
                    <div class="card" id="notes-info-card">
                        @include('notes.notes-info-card')
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h4 class="header-title">List of Communications</h4>
                                    <p class="sub-header">
                                        All communications are mentioned here.
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#create-communication-modal">
                                            <i class="mdi mdi-plus-circle me-1"></i> Add Communications</button>
                                    </div>
                                </div><!-- end col-->
                            </div>
                            <div class="table-responsive" id="view-list-communications" data-simplebar>
                                @include('communications.list')
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->

                <div class="col-lg-2" id="communications-info-card">
                    @include('communications.info')
                </div>
            </div>
            <!-- end row -->

            @include('communications.create')
            @include('communications.edit')
            @if ($communications->count() > 0)
            @include('notes.add_note-modal')
            @include('notes.edit-note-ext')
            <div id="notes-div">
                @include('notes.notes-list-modal')
            </div>
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

            <!-- plugin js -->
            <script src="/libs/moment/min/moment.min.js"></script>
            <script src="/libs/fullcalendar/main.min.js"></script>

            <!-- picker js -->
            <script src="/libs/spectrum-colorpicker2/spectrum.min.js"></script>
            <script src="/libs/flatpickr/flatpickr.min.js"></script>
            <script src="/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
            <script src="/js/form-pickers.init.js"></script>

            <!-- custom js files -->
            <script src="/js/communications/datatable-communications.init.js"></script>
            <script src="/js/communications/communications.js"></script>
            <script src="/js/communications/ajax-crud.js"></script>
            <script src="/js/form-validation-laravel.js"></script>

            <script src="/js/notes/notes-module-ext.js"></script>
            <script>
                url_jsfile = '{{ URL::asset('/js/communications/') }}';
                var create_communication_errors = null
                var edit_communication_errors = null
                var create_note_errors = null
                var edit_note_errors = null

            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
