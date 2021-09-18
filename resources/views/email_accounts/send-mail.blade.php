    <!-- Modal -->
    <div class="modal fade" id="send-mail-modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="inbox-center">
                        <form id="send-mail" method="POST" action="#" data-parsley-validate="" novalidate>
                            @csrf
                            <div class="mb-3">
                                <select class="form-select @error('from') parsley-error @enderror" name="from"
                                    id="send-mail-from" required data-parsley-type="integer"
                                    data-parsley-length="[1, 10]">
                                    <option value="">select email sender</option>
                                    @foreach ($email_accounts as $key => $email)
                                        <option value="{{ $email->id }}">{{ $email->email }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <!--<input type="text" id="send-mail-to" name="to" class="form-control" placeholder="To">-->

                                <select class="@error('to') parsley-error @enderror" id="send-mail-to" name="to"
                                    required multiple>
                                    <option value="">select the receiver email</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <input type="text" id="send-mail-subject" name="subject" class="form-control"
                                    placeholder="Subject">
                            </div>
                            <input type="hidden" name="content" id="send-mail-content">
                            <div class="mb-3 card border-0">
                                <div id="snow-editor" style="height: 230px;">
                                </div> <!-- end Snow-editor-->
                            </div>

                            <div>
                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-light" id="btn-send-mail">
                                        <span>Send</span> <i class="mdi mdi-send ms-2"></i> </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- end inbox-rightbar-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
