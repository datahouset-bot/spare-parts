@extends('layouts.blank')

@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('jquery/master.js') }}"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    new DataTable('#remindtable');
  });
</script>

<div class="container">
  @if(session('message'))
    <div class="alert alert-primary">{{ session('message') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card my-3">
    <div class="card-header">Item Group Modify</div>
    <div class="card">
      <div class="modal-body">
        <form action="{{ url('/itemgroups/' . $record->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div>
            Item Group Name
            <input type="text" name="item_group" class="form-control" value="{{ old('item_group', $record->item_group) }}" autocomplete="off">
            <span class="text-danger">@error('item_group') {{ $message }} @enderror</span>
          </div>

          <div class="col-md-12 mt-2">
            <div class="form-floating mb-3 mb-md-0">
              <select name="head_group" id="head_group" class="form-select">
                <option disabled>Select Head Group</option>
                @foreach(['Restaurant_Item', 'Raw_Material', 'Non_Consumable', 'Consumable', 'Laundry', 'Other'] as $group)
                  <option value="{{ $group }}" {{ $record->head_group === $group ? 'selected' : '' }}>{{ $group }}</option>
                @endforeach
              </select>
              <label for="head_group">Head Group</label>
            </div>
            <span class="text-danger">@error('head_group') {{ $message }} @enderror</span>
          </div>

          <div class="modal-footer">
            <a href="{{ url('/itemgroups') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
