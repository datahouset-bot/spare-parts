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
    <div class="container ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('errors'))
        <div class="alert alert-danger">
            {{ session('errors') }}
        </div>
    @endif


        <div class="card my-3">
            <div class="card-header">
                Food Bill
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center">


                    <a href="{{ route('foodbills.create') }}" class="btn btn-primary">New Food Bill</a>

                </div>
            </div>







            {{-- data table start  --}}
            <div class="card-body table-scrollable">
                <table class="table table-striped" id="remindtable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col"> Date </th>
                            <th scope="col"> Bill No </th>
                            <th scope="col"> Service On </th>
                            <th scope="col">Guest Name</th>
                            <th scope="col"> Total Qty </th>
                            <th scope="col"> Total Amount </th>
                            <th scope="col"> Status </th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $r1 = 0;
                        @endphp
                        @foreach ($foodbills as $record)
                            <tr>

                                <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                                <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}
                                </td>
                                <td>{{ $record['food_bill_no'] }}</td>
                                @php
                                $service_id = $record['service_id'];
                                $result_checkin = collect($roomcheckins)->firstWhere('voucher_no', $service_id);
                            @endphp
                          

                                <td>{{ $record['service_id'] }}</td>
                                @php
                                if ($result_checkin != "") {
                                    echo "<td>{$result_checkin->guest_name} || {$result_checkin->room_no}</td>";
                                } else {
                                    echo "";
                                }
                            @endphp
                            
                                 
                                <td>{{ $record['total_qty'] }}</td>
                                <td>{{ $record['total_bill_value'] }}</td>
                                <td>{{ $record['status'] }}</td>




                                <td>
                                    <a href="{{ url('foodbill_print_view', $record['voucher_no']) }}"
                                        class="btn btn-sm">
                                        <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                                    </a>

                                </td>

                                <td>
                                    <a href="{{ url('foodbill_print_view', $record['voucher_no']) }}"
                                        class="btn  btn-sm"><i class="fa fa-eye"
                                            style="font-size:20px;color:SlateBlue"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('foodbills.edit', $record['voucher_no']) }}"
                                        class="btn  btn-sm"><i class="fa fa-edit"
                                            style="font-size:20px;color:SlateBlue"></i></a>
                                </td>


                                <td>
                                    <form action="{{ route('foodbills.destroy', $record['voucher_no']) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn  btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this  Record ?')"><i
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
@endsection
