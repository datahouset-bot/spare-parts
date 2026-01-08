<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@extends('layouts.blank')

@section('pagecontent')

<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

<style>
/* ================== PAGE LOOK ================== */
.container {
    max-width: 1100px;
}

/* ================== CARD ================== */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,.12);
}

.card-header {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    text-align: center;
}

/* ================== BUTTONS ================== */
.btn-primary {
    background: linear-gradient(135deg, #0d6efd, #084298);
    border: none;
    border-radius: 8px;
    padding: 8px 20px;
    font-weight: 600;
}

.btn-primary:hover {
    transform: translateY(-1px);
}

/* ================== TABLE ================== */
.table thead th {
    background: #f1f5f9;
    font-weight: 700;
    text-align: center;
}

.table td {
    vertical-align: middle;
    text-align: center;
}

.table tr:hover {
    background-color: #f8fafc;
}

/* ================== ICONS ================== */
.action-icon {
    font-size: 20px;
    color: #4f46e5;
    transition: 0.2s;
}

.action-icon:hover {
    color: #dc2626;
    transform: scale(1.15);
}

/* ================== MODAL ================== */
.modal-content {
    border-radius: 14px;
    box-shadow: 0 20px 50px rgba(0,0,0,.3);
}

.modal-header {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff;
    border-radius: 14px 14px 0 0;
}

.modal-title {
    font-weight: 700;
}

.modal-body label {
    font-weight: 600;
    font-size: 14px;
}

.modal-body input {
    border-radius: 8px;
    height: 42px;
}

/* ================== ALERT ================== */
.alert {
    border-radius: 10px;
    font-weight: 600;
}
</style>

<script>
$(document).ready(function () {
    new DataTable('#remindtable');
});
</script>

<div class="container my-4">

    {{-- ALERTS --}}
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            Label Setting
        </div>

        {{-- ACTION BAR --}}
        <div class="card-body text-center">
            <button type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#myModal">
                <i class="fa fa-plus me-1"></i> Add New Field
            </button>
        </div>

        {{-- TABLE --}}
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered" id="remindtable">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>New Name</th>
                        <th>Visible</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $record)
                    <tr>
                        <td>{{ $record->field_name }}</td>
                        <td>{{ $record->replaced_field_name }}</td>
                        <td>
                            @if($record->is_visible)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('batch_lebel_edit/'.$record->id) }}">
                                <i class="fa fa-edit action-icon"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL ================= --}}
<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add / Update Label</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('/save_batchseeting') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <label>Field Name</label>
                    <input type="text" name="field_name" class="form-control mb-2">
                    @error('field_name') <small class="text-danger">{{ $message }}</small> @enderror

                    <label>New Field Name</label>
                    <input type="text" name="replaced_field_name" class="form-control mb-2">
                    @error('replaced_field_name') <small class="text-danger">{{ $message }}</small> @enderror

                    <label>Visible (1 = Yes, 0 = No)</label>
                    <input type="text" name="is_visible" class="form-control">
                    @error('is_visible') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
