@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/form.css') }}">

@extends('layouts.blank')

@section('pagecontent')

<style>
    .card { border-radius: 14px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .card-header { font-weight: 700; letter-spacing: .3px; }
    label { font-size: 13px; background: white; padding: 0 6px; color: blue; font-weight: 800; }
    .form-control { border-radius: 8px; padding: 8px 10px; }
    .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.15rem rgba(13,110,253,.15); }
    .position-relative { margin-bottom: 16px; }
    .requierdfield { color: red; font-weight: 700; }

    #dropZone {
        border: 2px dashed #007bff;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        font-size: 14px;
    }

    #pic_trigger {
        display: block;
        width: 100%;
        padding: 10px 15px;
        background: #f8f9fa;
        border: 2px dashed #007bff;
        border-radius: 5px;
        cursor: pointer;
    }

    video { width:100%; max-height:240px; background:#000; display:none; border-radius:6px; }
    canvas { display:none; }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


<div class="card my-1">
    <div class="card-header">
        <h5 class="text-center my-1" style="background-color: lightskyblue; font-size:24px;">Material CHALLAN</h5>
    </div>

    <div class="card-body">
        <form id="saveForm" action="{{ route('crusher.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <!-- Slip No -->
                <div class="col-md-4 col-12">
                    <label>* Slip No</label>
                    <input type="text" class="form-control" value="{{ $nextSlip }}" readonly>
                </div>

                <!-- Date -->
                <div class="col-md-4 col-12">
                    <label>* Date</label>
                    <input class="form-control" id="date" type="date" name="date" value="{{ date('Y-m-d') }}" />
                </div>

                <!-- Time -->
                <div class="col-md-4 col-12">
                    <label>* Time</label>
                    <input class="form-control" id="time" type="time" name="time" value="{{ date('H:i') }}" />
                </div>

                <!-- Party name -->
                <div class="col-md-4 col-12">
                    <label>Select Party</label>
                    <select id="search_id" name="search_id" class="form-select">
                        <option disabled selected>Select party name</option>
                        @foreach ($account as $acc)
                            <option value="{{ $acc['id'] }}">{{ $acc['account_name'] }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="party_name" name="party_name">
                </div>

                <!-- Vehicle ID -->
                <div class="col-md-4 col-12">
                    <label>Select Vehicle</label>
                    <select id="vehicle_id" name="vehicle_id" class="form-select">
                        <option disabled selected>Select vehicle</option>
                        @foreach ($vehicle as $acc)
                            <option value="{{ $acc->id }}"
                                data-vehicle-measure="{{ $acc->vehicle_measure }}"
                                data-vehicle-no="{{ $acc->Vehicle_no }}">
                                {{ $acc->Vehicle_no }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" id="vehicle_no" name="vehicle_no">
                </div>

                <!-- Vehicle Measure -->
                <div class="col-md-4 col-12">
                    <label>* Vehicle Measure</label>
                    <input class="form-control" id="vehicle_measure" type="text" name="vehicle_measure" readonly>
                </div>

                <!-- Material -->
                <div class="col-md-4 col-12">
                    <label>* Material</label>
                    <input class="form-control" id="Material" type="text" name="Material">
                </div>

                <!-- Material Remark -->
                 <div class="col-md-4 col-12">
                    <label>Unit</label>
                    <input class="form-control" id="unit" type="text" name="unit">
                </div>


                <!-- Quantity -->
                <div class="col-md-4 col-12">
                    <label>* Quantity</label>
                    <input class="form-control" id="Quantity" type="text" name="Quantity">
                </div>

                <!-- Rate -->
                <div class="col-md-4 col-12">
                    <label>Rate</label>
                    <input class="form-control" id="Rate" type="text" name="Rate">
                </div>

                 <div class="col-md-4 col-12">
                    <label>Material Remark</label>
                    <input class="form-control" id="Materialremark" type="text" name="Materialremark">
                </div>
                <!-- Royalty Quantity -->
                <div class="col-md-4 col-12">
                    <label>Royalty Quantity</label>
                    <input class="form-control" id="Royalty_Quantity" type="text" name="Royalty_Quantity">
                </div>



                <!-- Royalty Rate -->
                <div class="col-md-4 col-12">
                    <label>Royalty Rate</label>
                    <input class="form-control" id="Royalty_Rate" type="text" name="Royalty_Rate">
                </div>

                <!-- Royalty -->
                <div class="col-md-4 col-12">
                    <label>Royalty</label>
                    <input class="form-control" id="Royalty" type="text" name="Royalty">
                </div>

                <!-- Total -->
                <div class="col-md-4 col-12">
                    <label>Total</label>
                    <input class="form-control" id="total" type="text" name="total">
                </div>

                {{-- grandtotal --}}
                 <div class="col-md-4 col-12">
                    <label>Grand Total</label>
                    <input class="form-control" id="grand_total" type="text" name="grand_total">
                </div>

                <!-- ADDRESS -->
                <div class="col-md-4 col-12">
                    <label>Address</label>
                    <input class="form-control" id="address" type="text" name="address">
                </div>

                <!-- PHONE -->
                <div class="col-md-4 col-12">
                    <label>Phone</label>
                    <input class="form-control" id="phone" type="text" name="phone">
                </div>

                <!-- Remark -->
                <div class="col-md-4 col-12">
                    <label>Remark</label>
                    <input class="form-control" id="remark" type="text" name="remark">
                </div>

                <!-- IMAGE CAPTURE -->
                <div class="col-md-4 col-12">
                    <label>Image 1</label>

                    <input type="text" id="pic_trigger"
                           class="form-control"
                           readonly
                           placeholder="Click to upload or capture"
                           data-bs-toggle="modal"
                           data-bs-target="#fileUploadModal">

                    <input type="file" id="pic_file" name="pic" class="d-none" accept="image/*">
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button id="saveButton" type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-dark" href="{{ url('crusher') }}">Back</a>
                </div>
            </div>

        </form>
    </div>
</div>



<!-- CAMERA / FILE UPLOAD MODAL -->
<div class="modal fade" id="fileUploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Select Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label>Drag & Drop</label>
                <div id="dropZone">Drag file here or click</div>

                <hr>

                <label>Capture from Camera</label>
                <video id="webcam" autoplay playsinline></video>
                <canvas id="canvas"></canvas>

                <button id="captureBtn" class="btn btn-primary btn-sm mt-2">Capture</button>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>



<!-- JS SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>





<!-- ============= AUTO FILL + TOTAL ============= -->
<script>
$(function() {

    $('#search_id').change(function() {
        $('#party_name').val($(this).find(':selected').text().trim());
    });

    $('#vehicle_id').change(function() {
        let s = $(this).find(':selected');
        $('#vehicle_measure').val(s.data('vehicle-measure'));
        $('#vehicle_no').val(s.data('vehicle-no'));
    });

    function calc() {
        let q = parseFloat($('#Quantity').val()) || 0;
        let r = parseFloat($('#Rate').val()) || 0;

        $('#total').val((q * r ).toFixed(2));
    }
    $('#Quantity,#Rate').on('input', calc);


    function royalty() {
        let q = parseFloat($('#Royalty_Quantity').val()) || 0;
        let r = parseFloat($('#Royalty_Rate').val()) || 0;

        $('#Royalty').val((q * r ).toFixed(2));
    }
    $('#Royalty_Quantity,#Royalty_Rate').on('input', royalty);
    
    function grandtotal() {
        let t = parseFloat($('#total').val()) || 0;
        let ro = parseFloat($('#Royalty').val()) || 0;

        $('#grand_total').val((t + ro ).toFixed(2));
    }
    $('#total,#Royalty').on('input', grandtotal);

});
</script>





<!-- ============= FILE UPLOAD + DRAG DROP + CAMERA FIXED ============= -->
    <script>
$(function() {

    const modalEl = document.getElementById('fileUploadModal');

    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const captureBtn = $('#captureBtn');
    const fileInput = document.getElementById('pic_file');
    const trigger = $('#pic_trigger');

    let stream = null;

    // Start camera when modal opens
    modalEl.addEventListener('shown.bs.modal', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.style.display = "block";
        } catch (err) {
            alert("Camera error: " + err.message);
        }
    });

    // Stop camera when modal closes
    modalEl.addEventListener('hidden.bs.modal', () => {
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
        }
        video.srcObject = null;
        video.style.display = "none";
        stream = null;
    });

    // Capture Image
    captureBtn.click(function (e) {
        e.preventDefault();

        if (!stream) return;

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        canvas.getContext("2d").drawImage(video, 0, 0);

        canvas.toBlob(blob => {
            let filename = "photo_" + Date.now() + ".jpg";
            let file = new File([blob], filename, { type: "image/jpeg" });

            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;

            trigger.val(filename);

            // Correct Bootstrap 5 method:
            bootstrap.Modal.getInstance(modalEl).hide();
        });
    });

});
</script>






<!-- ============= AJAX SAVE FORM ============= -->
<script>
$(function() {
    $('#saveForm').submit(function(e) {
        e.preventDefault();

        let fd = new FormData(this);

        $('#saveButton').prop('disabled', true).text('Saving...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#saveButton').prop('disabled', false).text('Save');
                alert(res.message);
            },
            error: function(xhr) {
                $('#saveButton').prop('disabled', false).text('Save');

                if (xhr.status === 422) {
                    let msg = "";
                    $.each(xhr.responseJSON.errors, (k, v) => msg += v[0] + "\n");
                    alert(msg);
                } else {
                    alert("Server error");
                    console.error(xhr.responseText);
                }
            }
        });
    });
});
</script>

@endsection
