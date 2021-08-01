<table id="datatable-users" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="text-filter">Username</th>
            <th class="select-filter">role</th>
            <th>photo</th>
            <th class="select-filter">account</th>
            <th class="select-filter">status</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr id="userid{{ $user->id }}" onclick="viewUser({{ $user->id }});">
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    @if ($user->role === 1) <span
                            class="badge label-table bg-danger">Admin</span>
                    @elseif($user->role === 2)
                        <span class="badge bg-success">User</span>
                    @elseif($user->role === 3)
                        <span class="badge bg-blue text-light">Visitor</span>
                    @endif
                </td>
                <td><img class="img-fluid avatar-sm rounded"
                        src="{{ asset('storage/images/users/' . $user->photo) }}" /></td>
                <td>{{ $user->account[0]->name }}</td>
                <td>
                    @if ($user->status === 1) <span
                        class="badge bg-success">Active</span> @elseif ($user->status
                        === 0)
                        <span class="badge label-table bg-danger">Disabled</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>id</th>
            <th>username</th>
            <th class="select role">role</th>
            <th class="disabled">photo</th>
            <th class="select account">account</th>
            <th class="select status">status</th>
        </tr>
    </tfoot>
</table>