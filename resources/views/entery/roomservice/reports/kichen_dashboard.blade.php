@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">
    <div class="row justify-content-center">
        <style>
            th, td {
                padding: 4px;
                text-align: left;
            }
            .card {
                padding: 0;
                margin: 0 8px;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
            }
            .card-header {
                background-color: #f8f9fa;
                padding: 8px;
                border-bottom: 1px solid #dee2e6;
            }
            .card-body {
                padding: 8px;
            }
            .table {
                margin-bottom: 0;
            }
            .inline-form {
    display: inline-block;
    margin-right: 5px; /* Adjust spacing between buttons */
}

        </style>
        <div class="col-md-6 mt-1">
            @if (isset($message))
                <div class="alert alert-info">{{ $message }}</div>
            @endif
        </div>
    </div>

    <h5>KOT Items</h5>
    <div class="row">
        @foreach($pending_kot_items as $voucher_no => $items)
            @php
                $firstItem = $items->first();
                $service_ids=$firstItem->service_id;
                $createdTime = \Carbon\Carbon::parse($firstItem->created_at);
                $currentTime = \Carbon\Carbon::now();
                $timeDifferenceInSeconds = $createdTime->diffInSeconds($currentTime);
            @endphp
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">
                            Kot No: {{ $voucher_no }}, <span id="timer-{{ $voucher_no }}"></span>
                        </h6>

                    </div>

                    <div class="card-body">
                        <h6>
 
                            Room No:{{$service_ids}}||
                            Total Qty:{{$firstItem->total_qty}}||
                            Remark: {{ $firstItem->kot_remark }}||
                            Waiter: {{ $firstItem->user_name }}||Total Qty:{{ $firstItem->total_qty }}
                        </h6>
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>QTY</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->qty }}</td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
<table>
    <tbody>
        <tr>
            <td>  <form action="{{ url('/readytoserve') }}" method="POST">
                @csrf
                <input type="hidden" name="kot_voucher_no" value="{{ $voucher_no }}">
                <button type="submit" class="btn btn-success">Ready To Serve</button>
            </form></td>
        <td> <form action="{{ url('/readytoserve_print') }}" method="POST">
            @csrf
            <input type="hidden" name="kot_voucher_no" value="{{ $voucher_no }}">
            <button type="submit" class="btn btn-warning">Serve & Print</button>
        </form></td>
        </tr>
    </tbody>
</table>
                        
                        
                         
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    let timer{{ $voucher_no }} = {{ $timeDifferenceInSeconds }};
                    setInterval(() => {
                        let hours = Math.floor(timer{{ $voucher_no }} / 3600);
                        let minutes = Math.floor((timer{{ $voucher_no }} % 3600) / 60);
                        let seconds = timer{{ $voucher_no }} % 60;
                        document.getElementById('timer-{{ $voucher_no }}').innerText = `(${hours}h ${minutes}m ${seconds}s)`;
                        timer{{ $voucher_no }}++;
                    }, 1000);
                });
            </script>
            @if(($loop->iteration % 4) == 0)
                </div><div class="row">
            @endif
        @endforeach
    </div>
</div>

<script>
    // Reload the page every 30 seconds (30000 milliseconds)
    setTimeout(function() {
        location.reload();
    }, 60000); // 60 seconds
</script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>
@endsection
