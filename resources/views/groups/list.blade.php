@extends('layouts.app', ['title' => 'Users Group'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

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
                                <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                                <li class="breadcrumb-item active">Groups</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Users Group</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="card" id="user-permissions-info-card">
                        @include('permissions.users-permissions-info')
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h4 class="header-title">List of Groups</h4>
                                    <p class="sub-header">
                                        All groups of users are mentioned here.
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#create-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add Groups</button>
                                    </div>
                                </div><!-- end col-->
                            </div>
                            <div class="table-responsive" id="view-list" data-simplebar>
                                <table id="datatable-groups"
                                    class="table table-center dt-responsive nowrap table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-filter">Id</th>
                                            <th class="select-filter">Account</th>
                                            <th class="text-filter">Name</th>
                                            <th class="disabled">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groups as $group)
                                            <tr id="groupid{{ $group->id }}" onclick="viewGroup({{ $group->id }});">
                                                <td>{{ $group->id }}</td>
                                                <td>{{ $group->name }}</td>
                                                <td>{{ $group->account[0]->name }}</td>
                                                <td>
                                                    <div class="text-sm-end">
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-bs-toggle="modal" data-bs-target="#edit-modal"
                                                            onclick="editGroup({{ $group->id }});"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            onclick="deleteGroup({{ $group->id }});"> <i
                                                                class="mdi mdi-delete-circle"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="">Id</th>
                                            <th class="select account">Account</th>
                                            <th class="">Name</th>
                                            <th class="disabled">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->

                <div class="col-lg-3" id="group-info-card">
                    @include('groups.group-info')
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('groups.create')
    @include('groups.edit')
    @if ($groups->count() > 0)
        <div id="users_permissions-div">
            @include('permissions.users_permissions')
        </div>
        <div id="create-Permission-div">
            @include('permissions.create-permission')
        </div>
    @endif
@endsection

@section('js')
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- Plugin js-->
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <!-- button pdf copy -->
    <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- style button -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <!-- style button end -->
    <!-- button print -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <!-- not use -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <!-- not use end -->
    <!-- pdf -->
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <!-- custom js files -->
    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>
    <script src="{{ asset('js/groups/groups-list.js') }}"></script>
    <script src="{{ asset('js/groups/groups-validation.js') }}"></script>
    <script src="{{ asset('js/groups/datatable-groups.init.js') }}"></script>
    <script src="{{ asset('js/users/users-select.js') }}"></script>

    <!-- users permissions js -->
    <script src="{{ asset('js/users/users-permissions.js') }}"></script>
    <script>
        url_jsfile = '{{ URL::asset('/js/groups/') }}';
        var create_group_errors = null
        var edit_group_errors = null
        var create_permission_errors = null
        elementSelect($('#create-permissions-element'))
    </script>

    <!-- App js-->
    <script src="{{ asset('js/app.min.js') }}"></script>
@endsection
