@extends('layouts.blank')

@section('pagecontent')

{{-- ================= DATATABLE CSS ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<div class="container-fluid mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Cresher Challan List
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ACTION BAR --}}
        <div class="card-footer d-flex justify-content-between align-items-center">

            {{-- @can('delete user')
            <form action="{{ route('crusher.destroy', 'all') }}"
                  method="POST"
                  onsubmit="return confirm('⚠️ Are you sure you want to DELETE ALL challans? This cannot be undone!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    🗑️ Delete All
                </button>
            </form>
            @endcan --}}

            <a href="{{ route('crusher.create') }}" class="btn btn-success">
                + Add New Challan
            </a>
        </div>

        {{-- TABLE --}}
        <div class="card-body">
            <div class="table-responsive">
                <table id="crusherTable"
                       class="table table-bordered table-striped table-hover align-middle text-center"
                       style="width:100%">
                    <thead class="table-dark">
                        <tr>  
                            <th>#</th>
                            <th>Slip No</th>
                              <th>RST No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Vehicle No</th>
                            <th>Party Name</th>

                            @can('view user')
                                <th>Vehicle Measure</th>
                                <th>Material</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                 <th> Material Total</th>
                                 <th>Royalty Quantity</th>
                                 <th>Royalty Rate</th>
                                <th>Royalty Total</th>
                                   <th>Grand Total</th>
                                  <th>Material Remark</th>
                                <th>Remarks</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Image</th>
                            @endcan

                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($creshers as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->slip_no }}</td>
                                   <td>{{ ($item->af7)}}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->time)->format('h:i A') }}</td>
                            <td>{{ $item->vehicle_no }}</td>
                            <td>{{ $item->party_name }}</td>

                            @can('view user')
                                <td>{{ $item->vehicle_measure }}</td>
                                 <td>{{ $item->Material }}</td>
                               
                               
                                <td>{{ $item->Quantity }}</td>
                                <td>{{ number_format($item->Rate, 2) }}</td>
                                 <td>{{ number_format($item->Total, 2) }}</td>
                                <td>{{ number_format($item->Royalty_Quantity, 2) }}</td>
                               <td>{{ number_format($item->Royalty_Rate, 2) }}</td>
                                  <td>{{ number_format($item->Royalty, 2) }}</td>
                                     <td>{{ number_format($item->af8, 2) }}</td>
                                     <td>{{ $item->Materialremark }}</td>
                                <td>{{ $item->remark }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    @if($item->pic)
                                        <img src="{{ asset('storage/app/public/account_image/'.$item->pic) }}"
                                             width="45" height="45"
                                             style="border-radius:8px; object-fit:cover;">
                                    @endif
                                </td>
                            @endcan

                            <td>
                                <div class="d-flex justify-content-center gap-1">

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

                                    @can('delete user')
                                    <form action="{{ route('crusher.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this challan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ================= DATATABLE JS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    $('#crusherTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        responsive: true,
        autoWidth: false,
        dom: 'Bfltip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm' },
            { extend: 'print', className: 'btn btn-primary btn-sm' }
        ]
    });
});
</script>

@endsection
