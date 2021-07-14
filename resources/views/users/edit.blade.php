@extends('layouts.app', ['title' => 'Edit User'])

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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit User</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Edit User</h4>
                            <p class="sub-header">
                                Fill the form to Edit user
                            </p>

                            <form class="form-horizontal parsley-user" id="edit-user" method="POST" action="@if ($user->status == 0) #@else{{ route('user.update', $user->id) }} @endif"
                                data-parsley-validate="" novalidate enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="id" id="id" value="{{ $user->id }}" hidden>
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="username" class="col-4 col-xl-3 col-form-label">username<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9" id="div-username">
                                                <input type="text"
                                                    class="form-control @error('username') parsley-error @enderror"
                                                    id="username" name="username" value="{{ $user->username }}"
                                                    placeholder="username" required data-parsley-minlength="3"
                                                    pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                                    data-parsley-pattern-message="This value should be a valid username">
                                                <span class="parsley-errors-list username_error"></span>
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
                                            <label for="login" class="col-4 col-xl-3 col-form-label">login<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9" id="div-login">
                                                <input type="text"
                                                    class="form-control @error('login') parsley-error @enderror" id="login"
                                                    name="login" value="{{ $user->login }}" placeholder="login" required
                                                    data-parsley-minlength="3" pattern="^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$"
                                                    data-parsley-pattern-message="This value should be a valid login">
                                                <span class="parsley-errors-list login_error"></span>
                                                @error('login')
                                                    <ul class="parsley-errors-list filled" id="error-login" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('login') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" id="success-login" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="pwd" class="col-4 col-xl-3 col-form-label">password</label>
                                            <div class="col-8 col-xl-9" id="div-password">
                                                <input type="password"
                                                    class="form-control @error('pwd') parsley-error @enderror" id="pwd"
                                                    name="pwd" placeholder="password"
                                                    data-parsley-minlength="8"
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
                                                    <input id="showpwd" type="checkbox" onclick="showPassword('pwd');">
                                                    <label for="showpwd">Show password</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="role" class="col-4 col-xl-3 col-form-label">role<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9" id="div-role">
                                                <select class="form-select @error('role') parsley-error @enderror"
                                                    name="role" required data-parsley-type="integer"
                                                    data-parsley-length="[1, 1]">
                                                    <option value="1" @if ($user->role == 1) selected @endif>admin</option>
                                                    <option value="2" @if ($user->role == 2) selected @endif>user</option>
                                                    <option value="3" @if ($user->role == 3) selected @endif>visitor</option>
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
                                            <label for="language" class="col-4 col-xl-3 col-form-label">language<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9" id="div-language">
                                                <input name="language-val" type="text" id="language-val"
                                                    value="{{ $user->language }}" hidden>
                                                <select class="form-select @error('language') parsley-error @enderror"
                                                    name="language" id="language" required data-parsley-length="[2, 5]" data-parsley-length-message="select a language">
                                                    <option>Select a language</option>
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
                                            <label for="account_id" class="col-4 col-xl-3 col-form-label">account<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9" id="div-account">
                                                <select class="form-select @error('account_id') parsley-error @enderror"
                                                    name="account_id" required data-parsley-type="integer">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}" @if ($user->account_id == $account->id) selected @endif>{{ $account->name }}
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
                                        <input name="status" value="1" hidden>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="photo" class="col-4 col-xl-3 col-form-label">photo<span
                                                class="text-danger">*</span></label>
                                        <div class="col-8 col-xl-9" id="div-photo">
                                            <input type="file"
                                                class="form-control @error('photo') parsley-error @enderror" id="photo"
                                                name="photo" data-plugins="dropify"
                                                value="{{ asset('storage/images/users/' . $user->photo) }}"
                                                data-default-file="{{ asset('storage/images/users/' . $user->photo) }}"
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
                                <button type="submit" id="edit" class="btn btn-info waves-effect waves-light @if ($user->status == 0) disabled @endif">Edit</button>
                                <button type="button" id="delete" class="btn btn-danger waves-effect waves-light @if ($user->status == 0) disabled @endif"
                                    onclick="deleteUser({{ $user->id }});">Delete</button>
                            </form>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->
            <!-- Danger Alert Modal -->
            @if ($user->status == 0)
                <div id="danger-alert-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true"
                    style="display: block;">
                @else
                    <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            @endif
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-filled bg-danger">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-wrong h1 text-white"></i>
                            <h4 class="mt-2 text-white">Oh snap!</h4>
                            <p class="mt-3 text-white">This user has been deleted, you can press button restore to change
                                his state.</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal"
                                onclick="restoreUser({{ $user->id }});">Restore</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
        <script src="/js/pages/form-fileuploads.init.js"></script>

        <!-- custom js files -->
        <script src="/js/users/users-validation.js"></script>
        <script src="/js/users/users-select.js"></script>
        <script src="/js/users/users-ajax.js"></script>
        <script>
            $('document').ready(function() {
                $("#language").val($('#language-val').val()).attr("selected", "selected");
                $("#timezone").val($('#timezone-val').val()).attr("selected", "selected");
            })
        </script>

        <!-- App js-->
        <script src="/js/app.min.js"></script>
    @endsection
