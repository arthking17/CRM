@extends('layouts.app', ['title' => $user->username])

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

    <!-- Plugins css -->
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- picker css -->
    <link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css') }}" rel="stylesheet">

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
                                <li class="breadcrumb-item active">{{ $user->username }}</li>
                            </ol>
                        </div>
                        <h4 class="page-title">User</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="card">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#user-info" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                User Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#logs" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Activity
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="appointments-link" href="#appointments" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="communications-link" href="#communications" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                Communications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="permissions-link" href="#permissions" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="notes-link" href="#notes" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                Notes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#notifications" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                Notification
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="user-info">
                            @include('users.user-info')
                        </div>
                        <div class="tab-pane" id="logs">
                            @include('users.datatable-logs')
                        </div>
                        <div class="tab-pane" id="notifications">
                            @include('users.notification')
                        </div>
                        <div class="tab-pane" id="permissions">
                            @include('permissions.users_permissions')
                        </div>
                        <div class="tab-pane" id="appointments">
                            @include('appointments.list')
                        </div>
                        <div class="tab-pane" id="communications">
                            <div id="view-list-communications">
                                @include('communications.list')
                            </div>
                        </div>
                        <div class="tab-pane" id="notes">
                            @include('notes.datatable-notes')
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('users.edit-modal')

    @include('notes.create-ext')
    @include('notes.edit-ext')

    <div id="security-div">
        @include('users.security')
    </div>

    @include('communications.create')
    @include('communications.edit')

    @include('appointments.create')
    @include('appointments.edit')

    @include('email_accounts.send-mail')

    @include('sip_accounts.call')

    @include('sms_accounts.sms')

    <div id="notes-div"></div>
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

    <!-- Plugins js -->
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>

    <!-- Tippy js-->
    <script src="{{ asset('libs/tippy.js/tippy.all.min.js') }}"></script>

    <!-- picker js -->
    <script src="{{ asset('libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/form-pickers.init.js') }}"></script>

    <!-- Init js-->
    <script src="{{ asset('js/pages/form-fileuploads.init.js') }}"></script>

    <!-- selectize js -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/selectize.min.js">
    </script>

    <!-- custom js files -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('js/users/users-ajax-list.js') }}"></script>
    <script src="{{ asset('js/users/datatable-users.init.js') }}"></script>
    <script src="{{ asset('js/custom-parsley.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>
    <script src="{{ asset('js/users/users-select.js') }}"></script>
    <script src="{{ asset('js/users/edit-password.js') }}"></script>

    <script src="{{ asset('js/notes/datatable-notes.init.js') }}"></script>
    <script src="{{ asset('js/notes/notes-module-ext.js') }}"></script>

    <!-- Edit user photo js -->
    <script src="{{ asset('js/users/user-photo.js') }}"></script>

    <!-- grid view js -->
    <script src="{{ asset('js/users/grid-view.js') }}"></script>

    <script src="{{ asset('js/users/logs.js') }}"></script>

    <!-- send email modal -->
    <script src="{{ asset('js/email_accounts/send-mail.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js') }}"></script>
    <script src="https://cdn.quilljs.com/1.0.0/quill.js') }}"></script>

    <!-- call voip modal -->
    <script src="{{ asset('js/sip_accounts/sip_accounts.js') }}"></script>

    <!-- send sms modal -->
    <script src="{{ asset('js/sms_accounts/sms.js') }}"></script>

    <script src="{{ asset('js/appointments/datatable-appointments.init.js') }}"></script>
    <script src="{{ asset('js/appointments/appointments.js') }}"></script>
    <script src="{{ asset('js/appointments/create-ext.js') }}"></script>
    <script src="{{ asset('js/appointments/edit-ext.js') }}"></script>

    <script src="{{ asset('js/communications/datatable-communications.init.js') }}"></script>
    <script src="{{ asset('js/communications/communications.js') }}"></script>
    <script src="{{ asset('js/communications/create.js') }}"></script>
    <script src="{{ asset('js/communications/edit.js') }}"></script>

    <script src="{{ asset('js/users/tab-pane.js') }}"></script>

    <!-- users permissions js -->
    <script src="{{ asset('js/permissions/users_permissions.js') }}"></script>

    <script>
        $('.dropify').dropify();
        $('document').ready(function() {
            $("#language").val($('#language-val').val()).attr("selected", "selected");
        })
        url_photo = '{{ URL::asset('/storage/images/users/') }}';
        url_jsfile = '{{ URL::asset('/js/users/') }}';
        url_jsfile_notes = '{{ URL::asset('/js/notes/') }}';
        url_audio = '{{ URL::asset('/audio') }}';

        var form_create_errors = null
        var form_edit_errors = null

        var create_note_errors = null
        var edit_note_errors = null

        var edit_permission_errors = null

        var edit_password_errors = null

        var myTimer = null

        url_jsfile_appointments = '{{ URL::asset('/js/appointments/') }}';
        var create_appointment_errors = null
        var edit_appointment_errors = null

        url_jsfile_communications = '{{ URL::asset('/js/communications/') }}';
        var create_communication_errors = null
        var edit_communication_errors = null

        var editor = new Quill('#snow-editor', {
            theme: 'snow'
        });
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
@endsection
