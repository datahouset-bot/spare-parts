@extends('layouts.blank')
@section('pagecontent')

<div class="container mt-4">
    <h4 class="text-center text-primary">Shift KOTs from One Table to Another</h4>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('shift_table_action') }}">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <label for="from_table">Select From Table</label>
                <select name="from_table" id="from_table" class="form-control" required>
                    <option value="">-- Select Source Table --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->table_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="to_table">Select To Table</label>
                <select name="to_table" id="to_table" class="form-control" required>
                    <option value="">-- Select Destination Table --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->table_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Shift Now</button>
            </div>
        </div>
    </form>
</div>

@endsection
