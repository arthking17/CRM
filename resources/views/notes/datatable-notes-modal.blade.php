<table id="datatable-notes-modal" class="table table-center table-striped dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th class="select-filter">Class</th>
            <th class="select-filter">Visibility</th>
            <th class="select-filter">Element</th>
            <th class="text-filter">Element Id</th>
            <th class="text-filter">Content</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($notes as $note)
            <tr id="noteid{{ $note->id }}">
                <td>{{ $note->id }}</td>
                <td>{{ getNoteClassName($note->class) }}</td>
                <td>
                    @if ($note->visibility === 1) <span class="badge bg-success">Visible
                            for all</span>
                    @elseif ($note->visibility === 0)
                        <span class="badge label-table bg-danger">Visible only for
                            admin</span>
                    @endif
                </td>
                <td>{{ getElementName($note->element) }}</td>
                <td>{{ $note->element_id }}</td>
                <td id="note-content" data-bind="text: text()" class="text-truncate" style="max-width: 200px"
                    title="{{ $note->content }}">{{ $note->content }}</td>
                <td>
                    <a href="javascript:void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#edit-note-2-modal" onclick="editNote2({{ $note->id }});" data-toggle="modal"> <i
                            class="mdi mdi-square-edit-outline"></i></a>
                    <a href="javascript:void(0);" onclick="deleteNote2({{ $note->id }});"
                        class="btn- btn-xs btn-danger">
                        <i class="mdi mdi-delete-circle"></i></a>
                </td>
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
            <th class="disabled"></th>
        </tr>
    </tfoot>
</table>
