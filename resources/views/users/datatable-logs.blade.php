<div>
    <table id="datatable-logs" class="table activate-select dt-responsive nowrap w-100 table-hover">
        <thead>
            <tr>
                <th>id</th>
                <th>user</th>
                <th>date</th>
                <th>action</th>
                <th>element</th>
                <th>element_id</th>
                <th>source</th>
            </tr>
        </thead>
        <tbody>
            @if ($logs->count() > 0)
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user[0]->username }}</td>
                        <td>{{ $log->log_date }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ getElementName($log->element) }}</td>
                        <td>{{ $log->element_id }}</td>
                        <td>{{ $log->source }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th>id</th>
                <th>user</th>
                <th>date</th>
                <th class="select">action</th>
                <th class="select">element</th>
                <th>element_id</th>
                <th class="select">source</th>
            </tr>
        </tfoot>
    </table>
</div>
