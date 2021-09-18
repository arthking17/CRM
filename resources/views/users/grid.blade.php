@if ($users->count() > 0)
    @php
        $j = 0;
    @endphp
    @foreach ($users as $user)
        @if ($j % 8 == 0)
            <div class="row @if ($j / 8 + 1 != 1) d-none @endif" id="page{{ $j / 8 + 1 }}">
        @endif
        <div id="grid-view-userid{{ $user->id }}" class="col-md-6 col-xl-3" onclick="viewUser({{ $user->id }});">
            <div class="card product-box" style="height: 300px">
                <div class="product-action">
                    <a href="javascript: void(0);" class="btn btn-info btn-xs waves-effect waves-light" title="New Email"><i
                            class="mdi mdi-email-edit-outline"></i></a>
                    <a href="javascript: void(0);" class="btn btn-info btn-xs waves-effect waves-light" title="New Sms"><i
                            class="mdi mdi-message-text-outline"></i></a>
                    <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light" title="Call"><i
                            class="fe-phone-call"></i></a>
                    @if ($user->status == 0)
                        <a id="button-edit-{{ $user->id }}" class="btn btn-primary btn-xs waves-effect waves-light"
                            href="javascript: void(0);" data-bs-toggle="" data-bs-target="#edit-modal" title="Edit"
                            onclick="#"><i class="mdi mdi-square-edit-outline"></i></a>
                    @else
                        <a id="button-edit-{{ $user->id }}" class="btn btn-primary btn-xs waves-effect waves-light"
                            href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal" title="Edit"
                            onclick="editUser({{ $user->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                    @endif
                    @if ($user->status == 0)
                        <a id="button-delete-{{ $user->id }}" class="btn btn-danger btn-xs waves-effect waves-light"
                            href="javascript: void(0);" title="Delete"
                            onclick="#"><i class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a id="button-delete-{{ $user->id }}" class="btn btn-danger btn-xs waves-effect waves-light"
                            href="javascript: void(0);" title="Delete"
                            onclick="deleteUser({{ $user->id }});"><i class="mdi mdi-delete-circle"></i></a>
                    @endif
                </div>
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
