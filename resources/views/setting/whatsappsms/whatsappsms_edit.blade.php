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

<div class="container mt-4">
  @if(session('message'))
    <div class="alert alert-primary">{{ session('message') }}</div>
  @endif

  <div class="card p-4">
    <form action="{{ route('whatsapp_sms.update', $WhatsappSms->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row mb-3">
        <!-- Voucher Type -->
        <div class="col-md-4">

          <label for="transection_type" class="form-label">Voucher Type</label>
          <input type="text" class="form-control"  name="transection_type" value="{{ $WhatsappSms->transection_type }}" readonly >  
            <!-- Add more options here -->
        </div>

        <!-- Activate WhatsApp -->
    <div class="col-md-4 d-flex align-items-center">
  <div class="form-check mt-3">
    <!-- Hidden input ensures 0 is sent when checkbox is unchecked -->
    <input type="hidden" name="wp_active" value="0">
    
    <input type="checkbox" name="wp_active" class="form-check-input" id="wp_active" value="1"
      {{ $WhatsappSms->wp_active == 1 ? 'checked' : '' }}>
      
    <label class="form-check-label" for="wp_active">Activate WhatsApp</label>
  </div>
</div>


      <!-- WhatsApp Message Textarea -->
      <div class="mb-3">
        <label for="wp_message" class="form-label">WhatsApp Message</label>
        <textarea id="wp_message" name="wp_message" class="form-control" rows="10" style="min-height: 250px; font-size: 16px;">{{ old('wp_message', $WhatsappSms->wp_message) }}</textarea>
        <span class="text-danger">
          @error('wp_message') {{ $message }} @enderror
        </span>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
      </div>
    </form>
  </div>
</div>

@endsection
