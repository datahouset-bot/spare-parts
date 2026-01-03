@extends('layouts.blank')

@section('pagecontent')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background: #f5f6fa; }
    .main-box {
        max-width: 80%;
        margin: 50px auto;
        background: white;
        padding: 55px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .btn-custom {
        width: 45%;
        padding: 12px;
        font-size: 18px;
        font-weight: 600;
    }
    video, canvas {
        width: 100%;
        border-radius: 10px;
    }
</style>
<style>
#emp_id.select2-hidden-accessible + .select2-container .select2-selection--single {
    height: 55px !important;
    padding: 9px 9px;
    font-size: 20px;
}
#emp_id.select2-hidden-accessible + .select2-container .select2-selection__rendered {
    line-height: 35px !important;
    font-size: 20px;
}
#emp_id.select2-hidden-accessible + .select2-container .select2-selection__arrow {
    height: 55px !important;
}
</style>


<div class="main-box">

    <h3 class="text-center mb-4 fw-bold">{{$componyinfo->cominfo_firm_name}}</h3>
    {{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ERROR MESSAGE --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


    {{-- FORM --}}
    <form method="POST" action="{{ route('attendancephoto.store') }}">
        @csrf

        <div class="mb-3">
    <select id="emp_id" name="emp_id" class="form-select form-select-lg">
        <option value="">Select EP ID</option>
        @foreach ($employees as $emp)
            <option value="{{ $emp->id }}">{{ $emp->af5 }} &nbsp;||&nbsp; {{ $emp->name }}</option>
        @endforeach
    </select>
</div>

        <div class="mb-4">
            <input type="text" id="emp_name" name="emp_name" class="form-control form-control-lg"
                   placeholder="EP Name" readonly>
        </div>
<div class="text-center mb-4">
    <img id="emp_photo"
         width="180"
         class="rounded shadow mb-2"
         style="display:none;">
</div>


        {{-- Hidden inputs for migration --}}
        <input type="hidden" id="checkin_photo" name="checkin_photo">
        <input type="hidden" id="checkout_photo" name="checkout_photo">

        <input type="hidden" id="checkin_time" name="checkin_time">
        <input type="hidden" id="checkout_time" name="checkout_time">

        <div class="d-flex justify-content-between mt-4">
            <button type="button" id="checkinBtn" class="btn btn-success btn-custom">Check In</button>
            <button type="button" id="checkoutBtn" class="btn btn-danger btn-custom">Check Out</button>
        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100 fw-bold">Submit Attendance</button>
    </form>
</div>

{{-- CAMERA MODAL --}}
<div class="modal fade" id="cameraModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">Capture Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <video id="cameraStream" autoplay playsinline></video>
                <canvas id="cameraCapture" class="d-none"></canvas>
            </div>

            <div class="modal-footer">
                <button type="button" id="snapBtn" class="btn btn-primary">Capture</button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#emp_id').select2({
        placeholder: "Select Employee",
        allowClear: true,
        width: "100%"
    });
});
</script>


</script>



<script>
let captureType = ""; // checkin OR checkout

// Auto-fill employee name
$('#emp_id').on('change', function () {
    let id = $(this).val();

    if (!id) {
        $('#emp_name').val('');
        $('#emp_photo').hide().attr('src', '');
        return;
    }

    $.get('/employeename/' + id, function (res) {
        $('#emp_name').val(res.name);

        if (res.photo) {
            $('#emp_photo')
                .attr('src', res.photo)
                .show();
        } else {
            $('#emp_photo')
                .hide()
                .attr('src', '');
        }
    });
});


// Check-in button
$('#checkinBtn').click(function () {
    captureType = "checkin";
    $('#modalTitle').text("Check-In Photo");
    openCamera();
});

// Check-out button
$('#checkoutBtn').click(function () {
    captureType = "checkout";
    $('#modalTitle').text("Check-Out Photo");
    openCamera();
});

// Start camera
function openCamera() {
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            $('#cameraModal').modal('show');
            document.getElementById('cameraStream').srcObject = stream;
        })
        .catch(error => {
            alert("Camera not accessible!");
        });
}

// Capture image + time
$('#snapBtn').click(function () {

    const video = document.getElementById('cameraStream');
    const canvas = document.getElementById('cameraCapture');
    const context = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Capture image as base64
    let imageData = canvas.toDataURL("image/png");

    // Generate local time
    let now = new Date();
    let timestamp =
        now.getFullYear() + "-" +
        String(now.getMonth() + 1).padStart(2, '0') + "-" +
        String(now.getDate()).padStart(2, '0') + " " +
        String(now.getHours()).padStart(2, '0') + ":" +
        String(now.getMinutes()).padStart(2, '0') + ":" +
        String(now.getSeconds()).padStart(2, '0');

    // Assign values depending on check-in or check-out
    if (captureType === "checkin") {
        $('#checkin_photo').val(imageData);
        $('#checkin_time').val(timestamp);
    } else {
        $('#checkout_photo').val(imageData);
        $('#checkout_time').val(timestamp);
    }

    $('#cameraModal').modal('hide');
});
</script>

@endsection
