@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Cresher Challan List
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Slip No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Vehicle No</th>
                            <th>Party</th>
                            <th>Vehicle Name</th>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Royalty</th>
                            <th>Phone</th>
                            <th>Image</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($creshers as $key => $item)
                        <tr class="text-center">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->slip_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                            <td>{{ $item->time }}</td>
                            <td>{{ $item->vehicle_no }}</td>
                            <td>{{ $item->party_name }}</td>
                            <td>{{ $item->Vehicle_name }}</td>
                            <td>{{ $item->Material }}</td>
                            <td>{{ $item->Quantity }}</td>
                            <td>{{ number_format($item->Royalty, 2) }}</td>
                            <td>{{ $item->phone }}</td>

                            <td>
                                @if($item->pic)
                                    <a href="{{ asset('storage/'.$item->pic) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$item->pic) }}"
                                             width="40" height="40"
                                             style="border-radius:6px;">
                                    </a>
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">
                                No Cresher Records Found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('crusher.create') }}" class="btn btn-success">
                + Add New Challan
            </a>
        </div>
    </div>

</div>
@endsection
