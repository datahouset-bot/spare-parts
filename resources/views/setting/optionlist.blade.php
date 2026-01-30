@extends('layouts.blank')

@section('pagecontent')
<div class="container-fluid px-4">

    {{-- Alerts --}}
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mt-3">

        {{-- Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-cogs me-2"></i> Option Master
            </h5>
        </div>

        {{-- Body --}}
        <div class="card-body">

            {{-- FORM --}}
            <form action="{{ route('optionlists.store') }}" method="POST" class="mb-4">
                @csrf

                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="fw-semibold">Option Type</label>
                        <select name="option_type" class="form-select">
                            <option disabled selected>Select Option Type</option>
                            @foreach ($vouchertype as $record)
                                <option value="{{ $record->voucher_type_name }}">
                                    {{ $record->voucher_type_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('option_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold">Option Name</label>
                        <input type="text" name="option_name" class="form-control" placeholder="Enter Option Name">
                        @error('option_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold">Format Name</label>
                        <input type="text" name="format_name" class="form-control" placeholder="Format Name">
                        @error('format_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>

                </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th>Option Type</th>
                            <th>Option Name</th>
                            <th>Format Name</th>
                            <th width="10%" class="text-center">Edit</th>
                            <th width="10%" class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $r1 = 0; @endphp
                        @foreach ($optionlist as $record)
                            <tr>
                                <td>{{ ++$r1 }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $record->option_type }}
                                    </span>
                                </td>
                                <td>{{ $record->option_name }}</td>
                                <td>{{ $record->format_name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('optionlists.edit', $record->id) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('optionlists.destroy', $record->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this format?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
