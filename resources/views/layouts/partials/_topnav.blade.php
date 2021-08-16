<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" id="topnav-dashboard" role="button">
                            <i class="fe-airplay me-1"></i> Dashboards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('accounts') }}" id="topnav-accounts" role="button">
                            <i class="fe-user me-1"></i> Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users') }}" id="topnav-users" role="button">
                            <i class="fe-user me-1"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.logs') }}" id="topnav-dashboard" role="button">
                            <i class="fe-activity me-1"></i> Logs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contacts') }}" id="topnav-dashboard" role="button">
                            <i class="fe-phone me-1"></i> Contacts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('appointments') }}" id="topnav-dashboard" role="button">
                            <i class="fe-calendar me-1"></i> Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('communications') }}" id="topnav-dashboard" role="button">
                            <i class="mdi mdi-cellphone-message me-1"></i> Communication
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.groups') }}" id="topnav-dashboard" role="button">
                            <i class="fe-layers me-1"></i> Groups
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notes') }}" id="topnav-dashboard" role="button">
                            <i class="mdi mdi-evernote"></i> Notes
                        </a>
                    </li>
                </ul> <!-- end navbar-->
            </div> <!-- end .collapsed-->
        </nav>
    </div> <!-- end container-fluid -->
</div>
