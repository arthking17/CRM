<table id="datatable-contacts" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="select-filter">Account</th>
            <th class="select-filter">Class</th>
            <th class="select-filter">Source</th>
            <th class="text-filter">Creation Date</th>
            <th class="select-filter">Status</th>
            <th class="text-filter">Source Id</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($contacts as $contact)
            <tr id="contactid{{ $contact->id }}"
                onclick="viewContact({{ $contact->id }}, {{ $contact->class }});">
                <td>{{ $contact->id }}</td>
                <td>{{ $accounts->find($contact->account_id)->name }}</td>
                <td>
                    @if ($contact->class === 2)
                        <span class="badge bg-success">Company</span>
                    @elseif($contact->class === 1)
                        <span class="badge bg-blue text-light">Person</span>
                    @endif
                </td>
                <td>
                    @if ($contact->source === 1)
                        <span class="badge label-table bg-danger">Telephone prospecting</span>
                    @elseif($contact->source === 2)
                        <span class="badge bg-warning">Landing pages</span>
                    @elseif($contact->source === 3)
                        <span class="badge bg-success">Affiliation</span>
                    @elseif($contact->source === 4)
                        <span class="badge bg-blue text-light">Database purchased</span>
                    @endif
                </td>
                <td>{{ $contact->creation_date }}</td>
                <td>
                    @if ($contact->status === 1)
                        <span class="badge label-table bg-success">Lead</span>
                    @elseif($contact->status === 2)
                        <span class="badge bg-blue text-light">Customer</span>
                    @elseif($contact->status === 3)
                        <span class="badge bg-danger">Not interested</span>
                    @endif
                </td>
                <td>{{ $contact->source_id }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="">Id</th>
            <th class="select account">Account</th>
            <th class="select">Class</th>
            <th class="select">Source</th>
            <th class="">Creation Date</th>
            <th class="select">Status</th>
            <th class="">Source Id</th>
        </tr>
    </tfoot>
</table>
