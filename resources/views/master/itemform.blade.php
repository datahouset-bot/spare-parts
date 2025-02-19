@php
    include public_path('cdn/cdn.blade.php');
@endphp

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <div class="container ">

        <body class="bg-primary">
        @if (session('message'))
          <div class="alert alert-primary">
              {{ session('message') }}
          </div>
      @endif
      @if (session('error'))
          <div class="alert alert-danger ">
              {{ session('error') }}
          </div>
      @endif

            <div id="layoutAuthentication">
                <div id="layoutAuthentication_content">
                    <main>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="card shadow-lg border-0 rounded-lg mt-1">
                                        <div class="card-header">
                                            <h3 class="text-center font-weight-light my-1">Add Item</h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ url('/saveitem') }}" method="POST" enctype="multipart/form-data">
                                                @csrf


                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="item_name" type="text"
                                                                name="item_name" value="{{ old('item_name') }}" />
                                                            <span class="text-danger">
                                                                @error('item_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="item_name">Item/Product Name</label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="item_barcode" type="text"
                                                                name="item_barcode" value="{{ old('item_barcode') }}" />
                                                            <span class="text-danger">
                                                                @error('item_barcode')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="item_barcode">Barcode No</label>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                      <div class="form-floating mb-3 mb-md-0">
                                                          <select name="company_id" id="mycompany" class="mycompany form-select" aria-label="Default select example">
                                                              <option value="" disabled {{ old('company_id') == '' ? 'selected' : '' }}>Select Company</option>
                                                              @foreach ($companydata as $record)
                                                                  <option value="{{ $record['id'] }}" {{ old('company_id') == $record['id'] ? 'selected' : '' }}>
                                                                      {{ $record['comp_name'] }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                          <span class="text-danger">
                                                              @error('company_id')
                                                                  {{ $message }}
                                                              @enderror
                                                          </span>
                                                      </div>
                                                  </div>
                                                  
                                                    <div class="col-md-3 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            {{-- <select  name ="company_id" id ="mycompany"class="mycompany form-select" aria-label="Default select example">
                                                      <option  value ="" selected disabled>Select Company</option>
                                                    @foreach ($companydata as $record)
                                                      
                                                  
                                                      <option value={{$record['id']}}>{{$record['comp_name']}} </option>
                                                      @endforeach
                                                    </select> --}}
                                                            {{-- <span class="text-danger">
                                                                @error('company_id')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
 --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                      <div class="form-floating mb-3 mb-md-0">
                                                          <select name="group_id" id="myitemgroup" class="myitemgroup form-select" aria-label="Default select example">
                                                              <option value="" disabled {{ old('group_id') == '' ? 'selected' : '' }}>Select group</option>
                                                              @foreach ($itemgroupdata as $record)
                                                                  <option value="{{ $record['id'] }}" {{ old('group_id') == $record['id'] ? 'selected' : '' }}>
                                                                      {{ $record['item_group'] }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                          <span class="text-danger">
                                                              @error('group_id')
                                                                  {{ $message }}
                                                              @enderror
                                                          </span>
                                                      </div>
                                                  </div>
                                                  



                                                    <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="mrp" type="text"
                                                                name="mrp" value="{{ old('mrp') }}" />
                                                            <span class="text-danger">
                                                                @error('mrp')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="mrp">MRP</label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="sale_rate" type="text"
                                                                name="sale_rate" value="{{ old('sale_rate') }}" />
                                                            <span class="text-danger">
                                                                @error('sale_rate')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="sale_rate">Sale Rate</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="sale_rate_a" type="text"
                                                                name="sale_rate_a" value="{{ old('sale_rate_a') }}" />
                                                            <span class="text-danger">
                                                                @error('sale_rate_a')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="sale_rate_a">Rate A</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="sale_rate_b" type="text"
                                                                name="sale_rate_b" value="{{ old('sale_rate_b') }}" />
                                                            <span class="text-danger">
                                                                @error('sale_rate_b')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="sale_rate_b">Rate B</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="sale_rate_c" type="text"
                                                                name="sale_rate_c" value="{{ old('sale_rate_c') }}" />
                                                            <span class="text-danger">
                                                                @error('sale_rate_c')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="sale_rate_c">Rate C</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="purchase_rate" type="text"
                                                                name="purchase_rate"
                                                                value="{{ old('purchase_rate') }}" />
                                                            <span class="text-danger">
                                                                @error('purchase_rate')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="purchase_rate"> Purchase Rate </label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                      <div class="form-floating mb-3 mb-md-0">
                                                          <select name="unit_id" id="unit" class="form-select" aria-label="Default select example">
                                                              <option value="" disabled {{ old('unit_id') == '' ? 'selected' : '' }}>Select Unit</option>
                                                              @foreach ($unit as $unit)
                                                                  <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                                      {{ $unit->primary_unit_name }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                          <label for="unit">Unit</label>
                                                      </div>
                                                      <span class="text-danger">
                                                          @error('unit_id')
                                                              {{ $message }}
                                                          @enderror
                                                      </span>
                                                  </div>
                                                  
                                                  <div class="col-md-2 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select name="item_gst_id" id="item_gst" class="form-select" aria-label="Default select example">
                                                            <option value="" disabled {{ old('item_gst_id') == '' ? 'selected' : '' }}>GST / Tax %</option>
                                                            @foreach ($gstmaster as $gstmaster)
                                                                <option value="{{ $gstmaster->id }}" {{ old('item_gst_id') == $gstmaster->id ? 'selected' : '' }}>
                                                                    {{ $gstmaster->taxname }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="item_gst">GST / Tax %</label>
                                                    </div>
                                                    <span class="text-danger">
                                                        @error('item_gst_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                               
                                                
                                                <div class="col-md-3">
                                                    <label for="item_image_trigger">Item Image</label>
                                                    <input class="form-control" id="item_image_trigger" type="text" readonly
                                                        placeholder="Click to upload or capture"
                                                        data-bs-toggle="modal" data-bs-target="#itemImageUploadModal" />
                                                    <span class="text-danger">
                                                        @error('item_image')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="itemImageUploadModal" tabindex="-1" aria-labelledby="itemImageUploadModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="itemImageUploadModalLabel">Upload Item Image</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Drag and Drop -->
                                                                <div class="mb-3">
                                                                    <label for="item_image" class="form-label">Drag & Drop</label>
                                                                    <div id="itemDropZone"
                                                                        style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                        Drag & drop a file here or click
                                                                    </div>
                                                                </div>
                                                                <!-- Select from Gallery -->
                                                                <div class="mb-3">
                                                                    <label for="item_image" class="form-label">Select from Gallery</label>
                                                                    <input type="file" id="item_image" name="item_image" class="form-control" />
                                                                </div>
                                                                <!-- Webcam Capture -->
                                                                <div class="mb-3">
                                                                    <label for="item_webcam" class="form-label">Capture from Webcam</label>
                                                                    <div>
                                                                        <video id="item_webcam" autoplay style="width: 100%; max-height: 150px;"></video>
                                                                        <button id="itemCaptureBtn" class="btn btn-primary btn-sm mt-2">Capture</button>
                                                                        <canvas id="itemCanvas" style="display: none;"></canvas>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                





                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit"class="btn btn-primary btn-block">Save</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a class= "btn btn-dark  "href={{ url('item') }}>Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>





    <div class="card my-3">
        <div class="card-header">
            Item List
        </div>
        <div class="row ">

            <div class="card-body">

            </div>
        </div>
        {{-- <script>
    $('.myitemgroup').chosen();
    $('.mycompany').chosen();
</script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script>
            $("#mycompany").select2({
                placeholder: "Select Item Company",
                allowClear: true
            });
            $("#myitemgroup").select2({
                placeholder: "Select Item Group",
                allowClear: true
            });
        </script>


        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

        <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
    @endsection
