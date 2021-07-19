@extends('layouts.app', ['title' => 'Contacts Group'])

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
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                                <li class="breadcrumb-item active">Groups</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Contacts Group</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <table id="datatable-groups"
                                class="table table-center dt-responsive nowrap table-hover w-100">
                                <thead>
                                    <tr>
                                        <th class="text-filter">Id</th>
                                        <th class="select-filter">Account</th>
                                        <th class="select-filter">Class</th>
                                        <th class="select-filter">Source</th>
                                        <th class="text-filter">Source Id</th>
                                        <th class="text-filter">Creation Date</th>
                                        <th class="select-filter">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr id="contactid{{ $contact->id }}"
                                            onclick="viewContact({{ $contact->id }}, {{ $contact->class }});">
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->account[0]->name }}</td>
                                            <td>
                                                @if ($contact->class === 2)
                                                    <span class="badge bg-success">Company</span>
                                                @elseif($contact->class === 1)
                                                    <span class="badge bg-blue text-light">Person</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contact->source === 1) <span
                                                        class="badge label-table bg-danger">Telephone prospecting</span>
                                                @elseif($contact->source === 2)
                                                    <span class="badge bg-warning">Landing pages</span>
                                                @elseif($contact->source === 3)
                                                    <span class="badge bg-success">Affiliation</span>
                                                @elseif($contact->source === 4)
                                                    <span class="badge bg-blue text-light">Database purchased</span>
                                                @endif
                                            </td>
                                            <td>{{ $contact->source_id }}</td>
                                            <td>{{ $contact->creation_date }}</td>
                                            <td>
                                                @if ($contact->status === 1) <span
                                                        class="badge label-table bg-success">Lead</span>
                                                @elseif($contact->status === 2)
                                                    <span class="badge bg-blue text-light">Customer</span>
                                                @elseif($contact->status === 3)
                                                    <span class="badge bg-danger">Not interested</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="">Id</th>
                                        <th class="select account">Account</th>
                                        <th class="select">Class</th>
                                        <th class="select">Source</th>
                                        <th class="">Source Id</th>
                                        <th class="">Creation Date</th>
                                        <th class="select">Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->
            @include('contacts.groups.create')
            @if ($contacts->count() > 0)
                @include('contacts.groups.edit')
            @endif
        @endsection

        @section('js')
            <!-- Vendor js -->
            <script src="/js/vendor.min.js"></script>

            <!-- Plugin js-->
            <script src="/libs/parsleyjs/parsley.min.js"></script>

            <!-- Sweet Alerts js -->
            <script src="/libs/sweetalert2/sweetalert2.all.min.js"></script>

            <!-- custom js files -->
            <script src="/js/form-validation-laravel.js"></script>
            <script src="/js/contacts/groups.js"></script>
            <script>
                var groups_create_errors = null
            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
