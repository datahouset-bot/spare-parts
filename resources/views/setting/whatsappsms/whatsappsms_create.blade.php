@extends('layouts.blank')
@section('pagecontent')

<!-- Styles & Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="jquery/master.js"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
  });
</script>

<div class="container">
  @if(session('message'))
    <div class="alert alert-primary">{{ session('message') }}</div>
  @endif

  <div class="card row p-3">
    <form action="{{ route('whatsapp_sms.store') }}" method="POST" class="row g-3 align-items-end">
      @csrf

      <!-- Voucher Type -->
      <div class="col-md-2">
        <label for="transection_type">Select Voucher Type</label>
        <select name="transection_type" id="transection_type" class="form-select">
          <option value="" selected disabled>Select Voucher Type</option>
          @foreach ($voucher_type as $record)
<option value="{{ $record->voucher_type_name }}_store">{{ $record->voucher_type_name }}_store</option>
    <option value="{{ $record->voucher_type_name }}_update">{{ $record->voucher_type_name }}_update</option>
    <option value="{{ $record->voucher_type_name }}_delete">{{ $record->voucher_type_name }}_delete</option>          @endforeach
        </select>
      </div>

      <!-- WhatsApp Activation -->
      <div class="col-md-1">
        <div class="form-check">
          <input type="checkbox" name="wp_active" class="form-check-input" id="wp_active" value="1">
          <label class="form-check-label" for="wp_active">Activate WhatsApp</label>
        </div>
      </div>

      <!-- WhatsApp Message Input -->
      <div class="col-md-7">
    <label for="wp_message" class="form-label">WhatsApp Message</label>
    <textarea id="wp_message" name="wp_message" class="form-control" rows="30" style="min-height: 250px; font-size: 16px;" placeholder="WhatsApp Message"></textarea>
    <span class="text-danger">
        @error('wp_message') {{ $message }} @enderror
    </span>
</div>



      <!-- Buttons -->
      <div class="col-12 text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>


@endsection
