<table id="datatable-communications" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Contact</th>
            <th>User</th>
            <th>Class</th>
            <th>Channel</th>
            <th>Start Date</th>
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
        </tr>
    </tfoot>
</table>
