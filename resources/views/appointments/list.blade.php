<table id="datatable-appointments" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Contact</th>
            <th>User</th>
            <th>Class</th>
            <th>Subject</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($appointments as $appointment)
            <tr id="appointmentid{{ $appointment->id }}">
                <td>{{ $appointment->id }}</td>
                <td><a href="{{ route('contacts.view', $appointment->contact_id) }}">
                        @if ($appointment->contact[0]->class === 1)
                            (Person)
                            {{ $contacts_persons->where('id', $appointment->contact_id)->first()->first_name . ' ' . $contacts_persons->where('id', $appointment->contact_id)->first()->last_name }}
                        @elseif($appointment->contact[0]->class === 2)
                            (Companie) {{ $contacts_companies->where('id', $appointment->contact_id)->first()->name }}
                        @endif
                    </a>
                </td>
                <td><a href="{{ route('users.view', $appointment->user_id) }}">
                        @if ($appointment->user->count() > 0)
                            {{ $appointment->user[0]->username }}@else Empty @endif
                    </a>
                </td>
                <td>
                    @if ($appointment->class === 1)
                        <span class="badge bg-success">Simple</span>
                    @elseif($appointment->class === 2)
                        <span class="badge bg-danger text-light">Urgent</span>
                    @endif
                </td>
                <td data-bind="text: text()" class="text-truncate" style="max-width: 200px"
                    title="{{ $appointment->subject }}">{{ $appointment->subject }}</td>
                <td>{{ $appointment->start_date }}</td>
                <td>{{ $appointment->end_date }}</td>
                <td>
                    @if ($appointment->status === 1)
                        <span class="badge label-table bg-success">Active</span>
                    @elseif($appointment->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($appointment->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i
                                class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-info" data-bs-toggle="modal"
                            data-bs-target="#edit-appointment-modal"
                            onclick="editAppointment({{ $appointment->id }});" data-toggle="modal"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" onclick="deleteAppointment({{ $appointment->id }});"
                            class="btn- btn-xs btn-danger">
                            <i class="mdi mdi-delete-circle"></i></a>
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
            <th>Subject</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="select with-span">Status</th>
            <th class="disabled"></th>
        </tr>
    </tfoot>
</table>
