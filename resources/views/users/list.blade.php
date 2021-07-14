@extends('layouts.app', ['title' => 'Users'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

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
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Users</h4>
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
                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light mb-3"
                                        data-bs-toggle="modal" data-bs-target="#create-modal"><i
                                            class="mdi mdi-plus-circle me-1"></i> Add User</button>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <div class="btn-group mb-3 ms-2 d-none d-sm-inline-block">
                                            <button type="button" id="button-view-list" class="btn btn-dark"><i
                                                    class="mdi mdi-format-list-bulleted-type"></i></button>
                                        </div>
                                        <div class="btn-group mb-3 d-none d-sm-inline-block">
                                            <button type="button" id="button-view-grid" class="btn btn-link text-dark"><i
                                                    class="mdi mdi-apps"></i></button>
                                        </div>
                                    </div>
                                </div><!-- end col-->
                            </div>


                            <div id="view-grid-users" class="row">
                                @include('users.grid')
                            </div>
                            <div class="" id="view-list">
                                <table id="datatable-users"
                                    class="table table-center dt-responsive nowrap table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th class="select-filter">Id</th>
                                            <th class="select-filter">Username</th>
                                            <th class="select-filter">role</th>
                                            <th>photo</th>
                                            <th class="select-filter">account</th>
                                            <th class="select-filter">status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr id="userid{{ $user->id }}" onclick="viewUser({{ $user->id }});">
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    @if ($user->role === 1) <span
                                                            class="badge label-table bg-danger">Admin</span>
                                                    @elseif($user->role === 2)
                                                        <span class="badge bg-success">User</span>
                                                    @elseif($user->role === 3)
                                                        <span class="badge bg-blue text-light">Visitor</span>
                                                    @endif
                                                </td>
                                                <td><img class="img-fluid avatar-sm rounded"
                                                        src="{{ asset('storage/images/users/' . $user->photo) }}" /></td>
                                                <td>{{ $user->account[0]->name }}</td>
                                                <td>
                                                    @if ($user->status === 1) <span
                                                        class="badge bg-success">Active</span> @elseif ($user->status
                                                        === 0)
                                                        <span class="badge label-table bg-danger">Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>id</th>
                                            <th>username</th>
                                            <th>role</th>
                                            <th class="disabled">photo</th>
                                            <th>account</th>
                                            <th>status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-lg-4" id="user-info-card">
                    @include('users.user-info')
                </div>
            </div>
            <!-- end row -->
            @include('users.create-modal')
            @if ($users->count() > 0)
            @include('users.edit-modal')
            @include('users.add_note')
            <div id="logs-div">
                @include('users.logs')
            </div>
            <div id="users_permissions-div">
                @include('users.users_permissions')
            </div>
            <div id="security-div">
                @include('users.security')
            </div>
            <div id="notification-div">
                @include('users.notification')
            </div>
            <div id="notes-div">
                @include('users.notes')
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

            <!-- Plugins js -->
            <script src="/libs/dropzone/min/dropzone.min.js"></script>
            <script src="/libs/dropify/js/dropify.min.js"></script>

            <!-- Init js-->
            <script src="/js/pages/form-fileuploads.init.js"></script>

            <!-- custom js files
                                                        <script src="/js/users/datatables.init.js"></script> -->
            <script src="/js/users/users-ajax-list.js"></script>
            <script src="/js/users/users-validation.js"></script>
            <script src="/js/users/users-select.js"></script>
            <script>
                $('.dropify').dropify();
                $('document').ready(function() {
                    $("#language").val($('#language-val').val()).attr("selected", "selected");
                })
                url_photo = '{{ URL::asset('/storage/images/users/') }}';
            </script>
            <!-- custom js files end -->

            <!-- App js -->
            <script src="/js/app.min.js"></script>
        @endsection
