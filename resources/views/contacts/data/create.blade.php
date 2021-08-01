    <!-- Modal -->
    <div class="modal fade" id="create-contact-data-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <form class="form-horizontal" id="create-contact-data" method="POST" action="#"
                        data-parsley-validate="" novalidate>
                        <div class="row">
                            @csrf
                            <input type="hidden" name="element" id="create-contact-data-element">
                            <input type="hidden" name="element_id" id="create-contact-data-element_id">
                            <input type="hidden" name="class" id="create-contact-data-class">
                            <div class="row mb-3">
                                <label for="create-contact-data-data" class="col-4 col-xl-3 col-form-label">Data<span
                                        class="text-danger">*</span></label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control @error('data') parsley-error @enderror"
                                        name="data" id="create-contact-data-data" placeholder="data" required
                                        data-parsley-pattern-message="This value should be a valid data">
                                    @error('data')
                                        <ul class="parsley-errors-list filled" aria-hidden="false">
                                            <li class="parsley-required">{{ $errors->first('data') }}</li>
                                        </ul>
                                    @else
                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-info waves-effect waves-light">OK</button>
                            </div>
                        </div>
                        <!-- end row-->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
