<div class="accordion custom-accordion" id="custom-accordion-notes-info">
    <div class="card mb-0">
        <div class="card-header" id="heading-notes-info">
            <h5 class="m-0 position-relative">
                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                    href="#collapse-notes-info" aria-expanded="true" aria-controls="collapse-notes-info">
                    <h4 class="mb-1 mt-1 text-uppercase p-1"><i class="mdi mdi-note-text-outline me-1"></i>Note <i
                            class="mdi mdi-chevron-down accordion-arrow"></i></h4>
                </a>
            </h5>
        </div>

        @if (isset($contact))
            @php $element = $contact @endphp
        @elseif(isset($user))
            @php $element = $user @endphp
        @endif

        <div id="collapse-notes-info" class="collapse show" aria-labelledby="headingFour"
            data-bs-parent="#custom-accordion-notes-info">
            <div class="card-body">
                @if(count($notes) == 0)
                <p class="text-center"> empty</p>
                @endif
                @isset($element)
                    @foreach ($notes as $note)
                        @if ($note->visibility === 1)
                            <div class="card border-success border mb-3">
                                <div class="card-body" id="card-note-body">
                                    @isset($note)
                                        <div class="card product-box" id="{{ $note->id }}">
                                            <div class="product-action">
                                                <a href="javascript: void(0);"
                                                    class="btn btn-success btn-xs waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#edit-note-modal"
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
                                                    class="btn btn-success btn-xs waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#edit-note-modal"
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
            @isset($element)
                <div class="text-center">
                    <a href="javascript: void(0);" class="btn- btn-xs btn-success"
                        onclick="viewFomAddNote({{ $element->id }}, @if (isset($contact)) 5 @elseif(isset($user)) 16 @endif)" data-bs-toggle="modal"
                        data-bs-target="#add_note-modal"><i class="mdi mdi-plus-circle me-1"></i>Add note</a>
                    <a href="javascript: void(0);" class="btn- btn-xs" data-bs-toggle="" data-bs-target="#notes-modal"
                        onclick="viewDatatableNotes({{ $element->id }});"><i class="mdi mdi-plus-circle me-1"></i>more
                        details</a><br><br>
                </div>
            @endisset
        </div>
    </div>
</div>
