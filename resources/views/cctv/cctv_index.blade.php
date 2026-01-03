@extends('layouts.blank')

@section('pagecontent')

<div class="container-fluid mt-3">

    @if(session('success'))
        <div class="alert alert-success text-center fw-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            CCTV Visit List
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>CSR</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Problem</th>
                        <th>Status</th>
                        <th>Equipment</th>
                        <th>Service Rendered</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($visits as $i => $visit)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $visit->date }}</td>
                            <td>{{ $visit->csr }}</td>
                            <td>{{ $visit->customer_name }}</td>
                            <td>{{ $visit->product }}</td>
                            <td>{{ $visit->problem }}</td>
                            <td>{{ $visit->call_status }}</td>
                            <td>{{ $visit->equipment_type }}</td>
                            <td>{{ $visit->rendered }}</td>
                            <td>
                                <!-- PRINT -->
                                <a href="{{ route('cctv.show', $visit->id) }}"
                                   class="btn btn-sm btn-success"
                                   target="_blank">
                                    Print
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('cctv.destroy', $visit->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted fw-bold">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
