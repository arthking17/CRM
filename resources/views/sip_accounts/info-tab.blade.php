<div class="accordion custom-accordion" id="custom-accordion-sip_accounts-info">
    <div class="card mb-0">
        <div class="card-header" id="heading-sip_accounts-info">
            <h5 class="m-0 position-relative">
                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                    href="#collapse-sip_accounts-info" aria-expanded="true" aria-controls="collapse-sip_accounts-info">
                    <h4 class="mb-1 mt-1 text-uppercase p-1"><i class="mdi mdi-sip_account-text-outline me-1"></i>Info <i
                            class="mdi mdi-chevron-down accordion-arrow"></i></h4>
                </a>
            </h5>
        </div>

        <div id="collapse-sip_accounts-info" class="collapse show" aria-labelledby="headingFour"
            data-bs-parent="#custom-accordion-sip_accounts-info">
            <div class="card-body">
                @if(isset($sip_account))
                    <div class="w-100" id="sip_accounts-info1">
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Host :</h4>
                        <p class="mb-3">{{ $sip_account->host }}</p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Username :</h4>
                        <p class="mb-3">{{ $sip_account->username }}</p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Password :</h4>
                        <p class="mb-3">*******************</p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Port :</h4>
                        <p class="mb-3">{{ $sip_account->port }}</p>
    
                        <h4 class="font-13 text-muted text-uppercase mb-1">Name :</h4>
                        <p class="mb-3">{{ $sip_account->name }}</p>
    
                        @if ($sip_account->status === 1)
                            <a id="edit-{{ $sip_account->id }}" class="btn- btn-xs btn-secondary js--tippy"
                                title="Edit sip_account" href="javascript: void(0);" data-bs-toggle="modal"
                                data-bs-target="#edit-sip_account-modal"
                                onclick="editSipAccount({{ $sip_account->id }});"><i
                                    class="mdi mdi-square-edit-outline"></i></a>
                            <a id="delete-{{ $sip_account->id }}" class="btn- btn-xs btn-danger js--tippy"
                                title="Delete sip_account" href="javascript: void(0);"
                                onclick="deleteSipAccount({{ $sip_account->id }});"><i
                                    class="mdi mdi-delete-circle"></i></a>
                        @endif
                    </div>
                @else
                    <p class="text-center"> click on a table sip accounts row to view more details in that side.</p>
                @endif
            </div>
        </div>
    </div>
</div>
