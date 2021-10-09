<!-- Modal -->
<div class="modal fade" id="sipaccount-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="myCenterModalLabel">SIP Account</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                @if (isset($user->users_sipaccount[0]->sipaccount[0]->name))
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h4 class="mt-0 mb-1">Id : {{ $user->users_sipaccount[0]->sipaccount[0]->id }}
                                </h4>
                                <p class="text-muted"><i class="mdi mdi-phone"></i>Account :
                                    {{ $user->users_sipaccount[0]->sipaccount[0]->account[0]->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <br>
                                <p class="text-muted"><i class="mdi mdi-account"></i>Channel :
                                    {{ $user->users_sipaccount[0]->sipaccount[0]->channel[0]->name }}</p>
                                <p class="text-muted d-none"> {{ $user->users_sipaccount[0]->sipaccount[0]->id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                <h4 class="font-13 text-muted text-uppercase mb-1">Host :</h4>
                                <p class="mb-3">{{ $user->users_sipaccount[0]->sipaccount[0]->host }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">

                                <h4 class="font-13 text-muted text-uppercase mb-1">Username :</h4>
                                <p class="mb-3">{{ $user->users_sipaccount[0]->sipaccount[0]->username }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                <h4 class="font-13 text-muted text-uppercase mb-1">Port :</h4>
                                <p class="mb-3">{{ $user->users_sipaccount[0]->sipaccount[0]->port }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">

                                <h4 class="font-13 text-muted text-uppercase mb-1">Name :</h4>
                                <p class="mb-3">{{ $user->users_sipaccount[0]->sipaccount[0]->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                <h4 class="font-13 text-muted text-uppercase mb-1">Priority :</h4>
                                <p class="mb-3">
                                    @if ($user->users_sipaccount[0]->sipaccount[0]->priority === 1) <span
                                            class="badge label-table bg-danger ">low</span>
                                    @elseif($user->users_sipaccount[0]->sipaccount[0]->priority === 2)
                                        <span class="badge bg-success text-light">normal</span>
                                    @elseif($user->users_sipaccount[0]->sipaccount[0]->priority === 3)
                                        <span class="badge bg-info text-light">High</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">

                                <h4 class="font-13 text-muted text-uppercase mb-1">Status :</h4>
                                <p class="mb-3">
                                    @if ($user->users_sipaccount[0]->sipaccount[0]->status === 1) <span
                                            class="badge label-table bg-success">Active</span>
                                    @elseif($user->users_sipaccount[0]->sipaccount[0]->status === 0)
                                        <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-light text-center">
                <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                    onclick="$('#sipaccount-modal').modal('toggle')"><i class="fe-x me-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>
