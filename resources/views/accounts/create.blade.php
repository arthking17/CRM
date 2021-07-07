@extends('layouts.app', ['title' => 'Create Account'])

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
                                <li class="breadcrumb-item"><a
                                        href="{{ route('home') }}">{{ config('app.name') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('accounts') }}">Accounts</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Create Account</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="header-title">Create Account</h4>
                            <p class="sub-header">
                                All field are required. 
                            </p>

                            <div class="alert alert-warning d-none fade show">
                                <h4 class="mt-0 text-warning">Oh snap!</h4>
                                <p class="mb-0">This form seems to be invalid :(</p>
                            </div>

                            <div class="alert alert-info d-none fade show">
                                <h4 class="mt-0 text-info">Yay!</h4>
                                <p class="mb-0">Everything seems to be ok :)</p>
                            </div>

                            <form class="form-horizontal parsley-account" id="create-account" method="POST" action="#"
                                data-parsley-validate="" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <label for="name" class="col-4 col-xl-3 col-form-label">Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="text"
                                            class="form-control @error('name') parsley-error @enderror"
                                            id="name" name="name" placeholder="Name" required data-parsley-minlength="3">
                                        @error('name')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('name') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="url" class="col-4 col-xl-3 col-form-label">Url<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <input type="url"
                                            class="form-control @error('url') parsley-error @enderror"
                                            id="url" name="url" placeholder="Url" required data-parsley-type="url">
                                        @error('url')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('url') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="status" class="col-4 col-xl-3 col-form-label">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="col-8 col-xl-9">
                                        <select
                                            class="form-select @error('status') parsley-error @enderror"
                                            name="status" required data-parsley-type="integer" data-parsley-length="[1, 1]">
                                            <option value="1">Active</option>
                                            <option value="2">Legit</option>
                                            <option value="3">Invoicing</option>
                                        </select>
                                        @error('status')
                                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                                <li class="parsley-required">{{ $errors->first('status') }}</li>
                                            </ul>
                                        @else
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="justify-content-end row">
                                    <div class="col-8 col-xl-9">
                                        <button type="submit" id="create"
                                            class="btn btn-info waves-effect waves-light">Create</button>
                                    </div>
                                </div>
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

            <!-- Validation account js -->
            <script src="/js/accounts/account.js"></script>
            <script src="/js/accounts/account-ajax.js"></script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
