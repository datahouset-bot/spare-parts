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
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
            animation: fadeUp 0.6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== HEADER ===== */
        .card-header {
            background: linear-gradient(135deg, #4f46e5, #1e3a8a);
            color: #fff;
            border-radius: 18px 18px 0 0;
            padding: 18px;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            border-radius: 25px;
            font-weight: 600;
            padding: 8px 18px;
            transition: all .25s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
        }

        .btn-info {
            border-radius: 25px;
        }

        /* ===== TABLE ===== */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: #eef2ff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 13px;
        }

        .table tbody tr {
            transition: all .25s ease;
        }

        .table tbody tr:hover {
            background: #f1f5ff;
            transform: scale(1.01);
        }

        /* ===== ICONS ===== */
        .fa-edit,
        .fa-trash {
            transition: transform .2s ease, color .2s ease;
        }

        .fa-edit:hover {
            transform: scale(1.2);
            color: #4f46e5 !important;
        }

        .fa-trash:hover {
            transform: scale(1.2);
            color: #dc2626 !important;
        }

        /* ===== MODAL ===== */
        .modal-content {
            border-radius: 16px;
            animation: zoomIn .3s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #6366f1, #1e3a8a);
            color: #fff;
            border-radius: 16px 16px 0 0;
        }

        /* ===== INPUT ===== */
        .form-control {
            border-radius: 10px;
            border: 2px solid #c7d2fe;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .25);
        }

        /* ===== DATATABLE SEARCH ===== */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 20px;
            padding: 6px 14px;
        }

        /* ===== ACTION BAR ===== */
        .action-bar {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 14px 0;
        }
    </style>

    <div class="container-fluid ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="card my-3">
            <div class="card-header">
                <h3> Item Group List </h3>
            </div>

            <div class="action-bar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    <i class="fa fa-plus"></i> Add Item Group
                </button>

                <button class="btn btn-info">
                    <i class="fa fa-download"></i> Export
                </button>
            </div>


            <div class="container mt-5">


                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/itemgroups') }}" method="POST">
                                    @csrf
                                    <div>

                                        Item Group Name <input type="text" name ="item_group"class="form-control"
                                            placeholder="Item Group / Category" autocomplete="off">
                                        <span class="text-danger">
                                            @error('item_group')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <!--  <div class="col-md-12 mt-2">-->
                                    <!--    <div class="form-floating mb-3 mb-md-0">-->

                                    <!--      <select name="head_group" Id ="head_group"class="form-select" aria-label="Default select example">-->
                                    <!--        <option selected disabled>Select Head Group </option>-->

                                    <!--        <option value="Spare_parts">Spare_parts</option>-->
                                    <!--        <option value="labour">labour</option>       -->
                                    <!--        <option value="Bike">Bike</option>-->
                                    <!--        <option value="Car">Car</option>-->
                                    <!--        {{-- <option value="Laundry">Laundry</option>   --}}-->
                                    <!--        <option value="Other">Other</option>-->



                                    <!--      </select>-->
                                    <!--        <label for="head_group">Head Group  </label>-->

                                    <!--    </div>-->
                                    <!--    <span class="text-danger"> -->
                                    <!--      @error('head_group')
        -->
                                        <!--      {{ $message }}-->

                                        <!--
    @enderror-->
                                    <!--    </span>-->

                                    <!--</div>    -->

                                    <!--</div>-->
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
                            <th scope="col"> Item Group </th>
                            {{-- <th scope="col"> Item  Head Group  </th> --}}
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $r1 = 0;
                        @endphp
                        @foreach ($data as $record)
                            <tr>
                                {{-- <th scope="row">{{$record['id']}}</th> --}}
                                <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                                <td>{{ $record['item_group'] }}</td>
                                {{-- <td>{{$record['head_group']}}</td> --}}


                                <td><a href="{{ 'showediteditemgroups/' . $record['id'] }}"><i class="fa fa-edit"
                                            style="font-size:20px;color:SlateBlue"></i></a></td>
                                <td><a href="{{ 'deleteitemgroups/' . $record['id'] }}"><i class="fa fa-trash"
                                            style="font-size:20px;color:OrangeRed"></i></a></td>
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
        lengthMenu: [10, 25, 50],
        ordering: true,
        responsive: true,
        language: {
            search: "🔍 Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ groups"
        }
    });
});

    </script>
@endsection
