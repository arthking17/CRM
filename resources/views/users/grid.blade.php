
@if ($users->count() > 0)
    @php
        $j = 0;
    @endphp
    @foreach ($users as $user)
        @if ($j % 8 == 0)
            <div class="row @if ($j / 8 + 1 !=1) d-none @endif"
                id="page{{ $j / 8 + 1 }}">
        @endif
        <div id="grid-view-userid{{ $user->id }}" class="col-md-6 col-xl-3" onclick="viewUser({{ $user->id }});">
            <div class="card product-box" style="height: 300px">
                <div class="card-body">

                    <div class="pt-2 pb-2 bg-light text-center">
                        <img src="{{ asset('storage/images/users/' . $user->photo) }}" alt="user-photo"
                            class="img-fluid rounded-circle avatar-xl" />
                    </div>

                    <div class="product-info text-center">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="font-16 mt-0 sp-line-1">{{ $user->username }} </h5>
                                <p class="text-muted"><i class="mdi mdi-office-building"></i>
                                    {{ $user->account[0]->name }}</p>
                                <h5 class="m-0">
                                    @if ($user->role === 1) <span
                                            class="badge label-table bg-danger">Admin</span>
                                    @elseif($user->role === 2)
                                        <span class="badge bg-success">User</span>
                                    @elseif($user->role === 3)
                                        <span class="badge bg-blue text-light">Visitor</span>
                                    @endif
                                    @if ($user->status === 1) <span
                                        class="badge bg-success">Active</span> @elseif($user->status === 0)
                                        <span class="badge label-table bg-danger">Disabled</span>
                                    @endif
                                </h5>
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- end product info-->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
        @php
            $j++;
        @endphp
        @if ($j % 8 == 0 or $j > $users->count() - 1)
            </div>
        @endif
    @endforeach
@endif
<input type="hidden" value="1" id="activepage">
<input type="hidden" value="{{ $users->count() / 8 }}" id="numberofpage">
<div class="row">
    <div class="col-12">
        <ul class="pagination pagination-rounded justify-content-end mb-3">
            <li class="paginate_button page-item previous">
                <a class="page-link" href="javascript: void(0);" onclick="viewGridPagePreviousPage();" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                    <span class="visually-hidden">Previous</span>
                </a>
            </li>
            @for ($i = 0; $i < $users->count(); $i += 8)
                <li class="page-item @if ($i / 8 < 1) active @endif" id="pageno{{ $i / 8 + 1 }}"><a class="page-link"
                        href="javascript: void(0);" onclick="viewGridPageItem({{ $i / 8 + 1 }});">{{ $i / 8 + 1 }}</a></li>
            @endfor
            <li class="page-item">
                <a class="page-link" href="javascript: void(0);" onclick="viewGridPageNextPage({{ $users->count() / 8 }});" aria-label="Next">
                    <span aria-hidden="true">»</span>
                    <span class="visually-hidden">Next</span>
                </a>
            </li>
        </ul>
    </div> <!-- end col-->
</div>