@php
    include public_path('cdn/cdn.blade.php');
@endphp
{{-- <link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}"> --}}

@extends('layouts.blank')
@section('pagecontent')
  
<div style="max-width: 600px; margin: 50px auto; padding: 30px; border: 2px solid #e74c3c; border-radius: 15px; background-color: #fef2f2; text-align: center; font-family: Arial, sans-serif;">
    <h1 style="color: #e74c3c; margin-bottom: 20px;">
        ❌ Voucher Entry Date does not fall within the Financial Year range!
    </h1>
    <p style="font-size: 18px; color: #555;">
        Please check your entry date and ensure it lies between 
        <strong>  {{date("d-m-Y", strtotime($fy_start_date))}}  </strong> 
        and 
        <strong>  {{date("d-m-Y", strtotime($fy_end_date))}}  </strong>.
    </p>
    <button onclick="window.history.back();" style="margin-top: 30px; padding: 10px 20px; font-size: 16px; background-color: #e74c3c; color: white; border: none; border-radius: 8px; cursor: pointer;">
        🔙 Go Back
    </button>
</div>
   
@endsection







