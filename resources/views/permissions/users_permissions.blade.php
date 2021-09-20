    <table class="table table-striped table-center dt-responsive nowrap w-100" id="datatable-users_permissions">
        <thead>
            <tr>
                <th>Element</th>
                <th>Show</th>
                <th>Create</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @php
                $elements = ['accounts', 'appointments', 'communications', 'contact_data', 'contacts', 'contacts_companies', 'contacts_field', 'contacts_persons', 'custom_field', 'email_accounts', 'fax_accounts', 'groups', 'imports', 'logs', 'notes', 'sip_accounts', 'sms_accounts', 'users', 'users_permissions', 'shortcodes'];
                $codes = ['show', 'create', 'update', 'delete'];
                $permissions = [];
                $checked = 0;
                $permission = ['show' => 0, 'create' => 0, 'update' => 0, 'delete' => 0];
                foreach ($elements as $key => $element) {
                    array_push($permissions, $permission);
                }
                foreach ($users_permissions as $key => $permission) {
                    $code = explode('.', $permission->code)[1];
                    $element = explode('.', $permission->code)[0];
                    $i = array_search(strtolower($element), $elements);
                    $permissions[$i][$code] = 1;
                }
            @endphp

            @foreach ($permissions as $key => $permission)
                <tr id="users_permissionid{{ $key }}">
                    <td>{{ $elements[$key] }}</td>
                    @foreach ($codes as $code)
                        <td>
                            <input type="checkbox" @if ($permission[$code] === 1) checked @endif data-plugin="switchery" data-color="#64b0f2"
                                name="{{ $elements[$key] }}" id="permissions-{{ $elements[$key] }}-{{ $code }}" value="1">
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Element</th>
                <th>Show</th>
                <th>Create</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </tfoot>
    </table>
