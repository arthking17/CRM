<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @isset($group)
                <div class="w-100" id="group-info1">
                    <h4 class="mt-0 mb-1">{{ $group->name }}</h4>
                    <p class="text-muted">{{ $group->class }}</p>
                    <p class="text-muted"><i class="mdi mdi-office-building"></i>
                        {{ $group->account[0]->name }}</p>
                    <p class="text-muted d-none"> {{ $group->id }}</p>

                    <a id="edit-{{ $group->id }}" class="btn- btn-xs btn-success" href="javascript: void(0);"
                        data-bs-toggle="modal" data-bs-target="#edit-modal"
                        onclick="editGroup({{ $group->id }});">Edit</a>
                    <a id="delete-{{ $group->id }}" class="btn- btn-xs btn-danger" href="javascript: void(0);"
                        onclick="deleteGroup({{ $group->id }});">Delete</a>
                </div>
            @endisset
        </div>

        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i>List of Users</h5>
        <div class="" id="group-info2" data-simplebar style="max-height: 400px;">
            @if(isset($group) and $users->count() > 0)
                    @foreach ($users->where('account_id', $group->account_id) as $user)
                        <img id="user-photo" class="d-flex me-3 rounded-circle avatar-lg"
                            src="{{ asset('storage/images/users/' . $user->photo) }}" alt="Generic placeholder image">
                        <div class="w-100" id="user-info1">
                            <h4 class="mt-0 mb-1">{{ $user->username }}</h4>
                            <p class="text-muted">{{ $user->login }}</p>
                        </div>
                    @endforeach
            @else
                <p class="text-center">empty</p>
            @endif
        </div>
        <a href="{{ route('users') }}" class="btn- btn-xs"><i class="mdi mdi-plus-circle me-1"></i>voir
            plus</a>
    </div>
</div> <!-- end card-->
