@extends('layouts.blank')

@section('pagecontent')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
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
                                        <h3 class="text-center font-weight-light my-1">Business Setting</h3>
                                    </div>
                                    <div class="card-body">

                                        <form action="{{ route('businesssettings.update', 1) }}" method="POST">
                                            @csrf
                                            @method('PUT')


                                            <div class="row mb-3 align-items-center">
                                                <div class="col-md-6">
                                                    <input type="text"  class="form-control" value="Calculation Type" readonly>
                                                </div>
                                                <div class="col-md-6">

                                                    <select name="calculation_type" class="form-select">

                                                        <option value="24hour" selected>24hour</option>
                                                        <option value="12hour">12hour</option>
                                                        
                                                    </select>
                                                    <span class="text-danger"> 
                                                        @error('option_type')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" value="standard_checkout_time" readonly>
                                                    <span class="text-danger"> 
                                                        @error('standard_checkout_time')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="time" name="standard_checkout_time"  class="form-control" required >
                                                    <span class="text-danger"> 
                                                        @error('std_checkout_time')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                </div>



                                                <div class="col-md-4 my-2">
                                                    <button type="submit" class="btn btn-primary w-100">Apply</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
@endsection
