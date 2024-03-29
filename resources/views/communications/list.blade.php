<table id="datatable-communications" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Contact</th>
            <th>User</th>
            <th>Class</th>
            <th>Channel</th>
            <th>Start Date</th>
            <th>Qualification</th>
            <th>Status</th>
            <th style="width: 90px;">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($communications as $communication)
            <tr id="communicationid{{ $communication->id }}">
                <td>{{ $communication->id }}</td>
                <td><a href="{{ route('contacts.view', $communication->contact_id) }}">
                        @if ($communication->contact[0]->class === 1)
                            (Person)
                            {{ $contacts_persons->where('id', $communication->contact_id)->first()->first_name . ' ' . $contacts_persons->where('id', $communication->contact_id)->first()->last_name }}
                        @elseif($communication->contact[0]->class === 2)
                            (Companie)
                            {{ $contacts_companies->where('id', $communication->contact_id)->first()->name }}
                        @endif
                    </a>
                </td>
                <td><a href="{{ route('users.view', $communication->user_id) }}">
                        @if ($communication->user->count() > 0)
                            {{ $communication->user[0]->username }}@else Empty @endif
                    </a>
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
                    @if ($communication->qualification === 1)
                        <span class="badge label-table bg-success">completed with success</span>
                    @elseif($communication->qualification === 2)
                        <span class="badge bg-info text-light">interruption during call</span>
                    @endif
                </td>
                <td>
                    @if ($communication->status === 1) <span
                            class="badge label-table bg-success">Active</span>
                    @elseif($communication->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($communication->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i
                                class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info" data-bs-toggle="modal"
                            data-bs-target="#edit-communication-modal" id="edit-{{ $communication->id }}"
                            onclick="editCommunication({{ $communication->id }});"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" id="delete-{{ $communication->id }}"
                            onclick="deleteCommunication({{ $communication->id }});" class="btn- btn-xs btn-danger">
                            <i class="mdi mdi-delete-circle"></i></a>
                    @endif
                    <a href="javascript:void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle=""
                        data-bs-target="#notes-modal"
                        onclick="viewDatatableNotes({{ $communication->id }}, 'communications');"> <i
                            class="mdi mdi-notebook-outline"></i></a>
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
            <th class="select with-span">Qualification</th>
            <th class="select with-span">Status</th>
            <th class="disabled" style="width: 90px;">Action</th>
        </tr>
    </tfoot>
</table>
