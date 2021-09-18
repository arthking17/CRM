<!-- Modal -->
<div id="sms-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="multiple-twoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div id="sms-modal-content" class="modal-content modal-filled">
            <div id="sms-modal-header" class="modal-header bg-light">
                <h4 class="modal-title" id="multiple-twoModalLabel">You're writing a sms...</h4>
                <button id="button-sms-two-close" type="button" data-bs-dismiss="modal" class="btn-close"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="inbox-center">
                    <form id="send-sms" method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <select class="form-select @error('from') parsley-error @enderror" name="from"
                                id="send-sms-from" required data-parsley-type="integer" data-parsley-length="[1, 10]">
                                <option value="">select contact sender</option>
                                @foreach ($sms_accounts as $key => $sms)
                                    <option value="{{ $sms->id }}">{{ $sms->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <!--<input type="text" id="send-sms-to" name="to" class="form-control" placeholder="To">-->

                            <select class="@error('to') parsley-error @enderror" id="send-sms-to" name="to" required
                                multiple>
                                <option value="">select contact receiver</option>
                            </select>
                        </div>

                        <div class="mb-3 card border-0">
                            <textarea class="form-control" name="message" id="send-sms-message" cols="30" rows="10"></textarea>
                        </div>

                        <div>
                            <div class="text-end">
                                <button class="btn btn-primary waves-effect waves-light" id="btn-send-sms">
                                    <span>Send</span> <i class="mdi mdi-send ms-2"></i> </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
