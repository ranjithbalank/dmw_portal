@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                    <span>{{ 'Create Role' }}</span>
                    <a href="{{ route('assign-unit-permissions.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                </div>

                <form action="{{ route('assign-unit-permissions.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3 mt-3 px-3">
                        <div class="col-md-4">
                            <label for="role_id" class="form-label">Select Role</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ strtoupper($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="unit_id" class="form-label">Select Unit</label>
                            <select class="form-select" id="unit_id" name="unit_id" required>
                                <option value="">-- Select Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ strtoupper($unit->name) }} - {{ strtoupper($unit->code) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="module_id" class="form-label">Select Module</label>
                            <select class="form-select" id="module_id" name="module_id" required>
                                <option value="">-- Select Module --</option>
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">{{ strtoupper($module->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="permissionSection" class="mb-4 px-3" style="display: none;">
                        <h5 class="mt-3">Assign Permissions:</h5>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                            id="checkbox-{{ $permission }}"
                                           name="permission_ids[]"
                                            value="{{ $permission->id }}">
                                        <label class="form-check-label" for="checkbox-{{ $permission }}">
                                            {{ ucfirst($permission->name) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <input type="hidden" name="permissions" id="finalPermissionsJson">

                    <div class="text-end px-3 pb-3">
                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roleSelect = document.getElementById('role_id');
        const unitSelect = document.getElementById('unit_id');
        const moduleSelect = document.getElementById('module_id');
        const permissionSection = document.getElementById('permissionSection');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        const finalPermissionsJson = document.getElementById('finalPermissionsJson');

        [roleSelect, unitSelect, moduleSelect].forEach(el =>
            el.addEventListener('change', fetchPermissions)
        );

        function fetchPermissions() {
            const roleId = roleSelect.value;
            const unitId = unitSelect.value;
            const moduleId = moduleSelect.value;

            permissionCheckboxes.forEach(cb => cb.checked = false);

            if (roleId && unitId && moduleId) {
                permissionSection.style.display = 'block';

                fetch("{{ route('assign-unit-permissions.fetch') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        role_id: roleId,
                        unit_id: unitId,
                        module_id: moduleId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    data.forEach(permission => {
                        const checkbox = document.getElementById('checkbox-' + permission);
                        if (checkbox) checkbox.checked = true;
                    });
                });
            } else {
                permissionSection.style.display = 'none';
            }
        }

        document.querySelector('form').addEventListener('submit', function () {
            const roleId = roleSelect.value;
            const unitId = unitSelect.value;
            const moduleId = moduleSelect.value;
            let permissions = [];

            permissionCheckboxes.forEach(cb => {
                if (cb.checked) {
                    permissions.push(cb.name.replace('permissions_temp[', '').replace(']', ''));
                }
            });

            finalPermissionsJson.value = JSON.stringify({
                role_id: roleId,
                unit_id: unitId,
                module_id: moduleId,
                permissions: permissions
            });
        });
    });
</script>
@endsection
