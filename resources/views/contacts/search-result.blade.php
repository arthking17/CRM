<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Search Results</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="card" id="contact_data-info-card">
            @include('contacts.contact_data')
        </div>
        <div class="card" id="notes-info-card">
            @include('notes.notes-info-card')
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">

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
            </div>
        </div> <!-- end card -->
    </div> <!-- end col -->
    @if ($contacts->count() > 0)
        <div class="col-lg-3 @if ($contact->class !== 1) d-none @endif" id="contacts_person-info-card">
            @include('contacts.contacts_person-info')
        </div>
        <div class="col-lg-3 @if ($contact->class !== 2) d-none @endif" id="contacts_companie-info-card">
            @include('contacts.contacts_companie-info')
        </div>
    @endif
</div>
<!-- end row -->
@include('contacts.create')
@include('contacts.data.create')
@if ($contacts->count() > 0)
    @include('contacts.edit')
    @include('users.add_note')
    <div id="notes-div">
        @include('users.notes')
    </div>
    @include('contacts.data.edit')
@endif
