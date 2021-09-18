<div class="accordion custom-accordion" id="custom-accordion-communications-info">
    <div class="card mb-0">
        <div class="card-header" id="heading-communications-info">
            <h5 class="m-0 position-relative">
                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                    href="#collapse-communications-info" aria-expanded="true" aria-controls="collapse-communications-info">
                    <h4 class="mb-1 mt-1 text-uppercase p-1"><i class="mdi mdi-communication-text-outline me-1"></i>Info <i
                            class="mdi mdi-chevron-down accordion-arrow"></i></h4>
                </a>
            </h5>
        </div>

        <div id="collapse-communications-info" class="collapse" aria-labelledby="headingFour"
            data-bs-parent="#custom-accordion-communications-info">
            <div class="card-body">
                @if(isset($communication))
                    <div class="w-100" id="communications-person-info1">
                        <h4 class="mt-0 mb-1">Id : {{ $communication->id }}</h4>
                        <p class="text-muted"><i class="mdi mdi-phone"></i>Contact :
                            {{ $contact_name }}</p>
                        <p class="text-muted"><i class="mdi mdi-account"></i>User :
                            {{ $communication->user[0]->username }}</p>
                        <p class="text-muted d-none"> {{ $communication->id }}</p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Class :</h4>
                        <p class="mb-3">
                            @if ($communication->class === 1) <span
                                    class="badge label-table bg-blue ">Call</span>
                            @elseif($communication->class === 2)
                                <span class="badge bg-info text-light">Email</span>
                            @elseif($communication->class === 3)
                                <span class="badge bg-warning text-light">Sms</span>
                            @endif
                        </p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Channel :</h4>
                        <p class="mb-3">{{ $communication->channel }}</p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Qualification :</h4>
                        <p class="mb-3">
                            @if ($communication->qualification === 1)
                                <span class="badge label-table bg-success">completed with success</span>
                            @elseif($communication->qualification === 2)
                                <span class="badge bg-info text-light">interruption during call</span>
                            @endif
                        </p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
                        <p class="mb-3">
                            @if ($communication->status === 1) <span
                                    class="badge label-table bg-success">Active</span>
                            @elseif($communication->status === 0)
                                <span class="badge bg-danger">Disabled</span>
                            @endif
                        </p>
                        @if ($communication->status === 1)
                            <a id="edit-{{ $communication->id }}" class="btn- btn-xs btn-info js--tippy"
                                title="Edit communication" href="javascript: void(0);" data-bs-toggle="modal"
                                data-bs-target="#edit-communication-modal"
                                onclick="editCommunication({{ $communication->id }});"><i
                                    class="mdi mdi-square-edit-outline"></i></a>
                            <a id="delete-{{ $communication->id }}" class="btn- btn-xs btn-danger js--tippy"
                                title="Delete communication" href="javascript: void(0);"
                                onclick="deleteCommunication({{ $communication->id }});"><i
                                    class="mdi mdi-delete-circle"></i></a>
                        @endif
                    </div>
                @else
                    <p class="text-center">click on a table communications row to view more details in that side.</p>
                @endif
            </div>
        </div>
    </div>
</div>
