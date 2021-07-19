@extends('layouts.app', ['title' => 'Create User'])

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
                                <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Create User</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Create User</h4>
                            <p class="sub-header">
                                Fill the form to create user
                            </p>

                            <form class="form-horizontal parsley-user" id="create-user" method="POST" action="#"
                                data-parsley-validate="" novalidate  enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="create-user-username" class="col-4 col-xl-3 col-form-label">username<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="text"
                                                    class="form-control @error('username') parsley-error @enderror"
                                                    id="create-user-username" name="username" placeholder="username" required
                                                    data-parsley-minlength="3" pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                                    data-parsley-pattern-message="This value should be a valid username">
                                                @error('username')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('username') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="create-user-login" class="col-4 col-xl-3 col-form-label">login<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="text"
                                                    class="form-control @error('login') parsley-error @enderror"
                                                    id="create-user-login" name="login" placeholder="login" required
                                                    data-parsley-minlength="3" pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                                    data-parsley-pattern-message="This value should be a valid login">
                                                @error('login')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('login') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="create-user-pwd" class="col-4 col-xl-3 col-form-label">password<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="password"
                                                    class="form-control @error('pwd') parsley-error @enderror"
                                                    id="create-user-pwd" name="pwd" placeholder="password" required
                                                    data-parsley-minlength="3"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                                                    data-parsley-pattern-message="This value should be a valid password">
                                                @error('pwd')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('pwd') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8 offset-4">
                                                <div class="checkbox checkbox-purple">
                                                    <input id="showpwd" type="checkbox" onclick="showPassword('create-user-pwd');">
                                                    <label for="showpwd">Show password</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="create-user-role" class="col-4 col-xl-3 col-form-label">role<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('role') parsley-error @enderror"
                                                    name="role" id="create-user-role" required data-parsley-type="integer"
                                                    data-parsley-length="[1, 1]">
                                                    <option value="1">admin</option>
                                                    <option value="2">user</option>
                                                    <option value="3">visitor</option>
                                                </select>
                                                @error('role')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('role') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="create-user-language" class="col-4 col-xl-3 col-form-label">language<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('language') parsley-error @enderror"
                                                    name="language" id="create-user-language" required
                                                    data-parsley-length="[2, 2]" data-parsley-length-message="select a language">
                                                    <option>Select a language</option>
                                                    <option value="ar">Arabic - العربية</option>
                                                    <option value="en">English</option>
                                                    <option value="fr">French - français</option>
                                                    <option value="es">Spanish - español</option>
                                                </select>
                                                @error('language')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('language') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="create-user-account_id" class="col-4 col-xl-3 col-form-label">account<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select
                                                    class="form-select @error('account_id') parsley-error @enderror"
                                                    name="account_id" id="create-user-account_id" required data-parsley-type="integer" data-parsley-length="[1, 10]">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">{{ $account->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('account_id')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('account_id') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="create-user-photo" class="col-4 col-xl-3 col-form-label">photo<span
                                                class="text-danger">*</span></label>
                                        <div class="col-8 col-xl-9">
                                            <input type="file"
                                                class="form-control @error('photo') parsley-error @enderror"
                                                id="create-user-photo" name="photo" placeholder="photo" data-plugins="dropify" required
                                                data-parsley-fileextension='jpg,png,jpeg' data-height="100px">
                                            @error('photo')
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <li class="parsley-required">{{ $errors->first('photo') }}</li>
                                                </ul>
                                            @else
                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- end row-->
                                <button type="submit" id="btn-create"
                                    class="btn btn-info waves-effect waves-light">Create</button>
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

            <!-- Plugins js -->
            <script src="/libs/dropzone/min/dropzone.min.js"></script>
            <script src="/libs/dropify/js/dropify.min.js"></script>

            <!-- custom js files -->
            <script src="/js/users/users-validation.js"></script>
            <script src="/js/users/users-ajax.js"></script>
            <script src="/js/form-validation-laravel.js"></script>
            <script>
                var create_user_errors = null
            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
