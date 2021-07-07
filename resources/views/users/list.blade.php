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

    <!-- css file for select filter 
        <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>-->
    <!-- css file for select filter end -->

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h4 class="header-title">List of Users</h4>
                                    <p class="text-muted font-13 mb-4">
                                        All users are mentioned here.
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#view-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add User</button>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <table id="datatable-users" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="select-filter">Id</th>
                                        <th class="select-filter">Username</th>
                                        <th class="select-filter">role</th>
                                        <th>photo</th>
                                        <th class="select-filter">account</th>
                                        <th class="select-filter">status</th>
                                        <th>action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr id="userid{{ $user->id }}">
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
                                            <td>{{ $user->account_id }}</td>
                                            <td>
                                                @if ($user->status === 1) <span
                                                    class="badge bg-success">Active</span> @elseif ($user->status === 0)
                                                    <span class="badge label-table bg-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#view-modal" id="view-{{ $user->id }}"
                                                        onclick="editAccount({{ $user->id }});"
                                                        data-toggle="modal">View</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a id="edit-{{ $user->id }}" class="dropdown-item @if ($user->status == 0) disabled @endif"
                                                            href="{{ route('user.edit', $user->id) }}">Edit</a>
                                                        @csrf
                                                        <a id="delete-{{ $user->id }}" class="dropdown-item" href="#"
                                                        onclick="@if ($user->status == 0) restoreUser({{ $user->id }}); @else
                                                            deleteUser({{ $user->id }}); @endif">
                                                            @if ($user->status == 0) Active
                                                            @else Disable @endif</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Add note</a>
                                                        <a class="dropdown-item" href="#">Send Email (Invitation)</a>
                                                        <a class="dropdown-item" href="#">Send SMS</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Username</th>
                                        <th>role</th>
                                        <th class="disabled">photo</th>
                                        <th>account</th>
                                        <th>status</th>
                                        <th class="disabled">action</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            @include('users.edit-modal')
        @endsection

        @section('js')
            <!-- Vendor js -->
            <script src="/js/vendor.min.js"></script>

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

            <!-- js file for select filter 
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>-->
            <!-- js file for select filter end -->

            <!-- custom js files -->
            <script src="/js/users/datatables.init.js"></script>
            <script src="/js/users/users-ajax-list.js"></script>
            <script src="/js/users/users-validation.js"></script>
            <script src="/js/users/users-select.js"></script>
            <script src="/js/users/users-ajax.js"></script>
            <!-- custom js files end -->

            <!-- App js -->
            <script src="/js/app.min.js"></script>
        @endsection
