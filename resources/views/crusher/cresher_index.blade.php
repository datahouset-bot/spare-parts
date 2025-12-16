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
                            @can('view user')
                                  <th>Vehicle Measure</th>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Royalty</th>
                            <th>Total</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Remarks</th>
                            <th>Image</th>
                            @endcan
                          
                            <th >Action</th>
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
                            @can('view user')
                                  <td>{{ $item->vehicle_measure }}</td>
                            <td>{{ $item->Material }}</td>
                            <td>{{ $item->Quantity }}</td>
                            <td>{{ number_format($item->Rate, 2) }}</td>
                            <td>{{ number_format($item->Royalty, 2) }}</td>
                            <td>{{ number_format($item->Total, 2) }}</td>
                              <td>{{ $item->address }}</td>
                            <td>{{ $item->phone }}</td>              
                            <td>{{ $item->remark }}</td>

<td>
    @if($item->pic)
        <a href="{{ asset('uploads/crusher/'.$item->pic) }}" target="_blank">
            <img src="{{ asset('uploads/crusher/'.$item->pic) }}"
                 width="40" height="40"
                 style="border-radius:6px; object-fit:cover;">
        </a>
    @else
        <span class="text-muted">No Image</span>
    @endif
</td>
                            @endcan
                          
      <td class="text-center">
    <div class="d-flex justify-content-center gap-2">

        <!-- View -->
        <a href="{{ route('crusher.show', $item->id) }}"
           class="btn btn-sm btn-info text-white">
            View
        </a>
@can('update user')
      <a href="{{ route('crusher.edit', $item->id) }}"
           class="btn btn-sm btn-primary">
            Edit
        </a>
@endcan
        <!-- Edit -->
      
@can('delete user')
    

        <!-- Delete -->
        <form action="{{ route('crusher.destroy', $item->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this challan?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>
        </form>
@endcan
    </div>
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
<div class="card-footer d-flex justify-content-between align-items-center">
@can('delete user')
     {{-- 🔴 DELETE ALL --}}
    <form action="{{ route('crusher.destroy', 'all') }}"
          method="POST"
          onsubmit="return confirm('⚠️ Are you sure you want to DELETE ALL challans? This cannot be undone!')">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">
            🗑️ Delete All
        </button>
    </form>

@endcan
   
    {{-- ✅ ADD NEW --}}
    <a href="{{ route('crusher.create') }}" class="btn btn-success">
        + Add New Challan
    </a>

</div>

</div>
    

</div>
@endsection
