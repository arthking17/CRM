<table id="datatable-shortcodes" class="table table-center dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Id</th>
            <th>Account</th>
            <th>Name</th>
            <th>Country</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($shortcodes as $shortcode)
            <tr id="shortcodeid{{ $shortcode->id }}">
                <td>{{ $shortcode->id }}</td>
                <td>{{ $shortcode->account[0]->name }}</td>
                <td>{{ $shortcode->name }}</td>
                <td>{{ getCountryName($shortcode->country) }}</td>
                <td>{{ $shortcode->start_date }}</td>
                <td>{{ $shortcode->end_date }}</td>
                <td>
                    @if ($shortcode->status === 1)
                        <span class="badge label-table bg-success">Active</span>
                    @elseif($shortcode->status === 0)
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($shortcode->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i class="mdi mdi-delete-circle"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#edit-shortcode-modal" onclick="editShortCode({{ $shortcode->id }});"
                            data-toggle="modal"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" onclick="deleteShortCode({{ $shortcode->id }});"
                            class="btn- btn-xs btn-danger">
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
            <th class="select">Name</th>
            <th class="select">Country</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="select with-span">Status</th>
            <th class="disabled"></th>
        </tr>
    </tfoot>
</table>
