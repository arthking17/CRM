<div class="card">
    <div class="card-body" id="card-permission">
        <h4 class="mb-1 mt-1 text-uppercase bg-light p-1"><i class="mdi mdi-key-chain me-1"></i>
            Permissions</h4>
        <div class="card border-success border mb-3">
            <div class="card-body" id="card-note-body" data-simplebar style="max-height: 200px;">
                @if (isset($user) and isset($users_permissions))
                @php
                $codes = ['create', 'show', 'update', 'delete']
                @endphp
                @for ($i = 0; $i < 17; $i++) @php $element=null @endphp @foreach ($users_permissions as $permission) @if (explode('.', $permission->code)[0] == getElementName($i + 1))
                    @if ($element != explode('.', $permission->code)[0])
                    <h4 class="card-title
                                text-success">{{ explode('.', $permission->code)[0] }}</h4>
                    <p class="card-text">
                        <div class="row mb-3">
                            <div class="d-flex align-items-start mb-3">
                                <div class="switchery-demo w-100">
                                    @foreach ($codes as $code)
                                    @php
                                    $action = 0;
                                    @endphp
                                    @foreach ($users_permissions as $p)
                                    @if (explode('.', $p->code)[0] == getElementName($i + 1))
                                    @if (explode('.', $p->code)[1] == $code)
                                    @php $action = 1 @endphp
                                    @endif
                                    @endif
                                    @endforeach
                                    <input type="checkbox" @if ($action) checked @endif data-plugin="switchery" data-color="#64b0f2" name="{{ $code }}"
                                    id="edit-permissions-{{ $element }}-{{ $code }}">{{ $code }}
                                    @endforeach
                                </div>
                                <a href="javascript: void(0);" class="btn- btn-xs btn-success" onclick="saveUserPermissions({{ $permission->user_id }}, {{ $element }})"><i class="fe-save"></i></a>
                            </div>
                        </div>
                    </p>
                    @endif
                    @php $element = explode('.', $permission->code)[0] @endphp
                    @endif
                    @endforeach
                    @endfor
                    @endif
            </div>
        </div>
        @if (isset($user) and isset($users_permissions))
        <a href="javascript: void(0);" class="btn- btn-xs btn-danger" title="New Permission" data-bs-toggle="modal" onclick="viewFormCreatePermission({{ $user->id }}, '{{ $user->username }}');" data-bs-target="#create-permission-modal"><i class="mdi mdi-key-plus"></i></a>
        <a href="javascript: void(0);" class="btn- btn-xs btn-secondary" title="User Permissions" data-bs-toggle="" onclick="viewDatatableUsers_Permissions({{ $user->id }});" data-bs-target="#users_permissions-modal"><i class="mdi mdi-key-chain"></i></a>
        @endif
    </div>
</div>
