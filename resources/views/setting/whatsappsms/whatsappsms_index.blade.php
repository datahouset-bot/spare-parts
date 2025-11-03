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
<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        WhatsApp SMS Setting
        </div>
       <div class="row my-2">
<div class="col-md-12 text-center">
  <a href="{{ route('whatsapp_sms.create') }}" class="btn btn-primary">
    Add New WhatsApp Message
  </a>
<a href="{{ url('send_promotional_whatsapp') }}" class="btn btn-success">
  Send Promotional WhatsApp
</a>

</div>
        
          <div class="container mt-5">
            
    
            

           
        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });


        </script>
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Type  </th>
                    <th scope="col"> Voucher Type </th>
                    <th scope="col"> Message </th>
                    <th scope="col"> Active </th>

                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($WhatsappSms as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    @if ($record->wp_message)
                    <td>WhatsApp</td>
                        
                    @endif

                    <td>{{$record->transection_type}}</td>
                    <td>{{$record->wp_message}}</td>
                   
                    @if ($record->wp_active==1)
                      <td>On</td>
                    @else
                      <td>Off</td>
                    @endif



                    
                  <td>
                      <a href="{{ route('whatsapp_sms.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('whatsapp_sms.destroy', $record['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this package?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                      </form>
                  </td>
                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection
