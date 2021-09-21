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

    <!-- Edit user photo css -->
    <link href="/css/users/user-photo.css" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

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
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="text-sm-end">
                                    <h4 class="page-title">Users &nbsp; &nbsp;
                                        <a href="{{ route('users.groups') }}" class="btn- btn-xs btn-info">
                                            <i class="mdi mdi-layers-outline"></i> Groups
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ config('app.name') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">Users</li>
                                    </ol>
                                </div>
                            </div><!-- end col-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">

                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="#tab-list-view" data-bs-toggle="tab" aria-expanded="true"
                                        class="nav-link active">
                                        <i class="mdi mdi-format-list-bulleted-type"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tab-grid-view" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link">
                                        <i class="mdi mdi-apps"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="tab-list-view">
                                    <div id="view-list">
                                        @include('users.datatable-users')
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-grid-view">
                                    <div class="row" id="view-grid">
                                        <div class="card-header">
                                            <div class="row justify-content-between">
                                                <div class="col-auto">
                                                    <form class="d-flex flex-wrap align-items-center">
                                                        <label for="inputPassword2" class="visually-hidden">Search</label>
                                                        <div class="me-3">
                                                            <input type="search" class="form-control my-1 my-lg-0"
                                                                id="view-grid-search" placeholder="Search...">
                                                        </div>
                                                        <label for="status-select" class="me-2">Sort
                                                            By</label>
                                                        <div class="me-sm-3">
                                                            <select class="form-select my-1 my-lg-0" id="view-grid-sort">
                                                                <option value="id" selected>All</option>
                                                                <option value="username">Username</option>
                                                                <option value="role">Role</option>
                                                                <option value="status">Status</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div> <!-- end row -->
                                        </div>
                                        <div class="card-body">
                                            <div id="view-grid-users">
                                                @if (count($users) > 0)
                                                    @include('users.grid')
                                                @else
                                                    <p class="text-center">No data available in table</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <ul class="pagination pagination-rounded justify-content-end mb-3">
                                                <li class="paginate_button page-item previous">
                                                    <a class="page-link" href="javascript: void(0);"
                                                        onclick="viewGridPagePreviousPage();" aria-label="Previous">
                                                        <span aria-hidden="true">«</span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </a>
                                                </li>
                                                @for ($i = 0; $i < $users->count(); $i += 8)
                                                    <li class="page-item @if ($i / 8 < 1) active @endif"
                                                        id="pageno{{ $i / 8 + 1 }}"><a class="page-link"
                                                            href="javascript: void(0);"
                                                            onclick="viewGridPageItem({{ $i / 8 + 1 }});">{{ $i / 8 + 1 }}</a>
                                                    </li>
                                                @endfor
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);"
                                                        onclick="viewGridPageNextPage({{ $users->count() / 8 }});"
                                                        aria-label="Next">
                                                        <span aria-hidden="true">»</span>
                                                        <span class="visually-hidden">Next</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-lg-3">
                    <div class="card" id="logs-info-card">
                        @include('users.logs-info')
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('users.create-modal')
    @include('users.edit-modal')

    @include('email_accounts.send-mail')

    @include('sip_accounts.call')

    @include('sms_accounts.sms')
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

    <!-- Tippy js-->
    <script src="/libs/tippy.js/tippy.all.min.js"></script>

    <!-- Init js-->
    <script src="/js/pages/form-fileuploads.init.js"></script>

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
    <script src="/js/users/users-ajax-list.js"></script>
    <script src="/js/users/datatable-users.init.js"></script>
    <script src="/js/custom-parsley.js"></script>
    <script src="/js/form-validation-laravel.js"></script>
    <script src="/js/users/users-select.js"></script>
    <script src="/js/users/edit-password.js"></script>

    <script src="/js/notes/notes-module-ext.js"></script>

    <!-- Edit user photo js -->
    <script src="/js/users/user-photo.js"></script>

    <!-- grid view js -->
    <script src="/js/users/grid-view.js"></script>

    <!-- send email modal -->
    <script src="/js/email_accounts/send-mail.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

    <!-- call voip modal -->
    <script src="/js/sip_accounts/sip_accounts.js"></script>

    <!-- send sms modal -->
    <script src="/js/sms_accounts/sms.js"></script>

    <script>
        $('.dropify').dropify();
        $('document').ready(function() {
            $("#language").val($('#language-val').val()).attr("selected", "selected");
        })
        url_photo = '{{ URL::asset('/storage/images/users/') }}';
        url_jsfile = '{{ URL::asset('/js/users/') }}';
        var form_create_errors = null
        var form_edit_errors = null
        var create_note_errors = null
        var edit_note_errors = null
        var edit_password_errors = null
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="/js/app.min.js"></script>
@endsection
