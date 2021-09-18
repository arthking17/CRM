<table id="datatable-communications" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Contact</th>
            <th>User</th>
            <th>Class</th>
            <th>Channel</th>
            <th>Start Date</th>
            <th style="width: 90px;">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($communications as $communication)
            <tr id="communicationid{{ $communication->id }}" onclick="viewCommunication({{ $communication->id }})">
                <td>{{ $communication->id }}</td>
                <td>{{ $communication->contact_id }}</td>
                <td>
                    @if ($communication->user->count() > 0)
                        {{ $communication->user[0]->username }}@else Empty @endif
                </td>
                <td>
                    @if ($communication->class === 1)
                        <span class="badge bg-blue">Call</span>
                    @elseif($communication->class === 2)
                        <span class="badge bg-info text-light">Email</span>
                    @elseif($communication->class === 3)
                        <span class="badge bg-warning text-light">Sms</span>
                    @endif
                </td>
                <td>{{ $communication->channel }}</td>
                <td>{{ $communication->start_date }}</td>
                <td>
                    @if ($communication->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info"
                            data-bs-toggle="modal" data-bs-target="#edit-communication-modal"
                            id="edit-{{ $communication->id }}"
                            onclick="editCommunication({{ $communication->id }});"
                            data-toggle="modal"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                    @endif
                    @if ($communication->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i
                                class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" id="delete-{{ $communication->id }}"
                            onclick="deleteCommunication({{ $communication->id }});"
                            class="btn- btn-xs btn-danger"> <i class="mdi mdi-delete-circle"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th class="select">Contact</th>
            <th class="select">User</th>
            <th class="select with-span">Class</th>
            <th>Channel</th>
            <th>Start Date</th>
            <th class="disabled" style="width: 90px;">Action</th>
        </tr>
    </tfoot>
</table>
