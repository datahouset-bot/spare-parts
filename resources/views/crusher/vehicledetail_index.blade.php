@extends('layouts.blank')

@section('pagecontent')
<div class="container-fluid mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Vehicle Detail List
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Vehicle Name</th>
                            <th>Owner Name</th>
                            <th>Vehicle No</th>
                            <th>Vehicle Measure</th>
                            <th>Registration Date</th>
                            <th>Model Year</th>
                            <th>Driver Name</th>
                            <th>Driver Contact</th>
                            <th>Driver Address</th>
                            <th>Insurance</th>
                            <th>PUC</th>
                            <th>Edit</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vehicles as $key => $item)
                        <tr class="text-center">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->vehicle_name }}</td>
                            <td>{{ $item->owner_name }}</td>
                            <td>{{ $item->Vehicle_no }}</td>
                            <td>{{ $item->vehicle_measure }}</td>

                            <td>
                                @if($item->Registration_date)
                                    {{ \Carbon\Carbon::parse($item->Registration_date)->format('d-m-Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $item->model_year }}</td>
                            <td>{{ $item->Driver_name }}</td>
                            <td>{{ $item->Driver_contact }}</td>
                            <td>{{ $item->Driver_address }}</td>
                            <td>{{ $item->Insaurance }}</td>
                            <td>{{ $item->Puc }}</td>
       @can('update user') <td>
     
            
       
    <!-- ✅ Edit Button -->
    <a href="{{ route('vehicledetail.edit', $item->id) }}"
       class="btn btn-sm btn-primary">
        Edit
    </a>
</td> @endcan
<td>
    @can('delete user')
        

    <!-- ✅ Delete Button -->
    <form action="{{ route('vehicledetail.destroy', $item->id) }}"
          method="POST"
          style="display:inline-block;"
          onsubmit="return confirm('Are you sure you want to delete this challan?')">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-sm btn-danger">
            Delete
        </button>
    </form>

    @endcan
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                No Vehicle Records Found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('vehicledetail.create') }}" class="btn btn-success">
                + Add New Vehicle
            </a>
        </div>
    </div>

</div>
@endsection
