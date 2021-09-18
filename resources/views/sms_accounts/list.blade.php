<div class="card">
    <div class="" data-simplebar style="max-height: 300px;">
        @foreach ($sms_accounts as $key => $sms)
            <div class="card product-box">
                <div class="product-action">
                    <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#edit-sms_account-modal"
                        onclick="editSMSAccount({{ $sms->id }});"><i class="mdi mdi-pencil"></i></a>
                    <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light"
                        onclick="deleteSMSAccount({{ $sms->id }});"><i class="mdi mdi-close"></i></a>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">Account : </span> {{ $sms->account[0]->name }}
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Name : </span> {{ $sms->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="width: 50%">
                        <span class="text-muted">Username : </span>
                        <span class="truncate" title="{{ $sms->username }}"> {{ $sms->username }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Password : </span> *************
                    </div>
                </div><br>
            </div>
        @endforeach
    </div>
</div>
