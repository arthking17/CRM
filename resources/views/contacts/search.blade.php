@extends('layouts.app', ['title' => 'Search Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- Plugins css -->
    <link href="/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />

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
                                <li class="breadcrumb-item active">Search</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Search Contacts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Search Contacts</h4>
                            <p class="sub-header">
                                Fill the form to search contact
                            </p>


                            <form class="form-horizontal" id="search-contact" method="POST"
                                action="{{ route('contacts.search') }}" data-parsley-validate="" novalidate>
                                @csrf
                                <div id="search-contact-wizard">
                                    <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                                        <li class="nav-item" data-target-form="#classForm">
                                            <a href="#contact-class" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 pt-2 pb-2">
                                                <i class="mdi mdi-account-circle me-1"></i>
                                                <span class="d-none d-sm-inline">Contact</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" data-target-form="#personForm" id="search-nav-tab-info">
                                            <a href="#search-person-contact" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 pt-2 pb-2">
                                                <i class="mdi mdi-face-profile me-1"></i>
                                                <span class="d-none d-sm-inline">Contact Info</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#search-contact-data" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 pt-2 pb-2">
                                                <i class="mdi mdi-face-profile me-1"></i>
                                                <span class="d-none d-sm-inline">Contact Data</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content b-0 mb-0 pt-0">

                                        <div id="bar" class="progress mb-3" style="height: 7px;">
                                            <div
                                                class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="contact-class">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-account_id"
                                                            class="col-4 col-xl-3 col-form-label">account</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('account_id') parsley-error @enderror"
                                                                name="account_id" id="search-contact-account_id"
                                                                data-parsley-type="integer" data-parsley-length="[1, 10]">
                                                                <option value="">no choice</option>
                                                                @foreach ($accounts as $account)
                                                                    <option value="{{ $account->id }}">
                                                                        {{ $account->name }}
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
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-id"
                                                            class="col-4 col-xl-3 col-form-label">Contact
                                                            Id</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('id') parsley-error @enderror"
                                                                id="search-contact-id" name="id" placeholder="id">
                                                            @error('id')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">{{ $errors->first('id') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-source_id"
                                                            class="col-4 col-xl-3 col-form-label">Source
                                                            Id</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('source_id') parsley-error @enderror"
                                                                name="source_id" id="search-contact-source_id"
                                                                placeholder="Identifier of Source"
                                                                data-parsley-type="integer" data-parsley-maxlength="10">
                                                            @error('source_id')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('source_id') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-group_id"
                                                            class="col-4 col-xl-3 col-form-label">Group Name</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('group_id') parsley-error @enderror"
                                                                name="group_id" id="search-contact-group_id"
                                                                data-parsley-type="integer" data-parsley-length="[1, 10]">
                                                                <option value="">no choice</option>
                                                                @foreach ($groups as $group)
                                                                    <option value="{{ $group->id }}">
                                                                        {{ $group->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('group_id')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('group_id') }}</li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-adding_method"
                                                            class="col-4 col-xl-3 col-form-label">Adding Method</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input class="form-check-input" type="radio"
                                                                name="adding_method" id="adding_method" checked="" value="">
                                                            <label class="form-check-label" for="adding_method">no
                                                                choice</label>

                                                            <input class="form-check-input" type="radio"
                                                                name="adding_method" id="adding_method1" value="1">
                                                            <label class="form-check-label" for="adding_method1">Unitally
                                                                added</label>

                                                            <input class="form-check-input" type="radio"
                                                                name="adding_method" id="adding_method2" value="2">
                                                            <label class="form-check-label"
                                                                for="adding_method2">Import</label>
                                                            @error('adding_method')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('adding_method') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-status"
                                                            class="col-4 col-xl-3 col-form-label">Status</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('status') parsley-error @enderror"
                                                                name="status" id="search-contact-status"
                                                                data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                                <option value="">no choice</option>
                                                                <option value="1">Lead</option>
                                                                <option value="2">Customer</option>
                                                                <option value="3">Not interested</option>
                                                            </select>
                                                            @error('status')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('status') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-class"
                                                            class="col-4 col-xl-3 col-form-label">Contact
                                                            Type</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('class') parsley-error @enderror"
                                                                name="class" id="search-contact-class"
                                                                data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                                <option value="">no choice</option>
                                                                <option value="1">Person</option>
                                                                <option value="2">Company</option>
                                                            </select>
                                                            @error('class')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('class') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-source"
                                                            class="col-4 col-xl-3 col-form-label">Source
                                                            Type</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('source') parsley-error @enderror"
                                                                name="source" id="search-contact-source"
                                                                data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                                <option value="">no choice</option>
                                                                <option value="1">Telephone prospecting</option>
                                                                <option value="2">Landing pages</option>
                                                                <option value="3">Affiliation</option>
                                                                <option value="4">Database purchased</option>
                                                            </select>
                                                            @error('source')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('source') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-creation_date"
                                                            class="col-4 col-xl-3 col-form-label">Creation Date</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input
                                                                class="form-control @error('creation_date') parsley-error @enderror"
                                                                type="date" name="creation_date"
                                                                id="search-contact-creation_date"
                                                                data-parsley-maxdate="{{ date('m/d/Y') }}">
                                                            @error('creation_date')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('creation_date') }}</li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-import_id"
                                                            class="col-4 col-xl-3 col-form-label">Import
                                                            Id</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('import_id') parsley-error @enderror"
                                                                name="import_id" id="search-contact-import_id"
                                                                placeholder="Identifier of Import"
                                                                data-parsley-type="integer" data-parsley-maxlength="10">
                                                            @error('import_id')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('import_id') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                        </div>

                                        <div class="tab-pane" id="search-person-contact">
                                            <div class="row">
                                                <h3 class="mt-0 text-muted text-center">Person Contact</h3>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-first_name"
                                                            class="col-4 col-xl-3 col-form-label">First
                                                            Name</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('first_name') parsley-error @enderror"
                                                                name="first_name" id="search-contact-first_name"
                                                                placeholder="First Name" data-parsley-minlength="2">
                                                            @error('first_name')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('first_name') }}</li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-nickname"
                                                            class="col-4 col-xl-3 col-form-label">Nickname</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('nickname') parsley-error @enderror"
                                                                name="nickname" id="search-contact-nickname"
                                                                placeholder="Nickname" data-parsley-minlength="2">
                                                            @error('nickname')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('nickname') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-birthdate"
                                                            class="col-4 col-xl-3 col-form-label">Birthdate</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input
                                                                class="form-control @error('birthdate') parsley-error @enderror"
                                                                type="date" name="birthdate" id="search-contact-birthdate"
                                                                data-parsley-maxdate="{{ date('m/d/Y') }}">
                                                            @error('birthdate')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('birthdate') }}</li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-person_country"
                                                            class="col-4 col-xl-3 col-form-label">country</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select country @error('person_country') parsley-error @enderror"
                                                                name="person_country" id="search-contact-person_country" data-parsley-length="[2, 2]">
                                                                <option value="">no choice</option>
                                                                <option value="">Select a country</option>
                                                            </select>
                                                            @error('person_country')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('person_country') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-last_name"
                                                            class="col-4 col-xl-3 col-form-label">Last
                                                            Name</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('last_name') parsley-error @enderror"
                                                                name="last_name" id="search-contact-last_name"
                                                                placeholder="Last Name" data-parsley-minlength="2">
                                                            @error('last_name')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('last_name') }}</li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-profile"
                                                            class="col-4 col-xl-3 col-form-label">profile</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('profile') parsley-error @enderror"
                                                                name="profile" id="search-contact-profile"
                                                                data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                                <option value="">no choice</option>
                                                                <option value="1">Engineer</option>
                                                                <option value="2">Designer</option>
                                                                <option value="3">Businessman</option>
                                                            </select>
                                                            @error('profile')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('profile') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-gender"
                                                            class="col-4 col-xl-3 col-form-label">gender</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('gender') parsley-error @enderror"
                                                                name="gender" id="search-contact-gender"
                                                                data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                                <option value="">no choice</option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                            </select>
                                                            @error('gender')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('gender') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-person_language"
                                                            class="col-4 col-xl-3 col-form-label">language</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('person_language') parsley-error @enderror"
                                                                name="person_language" id="search-contact-person_language" data-parsley-length="[2, 2]">
                                                                <option value="">no choice</option>
                                                                <option value="ar">Arabic - العربية</option>
                                                                <option value="en">English</option>
                                                                <option value="fr">French - français</option>
                                                                <option value="es">Spanish - español</option>
                                                            </select>
                                                            @error('person_language')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('person_language') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end col -->
                                            </div> <!-- end row -->
                                        </div>

                                        <div class="tab-pane" id="search-companie-contact">
                                            <div class="row">
                                                <h3 class="mt-0 text-muted text-center">Companies Contact</h3>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-companies_class"
                                                            class="col-4 col-xl-3 col-form-label">Class</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('companies_class') parsley-error @enderror"
                                                                name="companies_class" id="search-contact-companies_class"
                                                                data-parsley-type="integer" data-parsley-length="[1, 1]">
                                                                <option value="">no choice</option>
                                                                <option value="1">One Person Companies</option>
                                                                <option value="2">Private Companies</option>
                                                                <option value="3">Public Companies</option>
                                                                <option value="4">Holding and Subsidiary Companies</option>
                                                                <option value="5">Associate Companies</option>
                                                            </select>
                                                            @error('companies_class')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('companies_class') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-name"
                                                            class="col-4 col-xl-3 col-form-label">Name</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('name') parsley-error @enderror"
                                                                name="name" placeholder="Name" id="search-contact-name"
                                                                data-parsley-minlength="2">
                                                            @error('name')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">{{ $errors->first('name') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-registered_number"
                                                            class="col-4 col-xl-3 col-form-label">Registered
                                                            number</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('registered_number') parsley-error @enderror"
                                                                name="registered_number"
                                                                id="search-contact-registered_number"
                                                                placeholder="Registered number"
                                                                data-parsley-maxlength="128">
                                                            @error('registered_number')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('registered_number') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-activity"
                                                            class="col-4 col-xl-3 col-form-label">Activity</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('activity') parsley-error @enderror"
                                                                name="activity" id="search-contact-activity"
                                                                placeholder="Identifier of activity"
                                                                data-parsley-type="integer" data-parsley-maxlength="10">
                                                            @error('activity')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('activity') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-companies_country"
                                                            class="col-4 col-xl-3 col-form-label">country</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select country @error('companies_country') parsley-error @enderror"
                                                                name="companies_country"
                                                                id="search-contact-companies_country" data-parsley-length="[2, 2]">
                                                                <option value="">no choice</option>
                                                            </select>
                                                            @error('companies_country')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('companies_country') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-companies_language"
                                                            class="col-4 col-xl-3 col-form-label">language</label>
                                                        <div class="col-8 col-xl-9">
                                                            <select
                                                                class="form-select @error('companies_language') parsley-error @enderror"
                                                                name="companies_language"
                                                                id="search-contact-companies_language"
                                                                 data-parsley-length="[2, 2]">
                                                                <option value="">no choice</option>
                                                                <option value="ar">Arabic - العربية</option>
                                                                <option value="en">English</option>
                                                                <option value="fr">French - français</option>
                                                                <option value="es">Spanish - español</option>
                                                            </select>
                                                            @error('companies_language')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('companies_language') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end col -->
                                            </div> <!-- end row -->
                                        </div>

                                        <div class="tab-pane" id="search-contact-data">
                                            <div class="row">
                                                <h3 class="mt-0 text-muted text-center">Contact Data</h3>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-phone"
                                                            class="col-4 col-xl-3 col-form-label">Phone Number</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('phone') parsley-error @enderror"
                                                                name="phone" id="search-contact-phone"
                                                                placeholder="Identifier of phone"
                                                                data-parsley-type="integer" data-parsley-maxlength="10">
                                                            @error('phone')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('phone') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-email"
                                                            class="col-4 col-xl-3 col-form-label">Email Address</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('email') parsley-error @enderror"
                                                                name="email" placeholder="Email Address"
                                                                id="search-contact-email" data-parsley-minlength="2"
                                                                data-parsley-type="email">
                                                            @error('email')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('email') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-facebook"
                                                            class="col-4 col-xl-3 col-form-label">Facebook</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('facebook') parsley-error @enderror"
                                                                name="facebook" placeholder="Facebook account name"
                                                                id="search-contact-facebook" data-parsley-minlength="2">
                                                            @error('facebook')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('facebook') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-skype"
                                                            class="col-4 col-xl-3 col-form-label">Skype</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('skype') parsley-error @enderror"
                                                                name="skype" placeholder="Skype account name"
                                                                id="search-contact-skype" data-parsley-minlength="2">
                                                            @error('skype')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('skype') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-viber"
                                                            class="col-4 col-xl-3 col-form-label">Viber</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('viber') parsley-error @enderror"
                                                                name="viber" placeholder="viber account name"
                                                                id="search-contact-viber" data-parsley-minlength="2">
                                                            @error('viber')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('viber') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row mb-3">
                                                        <label for="search-contact-fax"
                                                            class="col-4 col-xl-3 col-form-label">Fax Number</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('fax') parsley-error @enderror"
                                                                name="fax" id="search-contact-fax" placeholder="Fax Number"
                                                                data-parsley-type="integer" data-parsley-maxlength="10">
                                                            @error('fax')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('fax') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-mobile"
                                                            class="col-4 col-xl-3 col-form-label">Mobile</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('mobile') parsley-error @enderror"
                                                                name="mobile" id="search-contact-mobile"
                                                                placeholder="Mobile" data-parsley-type="integer"
                                                                data-parsley-maxlength="10">
                                                            @error('mobile')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('mobile') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-instagram"
                                                            class="col-4 col-xl-3 col-form-label">Instagram</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('instagram') parsley-error @enderror"
                                                                name="instagram" placeholder="Instagram account name"
                                                                id="search-contact-instagram" data-parsley-minlength="2">
                                                            @error('instagram')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('instagram') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-whatsapp"
                                                            class="col-4 col-xl-3 col-form-label">WhatsApp</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="number"
                                                                class="form-control @error('whatsapp') parsley-error @enderror"
                                                                name="whatsapp" placeholder="WhatsApp Phone Number"
                                                                id="search-contact-whatsapp" data-parsley-minlength="2">
                                                            @error('whatsapp')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('whatsapp') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="search-contact-messenger"
                                                            class="col-4 col-xl-3 col-form-label">Messenger</label>
                                                        <div class="col-8 col-xl-9">
                                                            <input type="text"
                                                                class="form-control @error('messenger') parsley-error @enderror"
                                                                name="messenger" placeholder="messenger account name"
                                                                id="search-contact-messenger" data-parsley-minlength="2">
                                                            @error('messenger')
                                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                                    <li class="parsley-required">
                                                                        {{ $errors->first('messenger') }}
                                                                    </li>
                                                                </ul>
                                                            @else
                                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end col -->
                                            </div> <!-- end row -->
                                        </div>

                                        <ul class="list-inline mb-0 wizard">
                                            <li class="list-inline-item">
                                                <div class="alert alert-warning d-none fade show">
                                                    <h4 class="mt-0 text-warning">Oh snap!</h4>
                                                    <p class="mb-0">This form seems to be invalid :(</p>
                                                    <p class="mb-0">Go back and check your data</p>
                                                </div>

                                                <div class="alert alert-info d-none fade show">
                                                    <h4 class="mt-0 text-info">Yay!</h4>
                                                    <p class="mb-0">Everything seems to be ok :)</p>
                                                </div>
                                            </li>
                                            <li class="list-inline-item float-end">
                                                <button type="submit"
                                                    class="btn btn-info waves-effect waves-light">Search</button>
                                            </li>
                                        </ul>

                                    </div> <!-- tab-content -->
                                </div> <!-- end #contactwizard-->
                            </form>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->

            <div id="contacts-result">
            </div>
        @endsection

        @section('js')
            <!-- Vendor js -->
            <script src="/js/vendor.min.js"></script>

            <!-- Plugin js-->
            <script src="/libs/parsleyjs/parsley.min.js"></script>

            <!-- Sweet Alerts js -->
            <script src="/libs/sweetalert2/sweetalert2.all.min.js"></script>

            <!-- Plugins js -->
            <script src="/libs/dropzone/min/dropzone.min.js"></script>
            <script src="/libs/dropify/js/dropify.min.js"></script>

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

            <!-- Plugins js-->
            <script src="/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

            <!-- Init js-->
            <!--<script src="/js/pages/form-fileuploads.init.js"></script>-->

            <!-- Footable js -->
            <script src="/libs/footable/footable.all.min.js"></script>

            <!-- custom js files -->
            <script src="/js/form-validation-laravel.js"></script>
            <script src="/js/contacts/search.js"></script>
            <script src="/js/contacts/country-select.js"></script>
            <script src="/js/contacts/custom-parsley.js"></script>
            <script>
                url_photo = '{{ URL::asset('/storage/images/logo/') }}';
                url_jsfile = '{{ URL::asset('/js/contacts/') }}';
                var search_contact_errors = null
                var form_edit_errors = null
            </script>

            <!-- App js-->
            <script src="/js/app.min.js"></script>
        @endsection
