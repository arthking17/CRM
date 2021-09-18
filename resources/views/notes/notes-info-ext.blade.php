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

        <div id="collapse-notes-info" class="collapse show" aria-labelledby="headingFour"
            data-bs-parent="#custom-accordion-notes-info">
            <div class="card-body">
                @if(isset($element))
                    <div class="" style="max-height: 300px" data-simplebar>
                        @if(isset($notes))
                            @if(count($notes) == 0)
                            <p class="text-center"> empty</p>
                            @endif
                            @foreach ($notes as $note)
                                @if ($note->visibility === 1)
                                <div class="" id="card-note-body">
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
                                @elseif($note->visibility === 0)
                                    <div class="" id="card-note-body">
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
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="text-center">
                        <a href="javascript: void(0);" class="btn btn-xs btn-info"
                            onclick="viewFomAddNote({{ $element->id }}, {{ $elementClass }})" data-bs-toggle="modal"
                            data-bs-target="#create-note-modal"><i class="mdi mdi-plus-circle me-1"></i>Add note</a>
                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary" data-bs-toggle="" data-bs-target="#notes-modal"
                            onclick="viewDatatableNotes({{ $element->id }}, {{ $elementClass }});">more
                            details</a><br><br>
                    </div>
                @else
                    <p class="text-center">click on a row of communications in the table to view the notes of the row communication in that side.</p>
                @endif
            </div>
        </div>
    </div>
</div>
