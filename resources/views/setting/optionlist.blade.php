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
                                        <form action="{{route('optionlists.store')}}" method="POST">
                                            @csrf
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-md-4">

                                                    <select name="option_type" class="form-select">
                                                        <option selected disabled>Select Option Type</option>
                                                        <option value="state">State</option>
                                                        <option value="country">Country</option>
                                                        <option value="nationality">Nationality</option>
                                                        <option value="document_name">Document Name</option>
                                                        <option value="agent_name">Agent Name</option>
                                                    </select>
                                                    <span class="text-danger"> 
                                                        @error('option_type')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="option_name" class="form-control" placeholder="Enter Option Name">
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
                                        <div class="row">
                                            <table class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Option Type</th>
                                                        <th>Option Name </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $r1=0;
                                                    @endphp
                                        @foreach ($optionlist as $record )
                                        <tr>
                                            <td>{{$r1+=1}}</td>
                                            <td>{{$record->option_type}}</td>
                                            <td>{{$record->option_name}}</td>
                                            <td>
                                                <a href="{{ route('optionlists.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                                            </td>
                                        </tr>
                                            
                                        @endforeach
                                                </tbody>
                                        
                                            </table>
                                        </div>
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
