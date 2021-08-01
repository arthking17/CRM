<table id="datatable-notes" class="table table-center dt-responsive nowrap table-hover w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="select-filter">Class</th>
            <th class="select-filter">Visibility</th>
            <th class="select-filter">Element</th>
            <th class="text-filter">Element Id</th>
            <th class="text-filter">Content</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($notes as $note)
            <tr id="noteid{{ $note->id }}" onclick="viewNote({{ $note->id }});">
                <td>{{ $note->id }}</td>
                <td>{{ getNoteClassName($note->class) }}</td>
                <td>
                    @if ($note->visibility === 1) <span
                            class="badge bg-success">Visible for all</span>
                    @elseif ($note->visibility === 0)
                        <span class="badge label-table bg-danger">Visible only for
                            admin</span>
                    @endif
                </td>
                <td>{{ getElementName($note->element) }}</td>
                <td>{{ $note->element_id }}</td>
                <td>{{ $note->content }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th class="select account">Class</th>
            <th class="select">Visibility</th>
            <th class="select account">Element</th>
            <th>Element Id</th>
            <th>Content</th>
        </tr>
    </tfoot>
</table>
