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
                                        <h3 class="text-center font-weight-light my-1">Add Option</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('optionlists.update', $optionlist->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-md-4">
                                                    <select name="option_type" class="form-select">
                                                        <option disabled {{ !isset($optionlist->option_type) ? 'selected' : '' }}>Select Option Type</option>
                                                        <option value="state" {{ isset($optionlist->option_type) && $optionlist->option_type == 'state' ? 'selected' : '' }}>State</option>
                                                        <option value="country" {{ isset($optionlist->option_type) && $optionlist->option_type == 'country' ? 'selected' : '' }}>Country</option>
                                                        <option value="nationality" {{ isset($optionlist->option_type) && $optionlist->option_type == 'nationality' ? 'selected' : '' }}>Nationality</option>
                                                        <option value="document_name" {{ isset($optionlist->option_type) && $optionlist->option_type == 'document_name' ? 'selected' : '' }}>Document Name</option>
                                                        <option value="agent_name" {{ isset($optionlist->option_type) && $optionlist->option_type == 'agent_name' ? 'selected' : '' }}>Agent Name</option>
                                                    </select>
                                                    
                                                    <span class="text-danger"> 
                                                        @error('option_type')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="option_name" class="form-control" value="{{$optionlist->option_name}}">
                                                    <span class="text-danger"> 
                                                        @error('option_name')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
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
