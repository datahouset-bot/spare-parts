<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>


    <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');

        });
    </script>
    <style>
/* ===== PAGE BACKGROUND ===== */
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* ===== CARD ===== */
.card {
    border-radius: 18px;
    border: none;
    box-shadow: 0 14px 32px rgba(0,0,0,0.12);
    animation: fadeSlide 0.6s ease;
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== CARD HEADER ===== */
.card-header {
    background: linear-gradient(135deg, #4f46e5, #1e3a8a);
    color: #fff;
    padding: 18px 22px;
    border-radius: 18px 18px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.card-header span {
    font-size: 22px;
    font-weight: 700;
}

/* ===== ACTION BAR ===== */
.header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ===== BUTTONS ===== */
.btn-primary {
    border-radius: 30px;
    font-weight: 600;
    padding: 8px 22px;
    transition: all .25s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(79,70,229,.45);
}

.btn-warning {
    border-radius: 25px;
    font-weight: 600;
}

.btn-outline-primary {
    border-radius: 50%;
}

/* ===== PUSH RATE BOX ===== */
.push-box {
    background: #f8fafc;
    border-radius: 14px;
    padding: 10px;
    box-shadow: inset 0 0 0 1px #c7d2fe;
}

/* ===== TABLE ===== */
.table {
    border-radius: 14px;
    overflow: hidden;
}

.table thead th {
    background: #eef2ff;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
}

.table tbody tr {
    transition: all .25s ease;
}

.table tbody tr:hover {
    background: #f1f5ff;
    transform: scale(1.01);
}

/* ===== ICON ACTIONS ===== */
.fa-edit,
.fa-trash {
    transition: transform .2s ease, color .2s ease;
}

.fa-edit:hover {
    transform: scale(1.25);
    color: #4f46e5 !important;
}

.fa-trash:hover {
    transform: scale(1.25);
    color: #dc2626 !important;
}

/* ===== MODAL ===== */
.modal-content {
    border-radius: 18px;
    animation: zoomIn .3s ease;
}

@keyframes zoomIn {
    from { transform: scale(.92); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.modal-header {
    background: linear-gradient(135deg, #6366f1, #1e3a8a);
    color: #fff;
    border-radius: 18px 18px 0 0;
}

/* ===== FORM INPUTS ===== */
.form-control,
.form-select {
    border-radius: 10px;
    border: 2px solid #c7d2fe;
}

.form-control:focus,
.form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.25);
}

/* ===== DATATABLE SEARCH ===== */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 6px 14px;
}
</style>

    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif


<div class="card my-3">
  <div class="card-header">
    <span>Service Plan</span>

    <div class="header-actions">

        <button type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#myModal">
            <i class="fa fa-plus"></i> Add Service
        </button>

        <form action="{{ url('/pushrate') }}"
              method="POST"
              class="d-inline-flex align-items-center gap-2 push-box"
              style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
            @csrf
            <input type="date" name="start_date" class="form-control form-control-sm" required>
            <input type="date" name="end_date" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-sm btn-warning">
                <i class="fa fa-upload"></i> Push
            </button>
        </form>

    </div>
</div>



            <div class="container mt-5">


                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Vehicle Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('roomtypes.store') }}" method="POST">
                                    @csrf
                                    <div>

                                        Service Type<input type="text" name ="roomtype_name"class="form-control"
                                            placeholder="service type  ">
                                        <span class="text-danger">
                                            @error('roomtype_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div>
    <label class="form-label">Package</label>

    <div class="input-group">
        <select name="package_id"
                id="myitemgroup"
                class="myitemgroup form-select"
                aria-label="Default select example">
            <option value="" selected disabled>Select Package</option>

            @foreach ($data as $record)
                <option value="{{ $record['id'] }}">
                    {{ $record['package_name'] }}
                    || {{ $record['plan_name'] }}
                    || {{ $record['other_name'] }}
                </option>
            @endforeach
        </select>

        <!-- ➕ ADD PACKAGE -->
        <a href="{{ url('/packages') }}"
           class="btn btn-outline-primary"
           title="Add Package">
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <span class="text-danger">
        @error('package_id') {{ $message }} @enderror
    </span>
</div>

                                    <div>

                                        GST / TAX % <select name ="gst_id" id ="myitemgroup"class="myitemgroup form-select"
                                            aria-label="Default select example">
                                            <option value ="" selected disabled>Select GST / Tax </option>
                                            @foreach ($data1 as $record1)
                                                <option value={{ $record1['id'] }}>{{ $record1['taxname'] }}&nbsp;||&nbsp;
                                                    {{ number_format($record1['igst'], 2) }}&nbsp;||&nbsp;{{ number_format($record1['vat'], 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('gst_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div>

                                        labour charge <input type="text" name ="room_tariff"class="form-control"
                                            placeholder="Service Charge">
                                        <span class="text-danger">
                                            @error('room_tariff')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div>

                                        product Dis % <input type="text" name ="room_dis"class="form-control"
                                            placeholder="Product dis On % only  ">
                                        <span class="text-danger">
                                            @error('room_dis')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">

                                        Product Code <input type="text" name ="room_type_af1"class="form-control"
                                            placeholder="Product Code Given By  CM">
                                        <span class="text-danger">
                                            @error('room_type_af1')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">

                                        vehicle number <input type="text"
                                            name ="room_type_af2"class="form-control" placeholder="Room Rate Code Single">
                                        <span class="text-danger">
                                            @error('room_type_af2')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">

                                        Service charge<input type="text"
                                            name ="room_type_af3"class="form-control" placeholder="Room Rate Code Double">
                                        <span class="text-danger">
                                            @error('room_type_af3')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    {{-- <div style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">

                                        Room Rate Code Triple <input type="text"
                                            name ="room_type_af4"class="form-control" placeholder="Room Rate Code Triple">
                                        <span class="text-danger">
                                            @error('room_type_af4')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div> --}}
                                    {{-- <div style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">

                                        Room Rate Code Qued <input type="text" name ="room_type_af5"class="form-control"
                                            placeholder="Room Rate Code Qued">
                                        <span class="text-danger">
                                            @error('room_type_af5')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
 --}}

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $('#myModal').on('shown.bs.modal', function() {
                    $('#myModal').trigger('focus');
                });
            </script>




            {{-- data table start  --}}
            <div class="card-body table-scrollable">
                <table class="table table-striped" id="remindtable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col"> Service Type </th>
                            <th scope="col"> Pacakage </th>
                            <th scope="col"> GST % </th>
                            <th scope="col"> Labour charge </th>
                            <th scope="col"> Dis % </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Type Code
                            </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Code
                                Single </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Single
                            </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Code
                                Double </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Double
                            </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Code
                                Triple </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Triple
                            </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Code
                                Quad </th>
                            <th style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">Room Rate Quad
                            </th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $r1 = 0;
                        @endphp
                        @foreach ($data2 as $record2)
                            <tr>

                                <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                                <td>{{ $record2['roomtype_name'] }}</td>
                                <td>{{ $record2->package->package_name }}</td>
                                <td>{{ $record2->gstmaster->taxname }}</td>
                                <td>{{ $record2['room_tariff'] }}</td>
                                <td>{{ $record2['room_dis'] }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af1 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af2 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af3 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af4 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af5 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af6 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af7 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af8 }}</td>
                                <td style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}">
                                    {{ $record2->room_type_af9 }}</td>




                                <td>
                                    <a href="{{ route('roomtypes.edit', $record2['id']) }}" class="btn  btn-sm"><i
                                            class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                                </td>


                                <td>
                                    <form action="{{ route('roomtypes.destroy', $record2['id']) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn  btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this roomtype?')"><i
                                                class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
    new DataTable('#remindtable', {
        pageLength: 10,
        responsive: true,
        ordering: true,
        language: {
            search: "🔍 Search Service:",
            lengthMenu: "Show _MENU_ services",
            info: "Showing _START_ to _END_ of _TOTAL_ services"
        }
    });
});

    </script>
@endsection
