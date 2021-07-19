@extends('layouts.app', ['title' => 'Search Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

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
                                <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                                <li class="breadcrumb-item active">Search</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Search Contacts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="pt-3 pb-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="Admin Dashboard">
                                            <button type="button"
                                                class="input-group-text btn waves-effect waves-light btn-blue"><i
                                                    class="fe-search me-1"></i> Search</button>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <h4>Search Results For "Admin Dashboard"</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->
        @endsection

        @section('js')
            <!-- Vendor js -->
            <script src="/js/vendor.min.js"></script>

            <!-- Plugin js-->
            <script src="/libs/parsleyjs/parsley.min.js"></script>

            <!-- Sweet Alerts js -->
            <script src="/libs/sweetalert2/sweetalert2.all.min.js"></script>

            <!-- Plugins js -->
            <script src="/libs/dropzone/min/dropzone.min.js"></script>
            <script src="/libs/dropify/js/dropify.min.js"></script>

            <!-- Init js-->
            <!--<script src="/js/pages/form-fileuploads.init.js"></script>-->

            <!-- custom js files -->
            <script src="/js/form-validation-laravel.js"></script>
            <script src="/js/contacts/search.js"></script>
            <script>
                var search_contact_errors = null
            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
