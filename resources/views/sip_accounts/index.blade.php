@extends('layouts.app', ['title' => 'Sip Accounts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

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
                                <li class="breadcrumb-item"><a href="{{ route('settings') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Sip Accounts</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Sip Accounts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h4 class="header-title">List of Sip Accounts</h4>
                                    <p class="sub-header">
                                        All Sip Accounts are mentioned here.
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">
                                        <a href="javascript: void(0);" class="btn btn-warning" title="Calls Logs"
                                            data-bs-toggle="" onclick="viewListCallLogs()"
                                            data-bs-target="#calls-logs-modal"><i class="mdi mdi-history"></i></a>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#create-sip_account-modal">
                                            <i class="mdi mdi-plus-circle me-1"></i> Add Sip Account</button>
                                    </div>
                                </div><!-- end col-->
                            </div>
                            <div id="view-list-sip_accounts">
                                @include('sip_accounts.list')
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->

                <div class="col-lg-2" id="sip_accounts-info-card">
                    @include('sip_accounts.info')
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    @include('sip_accounts.create')
    @include('sip_accounts.edit')
    <div class="" id="calls-logs-div"></div>
    @if ($sip_accounts->count() > 0)

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

    <!-- custom js files -->
    <script src="/js/sip_accounts/datatable-sipaccounts.init.js"></script>
    <script src="/js/sip_accounts/sip_accounts.js"></script>
    <script src="/js/sip_accounts/ajax-crud.js"></script>
    <script src="/js/form-validation-laravel.js"></script>
    <script>
        url_jsfile = '{{ URL::asset('/js/sip_accounts/') }}';
        var create_sip_account_errors = null
        var edit_sip_account_errors = null
    </script>

    <!-- App js-->
    <script src="/js/app.min.js"></script>
@endsection
