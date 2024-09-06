
@extends('layouts.blank')
@section('pagecontent')
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
    



</head>

<body>
    <table class="table table-striped ">
        <thead class="">
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Domain</th>
            <th scope="col">Created At </th>
            <th scope="col"> </th>
            <th scope="col"> </th>

          </tr>
        </thead>
        <tbody>
            @php
                $i=1;
            @endphp
            @foreach ($tenant as $tenant)
            <tr>
           
                
            <th scope="row">{{$i++}}</th>
            <td>{{ $tenant->name}}</td>
            <td>{{ $tenant->email}}</td>
            <td>@foreach ($tenant->domains as $domain )
                {{$domain->domain}}{{$loop->last ?'':','}}
            @endforeach</td>
            <td>{{ $tenant->created_at}}</td>
            <td><a href="" class ="btn btn-success">Edit</a></td>
            <td><a href="{{('delete_tenant/'.$tenant->id) }}" class ="btn btn-danger">Delate</a></td>

          </tr>
          @endforeach
          
        </tbody>
      </table>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
       ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        ></script>
        </body>

</html>

@endsection