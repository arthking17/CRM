<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">

                <div class="row justify-content-between">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" id="topnav-dashboard" role="button">
                                <i class="fe-airplay me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('accounts') }}" id="topnav-accounts"
                                role="button">
                                <i class="fe-user me-1"></i> Accounts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users') }}" id="topnav-users" role="button">
                                <i class="fe-user me-1"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacts') }}" id="topnav-dashboard"
                                role="button">
                                <i class="fe-phone me-1"></i> Contacts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointments') }}" id="topnav-dashboard"
                                role="button">
                                <i class="fe-calendar me-1"></i> Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('communications') }}" id="topnav-dashboard"
                                role="button">
                                <i class="mdi mdi-cellphone-message me-1"></i> Communication
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notes') }}" id="topnav-dashboard" role="button">
                                <i class="mdi mdi-evernote"></i> Notes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chat') }}" id="topnav-dashboard" role="button">
                                <i class="mdi mdi-wechat"></i> Chat
                            </a>
                        </li>
                    </ul> <!-- end navbar-->
                </div>
                @php
                    $list_add = ['user', 'account', 'contact', 'appointment', 'communication', 'note', 'sip_account'];
                    $entity = substr($title ?? null, 0, -1);
                @endphp
                <div class="d-flex flex-row-reverse">
                    <button id="global-btn-add" type="button" class="btn btn-primary @if (!in_array(strtolower($entity), $list_add) && strtolower($title ?? null) != 'settings') d-none @endif"
                        data-bs-toggle="modal" data-bs-target="#create-{{ strtolower($entity) }}-modal"><i
                            class="mdi mdi-plus-circle me-1"></i> Add {{ $entity }} </button>
                    <div id="div-global-btn-add"></div>
                </div>
            </div> <!-- end .collapsed-->
        </nav>
    </div> <!-- end container-fluid -->
</div>
