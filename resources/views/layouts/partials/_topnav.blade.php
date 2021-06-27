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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-accounts" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe-user me-1"></i> Accounts <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            <a href="{{ route("create") }}" class="dropdown-item">Create</a>
                            <a href="{{ route("accounts") }}" class="dropdown-item">List</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="topnav-dashboard" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe-phone me-1"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="topnav-dashboard" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe-airplay me-1"></i> Leads
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="topnav-dashboard" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe-airplay me-1"></i> Customers
                        </a>
                    </li>
                </ul> <!-- end navbar-->
            </div> <!-- end .collapsed-->
        </nav>
    </div> <!-- end container-fluid -->
</div>
