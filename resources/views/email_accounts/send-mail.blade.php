    <!-- Modal -->
    <div class="modal fade" id="send-mail-modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="inbox-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-archive font-18"></i></button>
                            <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-alert-octagon font-18"></i></button>
                            <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-delete-variant font-18"></i></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-folder font-18"></i>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <span class="dropdown-header">Move to</span>
                                <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-label font-18"></i>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <span class="dropdown-header">Label as:</span>
                                <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i> More
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <span class="dropdown-header">More Option :</span>
                                <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
                                <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
                                <a class="dropdown-item" href="javascript: void(0);">Add Star</a>
                                <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                            </div>
                        </div>

                        <div class="mt-4">
                            <form id="send-mail" method="POST" action="#">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" id="send-mail-from-disabled" name="from-disabled" class="form-control" placeholder="From" disabled>
                                    <input type="hidden" id="send-mail-from" name="from" class="form-control" placeholder="From">
                                </div>

                                <div class="mb-3">
                                    <input type="text" id="send-mail-to" name="to" class="form-control" placeholder="To">
                                </div>

                                <div class="mb-3">
                                    <input type="text" id="send-mail-subject" name="subject" class="form-control" placeholder="Subject">
                                </div>
                                <input type="hidden" name="content" id="send-mail-content">
                                <div class="mb-3 card border-0">
                                    <div id="snow-editor" style="height: 230px;">
                                    </div> <!-- end Snow-editor-->
                                </div>

                                <div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save-outline"></i></button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-delete"></i></button>
                                        <button class="btn btn-primary waves-effect waves-light" id="btn-send-mail"> <span>Send</span> <i class="mdi mdi-send ms-2"></i> </button>
                                    </div>
                                </div>

                            </form>
                        </div> <!-- end card-->

                    </div> 
                    <!-- end inbox-rightbar-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
