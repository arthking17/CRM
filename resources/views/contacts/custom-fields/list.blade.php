    <!-- Modal -->
    <div class="modal fade" id="custom-fields-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Custom Fields</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive" data-simplebar>
                        <table class="table activate-select dt-responsive nowrap w-100 users-state-datatable"
                            id="datatable-custom-fields">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Account</th>
                                    <th>Name</th>
                                    <th>Tag</th>
                                    <th>Field Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($custom_fields as $custom_field)
                                    <tr id="custom-field{{ $custom_field->id }}">
                                        <td>{{ $custom_field->id }}</td>
                                        <td>{{ $custom_field->account[0]->name }}</td>
                                        <td>{{ $custom_field->name }}</td>
                                        <td>{{ $custom_field->tag }}</td>
                                        <td>{{ $custom_field->field_type }}</td>
                                        
                                        <td>
                                            @if ($custom_field->status === 0)
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            @else
                                                <a href="javascript:void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#edit-custom-field-modal"
                                                    onclick="editCustomField({{ $custom_field->id }});"
                                                    data-toggle="modal"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="javascript:void(0);"
                                                    onclick="deleteCustomField({{ $custom_field->id }});"
                                                    class="action-icon">
                                                    <i class="mdi mdi-delete"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th class="select">Account</th>
                                    <th>Name</th>
                                    <th>Tag</th>
                                    <th class="select">Field Type</th>
                                    <th class="disabled"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
