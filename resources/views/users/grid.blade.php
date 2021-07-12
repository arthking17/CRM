<div class="row d-none" id="view-grid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <form class="d-flex flex-wrap align-items-center">
                                <label for="inputPassword2" class="visually-hidden">Search</label>
                                <div class="me-3">
                                    <input type="search" class="form-control my-1 my-lg-0" id="view-grid-search"
                                        placeholder="Search...">
                                </div>
                                <label for="status-select" class="me-2">Sort By</label>
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
            </div> <!-- end card -->
        </div> <!-- end col-->
    </div>
    @for ($i = 0; $i < 8; $i++)
        <div class="col-md-6 col-xl-3" onclick="viewUser({{ $users[$i]->id }});">
            <div class="card product-box">
                <div class="card-body">

                    <div class="pt-2 pb-2 bg-light">
                        <img src="{{ asset('storage/images/users/' . $users[$i]->photo) }}" alt="user-photo"
                            class="img-fluid rounded-circle avatar-xl" />
                    </div>

                    <div class="product-info">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="font-16 mt-0 sp-line-1">{{ $users[$i]->username }} </h5>
                                <h5 class="m-0">
                                    @if ($users[$i]->role === 1) <span
                                            class="badge label-table bg-danger">Admin</span>
                                    @elseif($users[$i]->role === 2)
                                        <span class="badge bg-success">User</span>
                                    @elseif($users[$i]->role === 3)
                                        <span class="badge bg-blue text-light">Visitor</span>
                                    @endif
                                    @if ($users[$i]->status === 1) <span
                                        class="badge bg-success">Active</span> @elseif ($users[$i]->status === 0)
                                        <span class="badge label-table bg-danger">Disabled</span>
                                    @endif
                                </h5>
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- end product info-->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    @endfor
    <div class="row">
        <div class="col-12">
            <ul class="pagination pagination-rounded justify-content-end mb-3">
                <li class="paginate_button page-item previous" id="view-grid-paginate_button">
                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                </li>
                @for ($i = 8; $i < $users->count(); $i += 8)
                    <li class="page-item view-grid-page-item @if ($i / 8==1) active @endif" id="page{{ $i / 8 }}"><a class="page-link"
                            href="javascript: void(0);">{{ $i / 8 }}</a></li>
                @endfor
                <li class="page-item">
                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                        <span aria-hidden="true">»</span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </li>
            </ul>
        </div> <!-- end col-->
    </div>
</div>