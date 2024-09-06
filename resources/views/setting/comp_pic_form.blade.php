
@extends('layouts.blank')
@section('pagecontent')

<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Company / Firm / Business Details </h3></div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <table class="table table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col" width="10%">S.No</th>
                                                        <th scope="col" width="20%">File Name</th>
                                                        <th scope="col" width="30%">Display</th>
                                                        <th scope="col" width="20%">Select jpg/png</th>
                                                        <th scope="col" width="10%">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <form action="{{ url('/comp_pic_store') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                             @method('put') 
                     
                                                        <th scope="row">1</th>
                                                        <td>Logo</td>
                                                        {{-- <td><img src="{{ storage_path('app\public\image\\' . $comppic->logo) }}" alt="" width="130px"></td>
                                                        <img src="{{ asset('storage\image\\'.$comppic->logo) }}" width="130px" height="130px">
                                                       
                                                        --}}
                                                        
                                                        <td>
                                                            <img src="{{ asset('storage\app\public\image\\'.$comppic->logo) }}" width="130px" height="130px">
                                                        
</td>
                                                        
                                                                                                                



    <td><div class="form-floating mb-2 mb-md-2">
        <input class="form-control" id="comp_logo" type="file" name="comp_logo" value="" multiple />
        <span class="text-danger">
            @error('comp_logo')
                {{ $message }}
            @enderror
        </span>
    </div>
</td>
<td> <div class="d-grid">
    <button type="submit" class="btn btn-primary btn-block">Upload Logo</button>
</div></td></tr> </form>
<tr>
    <form action="{{ url('/comp_pic_qrstore') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">2</th>
    <td>QR Code</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->qrcode) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_qr" type="file" name="comp_qr" value="" multiple />
<span class="text-danger">
@error('comp_qr')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload QR</button>
</div></td></tr> </form>

<tr>
    <form action="{{ url('/comp_pic_sealstore') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">3</th>
    <td>Seal</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->seal) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_seal" type="file" name="comp_seal" value="" multiple />
<span class="text-danger">
@error('comp_seal')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload seal</button>
</div></td></tr> </form>


<tr>
    <form action="{{ url('/comp_pic_signaturestore') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">4</th>
    <td>Signature</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->signature) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_signature" type="file" name="comp_signature" value="" multiple />
<span class="text-danger">
@error('comp_signature')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload Signature</button>
</div></td></tr> </form>


<tr>
    <form action="{{ url('/comp_pic_brandstore') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">5</th>
    <td>Brand</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->brand) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_brand" type="file" name="comp_brand" value="" multiple />
<span class="text-danger">
@error('comp_brand')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload Brand</button>
</div></td></tr> </form>


                                                                                                      
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                                   
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a  class= "btn btn-dark  "href={{ url()->previous() }}>Back</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
           
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
   




    
</div>

@endsection