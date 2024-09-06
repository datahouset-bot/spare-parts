<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    {{-- <script src="jquery/master.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    

<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
         Unit  List 
        </div>

       <div class="row my-2">
        <div class="col-md-6 text-center">
          <select id="unit_dropdown" class="js-states form-control">
            <option value="" disabled selected>Select Account</option>
            @foreach ($data as $record)
     
                <option value={{ $record['id'] }}>
                  {{$record['primary_unit_name']}} </option>
            @endforeach
  
        </select>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New Unit
      </button>
          <button class="btn btn-info mx-2">Export</button>
        </div>
        <div class="col-md-6 text-center">
      <input type="text" placeholder="Remark 1"  name ="remark1"value="{{old('remark1')}}"> 
        </div>
      </div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">+

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          {{-- <form  action="{{url('/units')}}" method="POST"> --}}
                            <form  id="unit_form">
   
                            <div>

                           Primary Unit Name   <input type="text" name ="primary_unit_name" id ="primary_unit_name"class="form-control primary_unit_name" placeholder="Primary Unit Name ">
                            <span class="text-danger"> 
                              @error('primary_unit_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            Conversion  <input type="text" name ="conversion" id ="conversion"class="form-control" placeholder="Conversion ">
                            <span class="text-danger"> 
                              @error('conversion')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            Alternate Unit Name   <input type="text" name ="alternate_unit_name" id ="alternate_unit_name"class="form-control" placeholder="Alternate Unit Name">
                            <span class="text-danger"> 
                              @error('alternate_unit_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          
                          <div class="col-md-12 mt-2">
                        
                        </div>    

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="save_button" class="btn btn-primary">Save </button>
                          </form>
                         
                          </div>
                    </div>
                </div>
            </div>
        </div>
    
        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });
        </script>
    



          {{-- data table start  --}}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $("#unit_dropdown").select2({
        placeholder: "Select Unit ",
        allowClear: true
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '#save_button', function(e) {
      e.preventDefault();
      console.log("hello");
      
      var data = {
        'primary_unit_name': $('.primary_unit_name').val(),
        'conversion': $('#conversion').val(),
        'alternate_unit_name': $('#alternate_unit_name').val(),
      };
      console.log(data);
      
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        type: "POST",
        url: "/unit_store",
        data: data,
        dataType: "json",
        success: function(response) {
          if(response.status == 200) {
            console.log(response.message);
            $('#myModal').find('input').val(''); // Clear input fields
            $('#myModal').modal('hide'); // Hide modal        
          } else {
            console.log(response.errors);
            alert("Validation errors occurred. Check console for details.");
          }
        },
        error: function(response) {
          console.error("An error occurred:", response);
          alert("An error occurred. Check console for details.");
        }
      });
    });

    $('#myModal').on('hidden.bs.modal', function () {
      fetchUnits();
    });

    function fetchUnits() {
      $.ajax({
        type: "GET",
        url: "/fetch_units",
        dataType: "json",
        success: function(data) {
          var options = '';
          $.each(data, function(key, record) {
            options += '<option value="' + record.id + '">' + record.primary_unit_name + '</option>';
          });
          $('#unit_dropdown').html(options); // Update the dropdown with new options
        },
        error: function(response) {
          console.error("An error occurred while fetching units:", response);
          alert("An error occurred. Check console for details.");
        }
      });
    }  


    $('#myModal').on('hidden.bs.modal', function () {
      fetchUnits();
    });

    function fetchUnits() {
      $.ajax({
        type: "GET",
        url: "/fetch_units",
        dataType: "json",
        success: function(data) {
          var options = '';
          $.each(data, function(key, record) {
            options += '<option value="' + record.id + '">' + record.primary_unit_name + '</option>';
          });
          $('#unit_dropdown').html(options); // Update the dropdown with new options
        },
        error: function(response) {
          console.error("An error occurred while fetching units:", response);
          alert("An error occurred. Check console for details.");
        }
      });
    }



  });
</script>




@endsection