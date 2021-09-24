<table id="datatable-accounts" class="table table-striped dt-responsive nowrap w-100" data-page-size="7">
    <thead>
        <tr>
            <th class="text-filter">Id</th>
            <th data-toggle="true" class="text-filter">Name</th>
            <th class="text-filter">Url</th>
            <th class="select-filter">Status</th>
            <th class="text-filter">Start date</th>
            <th class="text-filter">End date</th>
            <th style="width: 90px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($accounts as $account)
            <tr id="accid{{ $account->id }}">
                <td>{{ $account->id }}</td>
                <td>{{ $account->name }}</td>
                <td>{{ $account->url }}</td>
                <td>
                    @if ($account->status === 1) <span
                        class="badge bg-success">Active</span> @elseif ($account->status
                        === 0)
                        <span class="badge label-table bg-danger">Disabled</span>
                    @elseif($account->status === 2)
                        <span class="badge bg-blue text-light">Legit</span>
                    @elseif($account->status === 3)
                        <span class="badge bg-dark text-light">Invoicing</span>
                    @endif
                </td>
                <td>{{ $account->start_date }}</td>
                <td>{{ $account->end_date }}</td>
                <td>
                    @if ($account->status === 0)
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" class="btn- btn-xs btn-danger"> <i
                                class="mdi mdi-delete"></i></a>
                    @else
                        <a href="javascript:void(0);" class="btn- btn-xs btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#edit-modal" id="edit-{{ $account->id }}"
                            onclick="editAccount({{ $account->id }});" data-toggle="modal"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" id="delete-{{ $account->id }}"
                            onclick="deleteAccount({{ $account->id }});" class="btn- btn-xs btn-danger"> <i
                                class="mdi mdi-delete"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="">Id</th>
        <th class="">Name</th>
        <th class=" ">Url</th>
        <th class="select">Status</th>
            <th class="">Start date</th>
        <th class="">End date</th>
        <th class=" disabled" style="width: 90px;">Action</th>
        </tr>
    </tfoot>
</table>
