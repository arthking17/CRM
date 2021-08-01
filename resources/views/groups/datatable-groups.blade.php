<table id="datatable-groups" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="select-filter">Account</th>
            <th class="text-filter">Name</th>
            <th class="disabled">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groups as $group)
            <tr id="groupid{{ $group->id }}" onclick="viewGroup({{ $group->id }});">
                <td>{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->account[0]->name }}</td>
                <td>
                    <div class="text-sm-end">
                        <a href="javascript:void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#edit-modal" onclick="editGroup({{ $group->id }});"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="action-icon" onclick="deleteGroup({{ $group->id }});">
                            <i class="mdi mdi-delete"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="">Id</th>
            <th class="select account">Account</th>
            <th class="">Name</th>
            <th class="disabled">Action</th>
        </tr>
    </tfoot>
</table>
