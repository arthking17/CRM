@extends('layouts.app', ['title' => 'Upload Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

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
                                <li class="breadcrumb-item active">Upload</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Upload Contacts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Upload Contacts</h4>
                            <p class="sub-header">
                                Drop file contact in this zone.
                            </p>

                            <form class="form-horizontal" id="upload-contact" method="POST" action="#"
                                data-parsley-validate="" novalidate enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <div class="row align-items-center">
                                        <label for="upload-contact-file" class="col-4 col-xl-3 col-form-label">Contact
                                            File<span class="text-danger">*</span></label>
                                        <div class="col-auto">
                                            <input type="file" class="form-control @error('file') parsley-error @enderror"
                                                id="upload-contact-file" name="file" placeholder="file" required data-parsley-fileextension='csv,xlsx,xls'>
                                            @error('file')
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <li class="parsley-required">{{ $errors->first('file') }}</li>
                                                </ul>
                                            @else
                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            @enderror
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" id="btn-upload"
                                                class="btn btn-success waves-effect waves-light">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row-->
                            </form>

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

            <!-- custom js files -->
            <script src="/js/custom-parsley.js"></script>
            <script src="/js/contacts/upload.js"></script>
            <script src="/js/form-validation-laravel.js"></script>
            <script>
                var upload_contact_errors = null
            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
