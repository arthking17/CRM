@extends('layouts.app', ['title' => 'Settings'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- Edit user photo css -->
    <link href="/css/users/user-photo.css" rel="stylesheet" type="text/css" />

    <!-- custom style -->
    <link href="/css/custom-style.css" rel="stylesheet" type="text/css" />

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
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Settings</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill navtab-bg">
                            <li class="nav-item">
                                <a id="email-account-link" href="#email-account" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link active">
                                    Email Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="sip-account-link" href="#sip-account" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link">
                                    SIP Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="sms-account-link" href="#sms-account" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link">
                                    SMS Account
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane show active" id="email-account">

                                <div id="list-email_accounts">
                                    @include('email_accounts.datatable-email_accounts')
                                </div>
                            </div><!-- end tab-pane -->
                            <!-- end email account section content -->

                            <div class="tab-pane" id="sip-account">

                                <div id="list-sip_accounts">
                                    @include('sip_accounts.index-tab')
                                </div>
                            </div><!-- end tab-pane -->
                            <!-- end sip account section content -->

                            <div class="tab-pane" id="sms-account">

                                <div id="list-sms_accounts">
                                    @include('sms_accounts.datatable-sms_accounts')
                                </div>
                            </div><!-- end tab-pane -->
                            <!-- end sms account section content -->
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div>
            </div> <!-- end card-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

    </div> <!-- content -->
    @include('email_accounts.create')
    @include('email_accounts.edit')
    
    @include('sip_accounts.create')
    @include('sip_accounts.edit')
    <div class="" id="calls-logs-div"></div>
    @if ($sip_accounts->count() > 0)

    @endif

    @include('sms_accounts.create')
    @include('sms_accounts.edit')
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

    <!-- Edit user photo js -->
    <script src="/js/users/user-photo.js"></script>

    <!-- custom js files -->
    <script src="/js/form-validation-laravel.js"></script>
    <script src="/js/profile/settings.js"></script>

    <script src="/js/email_accounts/datatable-email_accounts.init.js"></script>
    <script src="/js/email_accounts/email_account.js"></script>

    <script src="/js/sip_accounts/datatable-sipaccounts.init.js"></script>
    <script src="/js/sip_accounts/ajax-crud.js"></script>

    <script src="/js/sms_accounts/datatable-sms_accounts.init.js"></script>
    <script src="/js/sms_accounts/sms_account.js"></script>
    <script>
        url_photo = '{{ URL::asset('/storage/images/users/') }}';
        url_jsfile_sip_accounts = '{{ URL::asset('/js/sip_accounts/') }}';
        url_jsfile_email_accounts = '{{ URL::asset('/js/email_accounts/') }}';
        url_jsfile_sms_accounts = '{{ URL::asset('/js/sms_accounts/') }}';

        var create_email_account_errors = null
        var edit_email_account_errors = null

        var create_sip_account_errors = null
        var edit_sip_account_errors = null

        var create_sms_account_errors = null
        var edit_sms_account_errors = null
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="/js/app.min.js"></script>
@endsection
