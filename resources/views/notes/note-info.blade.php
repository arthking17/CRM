<div class="card">
    <div class="card-body" id="card-note">
        <h4 class="mb-1 mt-1 text-uppercase bg-light p-1"><i class="mdi mdi-note-text-outline me-1"></i>Note</h4>
        <br>
        @if ($notes->count() > 0)
            <p class="mb-3">Element :
                {{ getElementName($note->element) }}
            </p>
            <p class="mb-3">Element Id :
                {{ $note->element_id }}
            </p>
            @if ($note->visibility === 1)
                <div class="card border-success border mb-3">
                    <div class="card-body" id="card-note-body">
                        @isset($note)
                            <h4 class="card-title text-success">{{ getNoteClassName($note->class) }}</h4>
                            <p class="card-text">
                                {{ $note->content }}
                            </p>
                        @endisset
                    </div>
                </div>
            @elseif($note->visibility === 0)
                <div class="card border-danger border mb-3">
                    <div class="card-body" id="card-note-body">
                        @isset($note)
                            <h4 class="card-title @if ($note->visibility === 1) text-success @elseif($note->visibility === 0) text-danger @endif">{{ getNoteClassName($note->class) }}</h4>
                            <p class="card-text">
                                {{ $note->content }}
                            </p>
                        @endisset
                    </div>
                </div>
            @endif
            <a id="btn-edit" class="btn- btn-xs btn-success" href="javascript: void(0);" data-bs-toggle="modal"
                data-bs-target="#edit-modal" onclick="editNote({{ $note->id }});">Edit</a>
            <a id="btn-delete" class="btn- btn-xs btn-danger" href="javascript: void(0);"
                onclick="deleteNote({{ $note->id }});">Delete</a>
        @else
            <p class="text-center">empty</p>
        @endif
    </div>
</div>
