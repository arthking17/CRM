@extends('layouts.app', ['title' => 'Accounts'])

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
                                <li class="breadcrumb-item active">Accounts</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Accounts</h4>
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
                                    <h4 class="header-title">List of Accounts</h4>
                                    <p class="sub-header">
                                        All accounts are mentioned here.
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#create-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add Account</button>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="mb-2">
                                <div class="row row-cols-sm-auto g-2 align-items-center">
                                    <div class="col-12 text-sm-center">
                                        <select id="demo-foo-filter-status" class="form-select form-select-sm">
                                            <option value="">Show all</option>
                                            <option value="active">Active</option>
                                            <option value="disabled">Disabled</option>
                                            <option value="legit">legit</option>
                                            <option value="invoicing">invoicing</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="demo-foo-search" type="text" placeholder="Search"
                                            class="form-control form-control-sm" autocomplete="on">
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="table-accounts" class="table table-striped toggle-circle mb-0"
                                    data-page-size="7">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th data-toggle="true">Name</th>
                                            <th>Url</th>
                                            <th>Status</th>
                                            <th>Start date</th>
                                            <th>End date</th>
                                            <th style="width: 90px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($accounts as $account)
                                            <tr id="accid{{ $account->id }}">
                                                <td>{{ $account->id }}</td>
                                                <td>{{ $account->name }}</td>   
                                                <td>{{ $account->url }}</td>
                                                <td>
                                                    @if ($account->status === 1) <span
                                                        class="badge bg-success">Active</span> @elseif ($account->status
                                                        === 0)
                                                        <span class="badge label-table bg-danger">Disabled</span>
                                                    @elseif($account->status === 2)
                                                        <span class="badge bg-blue text-light">Legit</span>
                                                    @elseif($account->status === 3)
                                                        <span class="badge bg-dark text-light">Invoicing</span>
                                                    @endif
                                                </td>
                                                <td>{{ $account->start_date }}</td>
                                                <td>{{ $account->end_date }}</td>
                                                <td>
                                                    @if ($account->status === 0)
                                                        <a href="javascript:void(0);" class="action-icon"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                    @else
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-bs-toggle="modal" data-bs-target="#edit-modal"
                                                            id="edit-{{ $account->id }}"
                                                            onclick="editAccount({{ $account->id }});"
                                                            data-toggle="modal"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                    @endif
                                                    @if ($account->status === 0)
                                                        <a href="javascript:void(0);" class="action-icon"> <i
                                                                class="mdi mdi-delete"></i></a>
                                                    @else
                                                        <a href="javascript:void(0);" id="delete-{{ $account->id }}"
                                                            onclick="deleteAccount({{ $account->id }});"
                                                            class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="active">
                                            <td colspan="6">
                                                <div class="text-end">
                                                    <ul
                                                        class="pagination pagination-rounded justify-content-end footable-pagination mb-0">
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            @include('accounts.edit')
            @include('accounts.create-modal')
        @endsection

        @section('js')
            <!-- Vendor js -->
            <script src="/js/vendor.min.js"></script>

            <!-- Plugin js-->
            <script src="/libs/parsleyjs/parsley.min.js"></script>

            <!-- Footable js -->
            <script src="/libs/footable/footable.all.min.js"></script>

            <!-- Sweet Alerts js -->
            <script src="/libs/sweetalert2/sweetalert2.all.min.js"></script>

            <!-- custom js-->
            <script src="/js/accounts/account.js"></script>
            <script src="/js/accounts/accounts-list.js"></script>
            <script src="/js/accounts/account-ajax.js"></script>

            <!-- App js -->
            <script src="/js/app.min.js"></script>
        @endsection
