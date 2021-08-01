<div class="card">
    <div class="card-body" id="card-note">
        <h4 class="mb-1 mt-1 text-uppercase bg-light p-1"><i class="mdi mdi-note-text-outline me-1"></i>Note</h4>
        @if (isset($contact))
            @php $element = $contact @endphp
        @elseif(isset($user))
            @php $element = $user @endphp
        @endif
        @isset($element)
            <a href="javascript: void(0);" class="btn- btn-xs btn-success"
                onclick="viewFomAddNote({{ $element->id }}, @if (isset($contact)) 5 @elseif(isset($user)) 16 @endif)" data-bs-toggle="modal"
                data-bs-target="#add_note-modal"><i class="mdi mdi-plus-circle me-1"></i>Add note</a>
            <a href="javascript: void(0);" class="btn- btn-xs" data-bs-toggle="" data-bs-target="#notes-modal"
                onclick="viewDatatableNotes({{ $element->id }});"><i class="mdi mdi-plus-circle me-1"></i>more details</a>
        @endisset
        <div class="card mb-3" data-simplebar style="max-height: 400px;">
            @isset($element)
                @foreach ($notes as $note)
                    @if ($note->visibility === 1)
                        <div class="card border-success border mb-3">
                            <div class="card-body" id="card-note-body">
                                @isset($note)
                                    <div class="card product-box" id="{{ $note->id }}">
                                        <div class="product-action">
                                            <a href="javascript: void(0);"
                                                class="btn btn-success btn-xs waves-effect waves-light" data-bs-toggle="modal"
                                                data-bs-target="#edit-note-modal"
                                                onclick="viewFomEditNote({{ $note->id }});"><i
                                                    class="mdi mdi-pencil"></i></a>
                                            <a href="javascript: void(0);"
                                                class="btn btn-danger btn-xs waves-effect waves-light"
                                                onclick="deleteNote({{ $note->id }});"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="card-title text-success">{{ getNoteClassName($note->class) }}</h4>
                                        <p class="card-text">
                                            {{ $note->content }}
                                        </p>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    @elseif($note->visibility === 0)
                        <div class="card border-danger border mb-3">
                            <div class="card-body" id="card-note-body">
                                @isset($note)
                                    <div class="card product-box" id="{{ $note->id }}">
                                        <div class="product-action">
                                            <a href="javascript: void(0);"
                                                class="btn btn-success btn-xs waves-effect waves-light" data-bs-toggle="modal"
                                                data-bs-target="#edit-note-modal"
                                                onclick="viewFomEditNote({{ $note->id }});"><i
                                                    class="mdi mdi-pencil"></i></a>
                                            <a href="javascript: void(0);"
                                                class="btn btn-danger btn-xs waves-effect waves-light"
                                                onclick="deleteNote({{ $note->id }});"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="card-title @if ($note->visibility === 1) text-success @elseif($note->visibility === 0) text-danger @endif">{{ getNoteClassName($note->class) }}</h4>
                                        <p class="card-text">
                                            {{ $note->content }}
                                        </p>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    @endif
                @endforeach
            @endisset
        </div>
    </div>
</div>
