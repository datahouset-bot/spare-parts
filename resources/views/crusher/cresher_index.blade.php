@extends('layouts.blank')

@section('pagecontent')
<div class="container-fluid mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Cresher Challan List
        </div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
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
                            <th>Vehicle Measure</th>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Royalty</th>
                            <th>Total</th>
                            <th>Phone</th>
                            {{-- <th>Image</th> --}}
                            <th>Action</th>
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
                            <td>{{ $item->vehicle_measure }}</td>
                            <td>{{ $item->Material }}</td>
                            <td>{{ $item->Quantity }}</td>
                            <td>{{ number_format($item->Rate, 2) }}</td>
                            <td>{{ number_format($item->Royalty, 2) }}</td>
                            <td>{{ number_format($item->Total, 2) }}</td>
                            <td>{{ $item->phone }}</td>

                            {{-- <td>
                                @if($item->pic)
                                    <a href="{{ asset('storage/'.$item->pic) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$item->pic) }}"
                                             width="40" height="40"
                                             style="border-radius:6px;">
                                    </a>
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td> --}}
                            <td>
 <a href="{{ route('crusher.show', $item->id) }}"
       class="btn btn-sm btn-info text-white">
        View
    </a>

    <!-- ✅ Edit Button -->
    <a href="{{ route('crusher.edit', $item->id) }}"
       class="btn btn-sm btn-primary">
        Edit
    </a>

    <!-- ✅ Delete Button -->
    <form action="{{ route('crusher.destroy', $item->id) }}"
          method="POST"
          style="display:inline-block;"
          onsubmit="return confirm('Are you sure you want to delete this challan?')">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-sm btn-danger">
            Delete
        </button>
    </form>
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
