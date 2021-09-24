@extends('layouts.app', ['title' => 'Profile'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- Edit user photo css -->
    <link href="{{ asset('css/users/user-photo.css') }}" rel="stylesheet" type="text/css" />

    <!-- custom style -->
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('css/config/creative/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('css/config/creative/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('css/config/creative/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('css/config/creative/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

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
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <form id="form-edit-user-photo" method="POST" action="#" data-parsley-validate="" novalidate
                                enctype="multipart/form-data">
                                <div class="d-flex me-3 profile-pic">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="id" id="form-edit-user-photo-id"
                                        value="{{ Auth::user()->id }}" required data-parsley-fileextension='jpg,png,jpeg'
                                        hidden>
                                    <label class="-label" for="form-edit-user-photo-file">
                                        <span class="glyphicon glyphicon-camera"></span>
                                        <span>Change</span>
                                    </label>
                                    <input id="form-edit-user-photo-file" type="file" name="photo"
                                        onchange="updateUserPhoto(event)" />
                                    <img id="user-photo" src="{{ asset('storage/images/users/' . Auth::user()->photo) }}"
                                        class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                </div>
                            </form>

                            <h4 class="mb-0">{{ Auth::user()->login }}</h4>
                            <p class="text-muted">{{ '@' . Auth::user()->username }}</p>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">About Me :</h4>
                                <p class="text-muted mb-2 font-13"><strong>Rôle :</strong> <span class="ms-2">
                                        @if (Auth::user()->role === 1) <span
                                                class="badge label-table bg-danger">Admin</span>
                                        @elseif(Auth::user()->role === 2)
                                            <span class="badge bg-success">User</span>
                                        @elseif(Auth::user()->role === 3)
                                            <span class="badge bg-blue text-light">Visitor</span>
                                        @endif
                                    </span></p>

                                <p class="text-muted mb-2 font-13"><strong>Language :</strong><span
                                        class="ms-2">{{ getLanguageName(Auth::user()->language) }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Timezone :</strong> <span
                                        class="ms-2">{{ Auth::user()->timezone }}</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Ip Address :</strong> <span
                                        class="ms-2">{{ Auth::user()->ip_address }}</span>
                                </p>
                            </div>

                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);"
                                        class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col-->

                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a id="aboutme-link" href="#aboutme" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link active">
                                        About Me
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="settings-link" href="#settings" data-bs-toggle="tab" aria-expanded="true"
                                        class="nav-link">
                                        Settings
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="aboutme">
                                    <form id="profile" method="POST" action="#" data-parsley-validate="" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" id="profile-id" value="{{ Auth::user()->id }}">
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal
                                            Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="profile-login" class="form-label">Login</label>
                                                    <input type="text" class="form-control" id="profile-login" name="login"
                                                        value="{{ Auth::user()->login }}" placeholder="Enter first name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="profile-username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="profile-username"
                                                        value="{{ Auth::user()->username }}" name="username"
                                                        placeholder="Enter last name">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="edit-user-language" class="form-label">Language</label>
                                                    <select class="form-select @error('language') parsley-error @enderror"
                                                        name="language" id="edit-user-language" required
                                                        data-parsley-length="[2, 2]"
                                                        data-parsley-length-message="select a language">
                                                        <option>Select a language</option>
                                                        <option value="ar" @if (Auth::user()->language == 'ar') selected @endif>Arabic - العربية
                                                        </option>
                                                        <option value="en" @if (Auth::user()->language == 'en') selected @endif>English</option>
                                                        <option value="fr" @if (Auth::user()->language == 'fr') selected @endif>French - français
                                                        </option>
                                                        <option value="es" @if (Auth::user()->language == 'es') selected @endif>Spanish - español
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="userpassword" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="userpassword"
                                                        placeholder="Enter password" value="">
                                                    <span class="form-text text-muted"><small>If you want to change password
                                                            please <a href="javascript: void(0);" data-bs-toggle="modal"
                                                                onclick="$('#edit-user-password-id').val({{ Auth::user()->id }})"
                                                                data-bs-target="#security-modal">click</a>
                                                            here.</small></span>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                class="mdi mdi-office-building me-1"></i> Company Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="profile-companyname" class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" id="profile-companyname"
                                                        name="companyname" value="{{ Auth::user()->account[0]->name }}"
                                                        placeholder="Enter company name" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="profile-companyurl" class="form-label">Website</label>
                                                    <input type="text" class="form-control" id="profile-companyurl"
                                                        name="companyurl" value="{{ Auth::user()->account[0]->url }}"
                                                        placeholder="Enter website url" disabled>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="text-end">
                                            <button type="submit" id="btn-profile-save"
                                                class="btn btn-success waves-effect waves-light mt-2"><i
                                                    class="mdi mdi-content-save"></i> Save</button>
                                        </div>
                                    </form>
                                </div> <!-- end tab-pane -->
                                <!-- end about me section content -->

                                <div class="tab-pane" id="settings">

                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-email-box me-1"></i>
                                                Email Account</h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-sm-end">
                                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#create-modal"><i
                                                        class="mdi mdi-plus-circle me-1"></i> Add </button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    <div id="list-email-accounts">
                                        @include('email_accounts.list')
                                    </div>

                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="header-title"><i class="mdi mdi-phone-settings-outline me-1"></i>
                                                SIP Account</h5>
                                            <a href="{{ route('sip_accounts') }}">
                                                <p class="sub-header">
                                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp click here for more details.
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-sm-end">
                                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#create-sip_account-modal"><i
                                                        class="mdi mdi-plus-circle me-1"></i> Add </button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    <div id="list-sip-accounts">
                                        @include('sip_accounts.list-redux')
                                    </div>

                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-wechat me-1"></i>
                                                SMS Account</h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-sm-end">
                                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#create-sms_account-modal"><i
                                                        class="mdi mdi-plus-circle me-1"></i> Add </button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    <div id="list-sms_accounts">
                                        @include('sms_accounts.list')
                                    </div>
                                </div>
                            </div>
                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div>
                </div> <!-- end card-->

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->

    </div> <!-- content -->
    @include('email_accounts.create')
    @include('email_accounts.edit')
    @include('users.security')
    @include('sip_accounts.create')
    @include('sip_accounts.edit')
    @include('sms_accounts.create')
    @include('sms_accounts.edit')
@endsection

@section('js')
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- Plugin js-->
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- Edit user photo js -->
    <script src="{{ asset('js/users/user-photo.js') }}"></script>

    <!-- custom js files -->
    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>
    <script src="{{ asset('js/profile/profile.js') }}"></script>
    <script src="{{ asset('js/email_accounts/email_account.js') }}"></script>
    <script src="{{ asset('js/users/edit-password.js') }}"></script>
    <script src="{{ asset('js/sip_accounts/ajax-crud.js') }}"></script>
    <script src="{{ asset('js/sms_accounts/sms_account.js') }}"></script>
    <script>
        url_photo = '{{ URL::asset('/storage/images/users/') }}';
        var create_email_account_errors = null
        var edit_email_account_errors = null
        var edit_password_errors = null
        var profile_errors = null

        var create_sip_account_errors = null
        var edit_sip_account_errors = null

        var create_sms_account_errors = null
        var edit_sms_account_errors = null
    </script>
    <script>
        if (sessionStorage.getItem('profile-tab-panel') == 'settings') {
            $('#aboutme-link').removeClass('active')
            $('#settings-link').addClass('active')

            $('#aboutme').removeClass('show active')
            $('#settings').addClass('show active')
        }
        $('#settings-link').on('click', function() {
            sessionStorage.setItem("profile-tab-panel", 'settings');
        })
        $('#aboutme-link').on('click', function() {
            sessionStorage.setItem("profile-tab-panel", 'about');
        })
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
@endsection
