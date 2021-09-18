@extends('layouts.app', ['title' => 'Upload Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- custom style -->
    <link href="/css/custom-style.css" rel="stylesheet" type="text/css" />

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
                                <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                                <li class="breadcrumb-item active">Upload</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Upload Contacts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Upload Contacts</h4>
                            <p class="sub-header">
                                Drop file contact in this zone.
                            </p>

                            <form class="form-horizontal" id="upload-contact" method="POST" action="#"
                                data-parsley-validate="" novalidate enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="upload-contact-class"
                                                class="col-4 col-xl-3 col-form-label">Contact Class<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <select class="form-select @error('class') parsley-error @enderror"
                                                    name="class" id="upload-contact-class" required
                                                    data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                    <option value="1">Person Contact</option>
                                                    <option value="2">Companie Contact</option>
                                                </select>
                                                @error('class')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ $errors->first('class') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="upload-contact-account_id"
                                                class="col-4 col-xl-3 col-form-label">account<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                @if(Auth::user()->role === 1)
                                                <select class="form-select @error('account_id') parsley-error @enderror"
                                                    name="account_id" id="upload-contact-account_id" required
                                                    data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                    <option value="">Select an account</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">{{ $account->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('account_id')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ $errors->first('account_id') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                                @elseif(Auth::user()->role === 2)
                                                <input type="text" class="form-select" name="account_id" id="upload-contact-account_id" disabled value="{{ Auth::user()->account[0]->name }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="upload-contact-file" class="col-4 col-xl-3 col-form-label">Contact
                                                File<span class="text-danger">*</span></label>
                                            <div class="col-8 col-xl-9">
                                                <input type="file"
                                                    class="form-control @error('file') parsley-error @enderror"
                                                    id="upload-contact-file" name="file" placeholder="file" required
                                                    data-parsley-fileextension='csv,xlsx,xls'>
                                                @error('file')
                                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                                        <li class="parsley-required">{{ $errors->first('file') }}</li>
                                                    </ul>
                                                @else
                                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="upload-contact-header" class="col-4 col-xl-3 col-form-label"></label>
                                            <div class="col-8 col-xl-9">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="upload-contact-header">check if contains header</label>
                                                    <input type="checkbox" class="form-check-input" id="upload-contact-header" name='header'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="btn-upload"
                                            class="btn btn-success waves-effect waves-light">Upload</button>
                                    </div>
                                </div>
                                <!-- end row-->
                            </form>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    <div id="preview-list-contact-card" class="card d-none">
                        <form class="form-horizontal" id="mapping-column" method="POST" action="#" data-parsley-validate=""
                            novalidate>
                            <div class="card-header">
                                <h4 class="header-title">Match your column with system column</h4>
                            </div>
                            @csrf
                            <input type="hidden" name="account_id" id="mapping-column-account_id">
                            <input type="hidden" name="import_id" id="mapping-column-import_id">
                            <input type="hidden" name="file_path" id="mapping-column-file_path">
                            <div id="preview-list-contact" class="card-body"></div>
                            <div class="card-footer text-center">
                                <button type="submit" id="btn-import"
                                    class="btn btn-success waves-effect waves-light">import</button>
                            </div>
                        </form>
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->
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

            <!-- Footable js -->
            <script src="/libs/footable/footable.all.min.js"></script>

            <!-- custom js files -->
            <script src="/js/custom-parsley.js"></script>
            <script src="/js/contacts/import/upload.js"></script>
            <script src="/js/form-validation-laravel.js"></script>

            <script src="/js/contacts/import/datatable-contacts-preview.init.js"></script>

            <script>
                url_jsfile = '{{ URL::asset('/js/contacts/import/') }}';
                var upload_contact_errors = null
                var upload_contact_column_errors = null
            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
