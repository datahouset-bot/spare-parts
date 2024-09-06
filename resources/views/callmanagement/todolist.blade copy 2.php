@extends('layouts.blank')
@section('pagecontent')

<div class="container my-2">
  <div class="card">
          <h5 class="card-header">Featured</h5>
    <div class="card-body">
              <div class="row my-2 form-group ">
                  <div class="col-md-3  col-sm-12 my-2 ">
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-md-3  col-sm-12 my-2 ">
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-md-3  col-sm-12 my-2 ">
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-md-3  col-sm-12 my-2 ">
                    <input type="text" class="form-control">
                  </div>
              </div>



              
    
  </div>
  
  <div class="row my-2  mx-2 form-group ">
    <div class="col-md-3  col-sm-12 my-2 ">
      <input type="text" class="form-control">
    </div>
    <div class="col-md-3  col-sm-12 my-2 ">
      <input type="text" class="form-control">
    </div>
    <div class="col-md-3  col-sm-12 my-2 ">
      <input type="text" class="form-control">
    </div>
    <div class="col-md-3  col-sm-12 my-2 ">
      <input type="text" class="form-control">
    </div>
  </div>   
</div>   

  <div class="row my-2 ">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Product</th>
              <th>Qty</th>
              <th>Rate</th>
              <th>S.No</th>
              <th>Product</th>
              <th>Qty</th>
              <th>Rate</th>

              <th>S.No</th>
              <th>Product</th>
              <th>Qty</th>
              <th>Rate</th>

            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>pen</td>
              <td>20</td>
              <td>50</td>
              <td>1</td>
              <td>pen</td>
              <td>20</td>
              <td>50</td>

              <td>1</td>
              <td>pen</td>
              <td>20</td>
              <td>50</td>

            </tr>
            <!-- Additional rows here -->
          </tbody>
        </table>
      </div>



</div>




@endsection