@extends('layouts.app', ['title' => 'Notes'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

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
                                <li class="breadcrumb-item active">Notes</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Notes</h4>
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
                                    <div class="text-sm-end">
                                        <button type="button"
                                            class="btn btn-danger btn-rounded waves-effect waves-light mb-3"
                                            data-bs-toggle="modal" data-bs-target="#create-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Add Note</button>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end">

                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive" id="view-list" data-simplebar>
                                <table id="datatable-notes"
                                    class="table table-center dt-responsive nowrap table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-filter">Id</th>
                                            <th class="select-filter">Class</th>
                                            <th class="select-filter">Visibility</th>
                                            <th class="select-filter">Element</th>
                                            <th class="text-filter">Element Id</th>
                                            <th class="text-filter">Content</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notes as $note)
                                            <tr id="noteid{{ $note->id }}" onclick="viewNote({{ $note->id }});">
                                                <td>{{ $note->id }}</td>
                                                <td>{{ getNoteClassName($note->class) }}</td>
                                                <td>
                                                    @if ($note->visibility === 1) <span
                                                            class="badge bg-success">Visible for all</span>
                                                    @elseif ($note->visibility === 0)
                                                        <span class="badge label-table bg-danger">Visible only for
                                                            admin</span>
                                                    @endif
                                                </td>
                                                <td>{{ getElementName($note->element) }}</td>
                                                <td>{{ $note->element_id }}</td>
                                                <td>{{ $note->content }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th class="select account">Class</th>
                                            <th class="select">Visibility</th>
                                            <th class="select account">Element</th>
                                            <th>Element Id</th>
                                            <th>Content</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
                @if ($notes->count() > 0)
                    <div class="col-lg-4" id="note-info-card">
                        @include('notes.note-info')
                    </div>
                @endif
            </div>
            <!-- end row -->
            @include('notes.create')
            @if ($notes->count() > 0)
                @include('notes.edit')
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
            <script src="/js/notes/notes-list.js"></script>
            <script src="/js/notes/datatable-notes.init.js"></script>
            <script src="/js/notes/notes-validation.js"></script>
            <script src="/js/form-validation-laravel.js"></script>
            <script>
                url_jsfile = '{{ URL::asset('/js/notes/') }}';
                var create_note_errors = null
                var edit_note_errors = null
            </script>
            <!-- custom js files end -->

            <!-- App js -->
            <script src="/js/app.min.js"></script>
        @endsection
