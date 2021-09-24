<div>
    <table class="table table-striped table-center dt-responsive nowrap w-100" id="datatable-custom-fields">
        <thead>
            <tr>
                <th>Id</th>
                <th>Account</th>
                <th>Name</th>
                <th>Tag</th>
                <th>Field Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($custom_fields as $custom_field)
                <tr id="custom_fieldid{{ $custom_field->id }}">
                    <td>{{ $custom_field->id }}</td>
                    <td>{{ $custom_field->account[0]->name }}</td>
                    <td>{{ $custom_field->name }}</td>
                    <td>{{ $custom_field->tag }}</td>
                    <td>{{ $custom_field->field_type }}</td>
                    <td>
                        @if ($custom_field->status === 1)
                            <span class="badge label-table bg-success">Active</span>
                        @elseif($custom_field->status === 0)
                            <span class="badge bg-danger">Disabled</span>
                        @endif
                    </td>
                    <td>
                        @if ($custom_field->status === 0)
                            <a href="javascript:void(0);" class="btn- btn-xs btn-secondary"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                            <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i
                                    class="mdi mdi-delete-circle"></i></a>
                        @else
                            <a id="edit-{{ $custom_field->id }}" href="javascript:void(0);"
                                class="btn- btn-xs btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#edit-custom-field-modal"
                                onclick="editCustomField({{ $custom_field->id }});" data-toggle="modal"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                            <a id="delete-{{ $custom_field->id }}" href="javascript:void(0);"
                                onclick="deleteCustomField({{ $custom_field->id }});" class="btn- btn-xs btn-danger">
                                <i class="mdi mdi-delete-circle"></i></a>
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
                <th class="select with-span">Status</th>
                <th class="disabled"></th>
            </tr>
        </tfoot>
    </table>
</div>
