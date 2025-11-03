<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<div class="container ">
<!DOCTYPE html>
<html>
<head>
    <title>Room Inventory Push</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        pre { background: #f1f1f1; padding: 15px; border-radius: 6px; overflow-x: auto; }
    </style>
</head>
<body class="container py-4">

    <h2 class="text-center mb-4">Room Inventory Push</h2>

    {{-- <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Vacant Room Type
        </div>
        <div class="card-body">
            <pre>{{ print_r($debugData['vacantroom_roomtype'], true) }}</pre>
        </div>
    </div> --}}

    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            Payload Sent
        </div>
        <div class="card-body">
            <pre>{{ print_r($debugData['sent_payload'], true) }}</pre>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-info text-white">
            API Response
        </div>
        <div class="card-body">
            <pre>{{ print_r($debugData['api_response'], true) }}</pre>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ url('home') }}" class="btn btn-lg btn-primary">
            ⬅ Back to Dashboard
        </a>
    </div>

    {{-- Print Debug Data to Browser Console --}}
    <script>
        console.log("Debug Data:", @json($debugData));
    </script>

</body>
</html>


</div>

@endsection