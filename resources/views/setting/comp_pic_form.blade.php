
@extends('layouts.blank')
@section('pagecontent')
<style>
/* ================= PAGE BG ================= */
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* ================= CARD ================= */
.card {
    border-radius: 18px;
    border: none;
    box-shadow: 0 14px 40px rgba(0,0,0,.12);
    animation: fadeUp .35s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ================= HEADER ================= */
.card-header {
    background: linear-gradient(135deg, #4338ca, #1e3a8a);
    color: #fff;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
    border-radius: 18px 18px 0 0;
}

/* ================= TABLE ================= */
.table {
    border-collapse: separate;
    border-spacing: 0 10px;
}

.table thead th {
    background: #1e293b;
    color: #fff;
    font-weight: 600;
    border: none;
    text-align: center;
}

.table tbody tr {
    background: #ffffff;
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
    border-radius: 12px;
}

.table tbody td,
.table tbody th {
    vertical-align: middle;
    text-align: center;
    border: none;
}

/* ================= IMAGE PREVIEW ================= */
.preview-box {
    background: #f8fafc;
    border: 2px dashed #c7d2fe;
    border-radius: 12px;
    padding: 8px;
}

.preview-box img {
    max-height: 120px;
    object-fit: contain;
    transition: transform .25s ease;
}

.preview-box img:hover {
    transform: scale(1.05);
}

/* ================= FILE INPUT ================= */
.form-control[type="file"] {
    border-radius: 10px;
    border: 2px solid #c7d2fe;
}

.form-control[type="file"]:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,.25);
}

/* ================= BUTTON ================= */
.btn-primary {
    border-radius: 22px;
    font-weight: 600;
    padding: 6px 14px;
    transition: all .25s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,.45);
}

.btn-dark {
    border-radius: 22px;
    padding: 6px 18px;
}

/* ================= FOOTER ================= */
.card-footer {
    background: #f1f5f9;
    border-radius: 0 0 18px 18px;
}
</style>

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
    <div class="preview-box">
        <img src="{{ asset('storage/app/public/image/'.$comppic->logo) }}">
    </div>
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
  <button type="submit" class="btn btn-primary">
    ⬆ Upload
</button>

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



<tr>
    <form action="{{ url('/comp_pic_af1') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">6</th>
    <td>Web Image 1</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->pic_af1) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_pic_af1" type="file" name="comp_pic_af1" value="" multiple />
<span class="text-danger">
@error('comp_pic_af1')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload web Image1</button>
</div></td></tr> </form>


<tr>
    <form action="{{ url('/comp_pic_af2') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">7</th>
    <td>Web Image 2</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->pic_af2) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_pic_af2" type="file" name="comp_pic_af2" value="" multiple />
<span class="text-danger">
@error('comp_pic_af2')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload Web Image2</button>
</div></td></tr> </form>

<tr>
    <form action="{{ url('/comp_pic_af3') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">8</th>
    <td>Web Image 3</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->pic_af3) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_pic_af3" type="file" name="comp_pic_af3" value="" multiple />
<span class="text-danger">
@error('comp_pic_af3')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload Webimage3</button>
</div></td></tr> </form>

<tr>
    <form action="{{ url('/comp_pic_af4') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">9</th>
    <td>Web Image 4</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->pic_af4) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_pic_af4" type="file" name="comp_pic_af4" value="" multiple />
<span class="text-danger">
@error('comp_pic_af4')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload Web Image4</button>
</div></td></tr> </form>

<tr>
    <form action="{{ url('/comp_pic_af5') }}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('put') 

    <th scope="row">10</th>
    <td>Google Map 5</td>
    <td><img src="{{ asset('storage\app\public\image\\' . $comppic->pic_af5) }}" alt="" width="130px"></td>

<td><div class="form-floating mb-2 mb-md-2">
<input class="form-control" id="comp_pic_af5" type="file" name="comp_pic_af5" value="" multiple />
<span class="text-danger">
@error('comp_pic_af5')
{{ $message }}
@enderror
</span>
</div>
</td>
<td> <div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">Upload Google Map</button>
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