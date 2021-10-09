    <!-- Modal -->
    <div class="modal fade" id="edit-phone-data-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Contact Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="form-horizontal" id="edit-phone-data" method="POST" action="#"
                    data-parsley-validate="" novalidate>
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit-phone-data-id">
                            <input type="hidden" name="element" id="edit-phone-data-element">
                            <input type="hidden" name="element_id" id="edit-phone-data-element_id">
                            <input type="hidden" name="class" id="edit-phone-data-class">
                            <div class="row mb-3">
                                <label for="edit-phone-data-data" class="col-4 col-xl-3 col-form-label">Phone Number<span class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input class="form-control" name="data" id="edit-phone-data-data" type="tel" required>
                                    @error('data')
                                        <ul class="parsley-errors-list filled" id="#error-edit-phone-data-data" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('data') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-8 offset-4">
                                <button type="submit" id="btn-edit-phone-data" class="btn btn-info waves-effect waves-light">OK</button>
                            </div>
                        </div>
                        <!-- end row-->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
