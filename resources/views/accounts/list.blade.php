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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">List of Accounts</h4>
                    <p class="sub-header">
                        All accounts are mentioned here.
                    </p>

                    <div class="mb-2">
                        <div class="row row-cols-sm-auto g-2 align-items-center">
                            <div class="col-12 text-sm-center">
                                <select id="demo-foo-filter-status" class="form-select form-select-sm">
                                    <option value="">Show all</option>
                                    <option value="active">Active</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <input id="demo-foo-search" type="text" placeholder="Search"
                                    class="form-control form-control-sm" autocomplete="on">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                            <thead>
                                <tr>
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
                                    <tr>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->url }}</td>
                                        <td>
                                            @if ($account->status === 1) <span
                                                class="badge bg-success">Active</span> @else
                                                <span class="badge bg-dark text-light">Disabled</span>
                                            @endif
                                        </td>
                                        <td>{{ $account->start_date }}</td>
                                        <td>{{ $account->end_date }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="action-icon" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal" id="{{ $account->id }}"> <i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i
                                                    class="mdi mdi-delete"></i></a>
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

    <!-- Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal parsley-account" id="create-account" method="POST"
                        action="{{ route('create') }}" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="col-4 col-xl-3 col-form-label">Name<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <input type="text"
                                    class="form-control @error('name') parsley-error @else parsley-success @enderror"
                                    id="name" name="name" placeholder="Name" required data-parsley-minlength="3">
                                @error('name')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('name') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="col-4 col-xl-3 col-form-label">Url<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <input type="url"
                                    class="form-control @error('url') parsley-error @else parsley-success @enderror"
                                    id="url" name="url" placeholder="Url" required data-parsley-type="url">
                                @error('url')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('url') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="col-4 col-xl-3 col-form-label">Status<span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-xl-9">
                                <select class="form-select @error('status') parsley-error @else parsley-success @enderror"
                                    name="status" required data-parsley-type="integer" data-parsley-length="[1, 1]">
                                    <option value="1">Active</option>
                                    <option value="0">Disable</option>
                                </select>
                                @error('status')
                                    <ul class="parsley-errors-list filled" aria-hidden="false">
                                        <li class="parsley-required">{{ $errors->first('status') }}</li>
                                    </ul>
                                @else
                                    <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                @enderror
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light"
                                onclick="$('#edit-modal').modal('toggle');">Cancel</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('js')
    <!-- Vendor js -->
    <script src="/js/vendor.min.js"></script>

    <!-- Footable js -->
    <script src="/libs/footable/footable.all.min.js"></script>

    <!-- custom js-->
    <script src="/js/accounts/accounts-list.js"></script>
    <script src="/js/accounts/accounts-modal.js"></script>

    <!-- App js -->
    <script src="/js/app.min.js"></script>
@endsection
