<div class="card">
    <div class="card-body" data-simplebar style="max-height: 300px;">
        @foreach ($sip_accounts as $key => $sip_account)
            <div class="card product-box">
                <div class="product-action">
                    <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#edit-sip_account-modal"
                        onclick="editSipAccount({{ $sip_account->id }});"><i class="mdi mdi-pencil"></i></a>
                    <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light"
                        onclick="deleteSipAccount({{ $sip_account->id }});"><i class="mdi mdi-close"></i></a>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">Account : </span> {{ $sip_account->account[0]->name }}
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Channel : </span>
                        {{ $sip_account->channel[0]->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="width: 50%">
                        <span class="text-muted">Username : </span>
                        {{ $sip_account->username }}
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Password : </span> *************
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">Name : </span>
                        {{ $sip_account->name }}
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Priority : </span>
                        @if ($sip_account->priority === 1) <span
                                class="badge label-table bg-danger ">low</span>
                        @elseif($sip_account->priority === 2)
                            <span class="badge bg-success text-light">normal</span>
                        @elseif($sip_account->priority === 3)
                            <span class="badge bg-info text-light">High</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">Host : </span>
                        {{ $sip_account->host }}
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Port : </span> {{ $sip_account->port }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
