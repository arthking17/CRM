@extends('layouts.app', ['title' => 'Settings'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- Edit user photo css -->
    <link href="{{ asset('css/users/user-photo.css') }}" rel="stylesheet" type="text/css" />

    <!-- selectize js -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

    <!-- App css -->
    <link href="{{ asset('css/config/creative/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('css/config/creative/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('css/config/creative/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('css/config/creative/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- custom style css files -->
    <link rel="stylesheet" href="{{ asset('build/css/countrySelect.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <!-- custom style css files end -->
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="text-sm-end">
                                    <h4 class="page-title">Settings &nbsp;
                                        <button id="settings-btn-add" class="btn btn-xs btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#create-entity-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add entity </button> <!-- entity is setup in settings.js -->
                                    </h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ config('app.name') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">Settings</li>
                                    </ol>
                                </div>
                            </div><!-- end col-->
                        </div>
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
                            <li class="nav-item">
                                <a id="shortcodes-link" href="#shortcodes" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link">
                                    ShortCode
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="custom_fields-link" href="#custom_fields" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link">
                                    Custom Field
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

                            <div class="tab-pane" id="shortcodes">

                                <div id="list-shortcodes">
                                    @include('shortcodes.list')
                                </div>
                            </div><!-- end tab-pane -->
                            <!-- end shortcodes section content -->

                            <div class="tab-pane" id="custom_fields">

                                <div id="list-custom_fields">
                                    @include('custom-fields.list')
                                </div>
                            </div><!-- end tab-pane -->
                            <!-- end custom-fields section content -->
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
    <div class="" id=" calls-logs-div"></div>

    @include('sms_accounts.create')
    @include('sms_accounts.edit')

    @include('shortcodes.create')
    @include('shortcodes.edit')

    @include('custom-fields.create')
    @include('custom-fields.edit')
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

    <!-- selectize js -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/selectize.min.js">
    </script>

    <!-- Edit user photo js -->
    <script src="{{ asset('js/users/user-photo.js') }}"></script>

    <!-- custom js files -->
    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>
    <script src="{{ asset('js/profile/settings.js') }}"></script>

    <script src="{{ asset('js/email_accounts/datatable-email_accounts.init.js') }}"></script>
    <script src="{{ asset('js/email_accounts/email_account.js') }}"></script>

    <script src="{{ asset('js/sip_accounts/datatable-sipaccounts.init.js') }}"></script>
    <script src="{{ asset('js/sip_accounts/ajax-crud.js') }}"></script>

    <script src="{{ asset('js/sms_accounts/datatable-sms_accounts.init.js') }}"></script>
    <script src="{{ asset('js/sms_accounts/sms_account.js') }}"></script>

    <script src="{{ asset('js/contacts/country-select.js') }}"></script>

    <script src="{{ asset('js/shortcodes/datatable-shortcodes.init.js') }}"></script>
    <script src="{{ asset('js/shortcodes/shortcodes.js') }}"></script>

    <script src="{{ asset('js/custom-fields/datatable-custom_fields.init.js') }}"></script>
    <script src="{{ asset('js/custom-fields/custom-fields.js') }}"></script>
    <script src="{{ asset('js/custom-fields/form-create.js') }}"></script>

    <script>
        url_photo = '{{ URL::asset('/storage/images/users/') }}';
        url_jsfile_sip_accounts = '{{ URL::asset('/js/sip_accounts/') }}';
        url_jsfile_email_accounts = '{{ URL::asset('/js/email_accounts/') }}';
        url_jsfile_sms_accounts = '{{ URL::asset('/js/sms_accounts/') }}';
        url_jsfile_shortcodes = '{{ URL::asset('/js/shortcodes/') }}';

        var create_email_account_errors = null
        var edit_email_account_errors = null

        var create_sip_account_errors = null
        var edit_sip_account_errors = null

        var create_sms_account_errors = null
        var edit_sms_account_errors = null

        var create_shortcode_errors = null
        var edit_shortcode_errors = null

        var create_custom_field_errors = null
        var edit_custom_field_errors = null

        var url_jsfile_custom_fields = '{{ URL::asset('/js/custom-fields/') }}';
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
@endsection
