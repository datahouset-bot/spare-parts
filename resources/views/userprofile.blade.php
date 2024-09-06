@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<div class="container">

    <div class="card">
        <div class="card-header">
          User Profile
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email Id</th>
                    <th scope="col">Status</th>
                    <th scope="col">Reg.Date</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $record)
                    
                  <tr>
                    <th scope="row">{{$record['id']}}</th>
                    <td>{{$record['name']}}</td>
                    <td>{{$record['email']}}</td>
                    <td>{{$record['email_verified_at']}}</td>
                    <td>{{$record['created_at']}}</td>
                    <td><a href=""  class="btn btn-info btn-sm">View</a></td>
                    <td><a href="{{('viwprofileform/'.$record['id']) }}"  class="btn btn-primary btn-sm">Edit</a></td>
                    <td><a href="{{('deleteprofile/'.$record['id']) }}"  class="btn btn-danger btn-sm">Delete</a></td>
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection