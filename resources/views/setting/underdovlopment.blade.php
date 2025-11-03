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

        <div style="text-align: center; margin-top: 100px;">
        <h1 style="color: #ff6600; font-size: 36px; font-family: Arial, sans-serif;">
            🚧 Under Development 🚧
        </h1>
        <p style="font-size: 18px; color: #555;">
            This feature is currently being worked on. Please check back later.
        </p>
    </div>

             </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
@endsection
