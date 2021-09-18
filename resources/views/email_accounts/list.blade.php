<div class="card">
    <div class="" data-simplebar style="max-height: 300px;">
        @foreach ($email_accounts as $key => $email)
            <div class="card product-box">
                <div class="product-action">
                    <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#edit-modal"
                        onclick="editEmailAccount({{ $email->id }});"><i class="mdi mdi-pencil"></i></a>
                    <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light"
                        onclick="deleteEmailAccount({{ $email->id }});"><i class="mdi mdi-close"></i></a>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">Host : </span> {{ $email->host }}
                    </div>
                    <div class="col-md-6" style="width: 50%">
                        <span class="text-muted">Email : </span>
                        <span class="truncate" title="{{ $email->email }}"> {{ $email->email }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="width: 50%">
                        <span class="text-muted">Username : </span>
                        <span class="truncate" title="{{ $email->username }}"> {{ $email->username }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Password : </span> *************
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">SMTPAuth : </span>
                        @if ($email->smtpauth == 1) <span class="badge bg-info text-light">Yes</span>
                        @elseif($email->smtpauth == 0) <span class="badge label-table bg-danger ">No</span> @endif
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">SMTPSecure : </span>
                        @if ($email->smtpsecure == 1) <span class="badge bg-success text-light">TLS</span>
                        @elseif($email->smtpsecure == 2) <span class="badge bg-pink text-light">SSL</span>
                        @elseif($email->smtpsecure == 3) <span class="badge label-table bg-warning ">NOTLS</span>
                        @elseif($email->smtpsecure == 4) <span class="badge bg-blue text-light">STARTTLS</span> @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted">Email Type : </span>
                        @if ($email->type == 1)
                        Unitary @elseif($email->type == 0) Max Marketing
                        @endif
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Port : </span> {{ $email->port }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
