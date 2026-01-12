@extends('layouts.blank')
@section('pagecontent')
    

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Role : {{ $role->name }}
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')

                          <div class="mb-3">

    @error('permission')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    {{-- Select All --}}
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" id="checkAllPermissions">
        <label class="form-check-label fw-bold" for="checkAllPermissions">
            Check / Uncheck All Permissions
        </label>
    </div>

    <hr>

    <label class="fw-semibold">Permissions</label>

    <div class="row">
        @foreach ($permissions as $permission)
            <div class="col-md-2">
                <div class="form-check">
                    <input
                        class="form-check-input permission-checkbox"
                        type="checkbox"
                        name="permission[]"
                        value="{{ $permission->name }}"
                        id="permission_{{ $permission->id }}"
                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

</div>

                            <div class="mb-3">
                                {{-- @if (auth()->check() && (auth()->user()->email === 'datahouset@gmail.com' || auth()->user()->email === Auth::user()->firm_id.'@gmail.com')) --}}

                                <button type="submit" class="btn btn-primary">Update</button>
                                {{-- @endcan --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAllPermissions');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        // Check / Uncheck All
        checkAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Update "Check All" when individual checkbox changes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                checkAll.checked = [...checkboxes].every(c => c.checked);
            });
        });

        // On page load – set Check All if all are already checked
        checkAll.checked = [...checkboxes].length > 0 &&
                           [...checkboxes].every(c => c.checked);
    });
</script>

    @endsection