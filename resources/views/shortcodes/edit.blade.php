    <!-- Modal -->
    <div class="modal fade" id="edit-shortcode-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="modal-title">Edit ShortCode</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-horizontal" id="edit-shortcode" method="POST" action="#" data-parsley-validate=""
                    novalidate>
                    <div class="modal-body p-4">
                        <div class="row">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" id="edit-shortcode-id">
                            <div class="col-12">
                                <div class="text-center">
                                    <div class="alert alert-warning d-none fade show">
                                        <h4 class="mt-0 text-warning">Oh snap!</h4>
                                        <p class="mb-0">This form seems to be invalid :(</p>
                                        <p class="mb-0">Go back and check your data</p>
                                    </div>

                                    <div class="alert alert-info d-none fade show">
                                        <h4 class="mt-0 text-info">Yay!</h4>
                                        <p class="mb-0">Everything seems to be ok :)</p>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-shortcode-account_id" class="form-label">Account</label>
                                        @if (Auth::user()->role == 2)
                                            <input type="text" class="form-select d-none" name="account_id"
                                                id="edit-shortcode-account_id" value="{{ Auth::user()->account_id }}">
                                        @endif
                                        <select class="form-select @error('account_id') parsley-error @enderror"
                                            name="account_id" @if (Auth::user()->role === 2) id="edit-shortcode-account_id-disabled" @elseif (Auth::user()->role === 1) id="edit-shortcode-account_id" @endif
                                            required data-parsley-length="[1, 10]"
                                            data-parsley-length-message="select an account" @if (Auth::user()->role == 2) disabled value="{{ Auth::user()->account_id }}" @endif>
                                            <option>select an account</option>
                                            @foreach ($accounts as $key => $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-shortcode-name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="edit-shortcode-name" name="name"
                                            placeholder="Name" required>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit-shortcode-country" class="form-label">country</label>
                                        <select class="form-select country @error('country') parsley-error @enderror"
                                            name="country" id="edit-shortcode-country" data-parsley-length="[2, 2]">
                                            <option value="">Select a country</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="submit" id="btn-edit-shortcode" class="btn btn-info waves-effect waves-light"><i
                                class="mdi mdi-content-save"></i>Save</button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="$('#edit-shortcode-modal').modal('toggle')"><i
                                class="fe-x me-1"></i>Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
