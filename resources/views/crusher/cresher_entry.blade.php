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

    #pic {
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
                <!-- ADD VEHICLE MODAL -->


               <!-- Vehicle ID -->
<!-- Vehicle ID -->
<div class="col-md-4 col-12">
    <label>Select Vehicle</label>

    <!-- Dropdown -->
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
                    <!-- IMAGE CAPTURE -->
<div class="col-md-4 col-12">
    <label>Image</label>
 <input class="form-control" id="pic_trigger" type="text" readonly
           placeholder="Click to capture image"
           data-bs-toggle="modal"
           data-bs-target="#captureModal">
</div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button id="saveButton" type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-dark" href="{{ url('crusher') }}">Back</a>
                </div>
            </div>
{{-- camera modal --}}
<input type="file" id="pic" name="pic" class="d-none" accept="image/*">
<div class="modal fade" id="captureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Capture Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <video id="webcam" autoplay playsinline style="width:100%; max-height:180px; display:none;"></video>
                <canvas id="canvas" style="display:none;"></canvas>

                <button id="captureBtn" class="btn btn-primary btn-sm mt-2">Capture</button>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


                <!-- END IMAGE CAPTURE -->


            </div>
        </form>
    </div>
</div>


{{-- vehicle modal --}}
<div class="modal fade" id="vehicleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="vehicleForm">
                    @csrf

                    <div class="mb-2">
                        <label>Vehicle Number *</label>
                        <input type="text" class="form-control" name="Vehicle_no">
                    </div>

                    <div class="mb-2">
                        <label>Vehicle Measure *</label>
                        <input type="text" class="form-control" name="vehicle_measure" >
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="saveVehicleBtn" type="button" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
</div>



<!-- JS SCRIPTS -->
<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 AFTER jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {

    const webcam = document.getElementById("webcam");
    const canvas = document.getElementById("canvas");
    const captureBtn = document.getElementById("captureBtn");
    const modal = document.getElementById("captureModal");
    const inputFile = document.getElementById("pic");
  const triggerInput = document.getElementById("pic_trigger"); // correct field


    let stream = null;

    // START CAMERA WHEN MODAL OPENS
    modal.addEventListener("shown.bs.modal", async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            webcam.srcObject = stream;
            webcam.style.display = "block";
        } catch (err) {
            alert("Camera access blocked OR device has no camera.");
        }
    });

    // STOP CAMERA WHEN MODAL CLOSES
    modal.addEventListener("hidden.bs.modal", () => {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        webcam.srcObject = null;
        webcam.style.display = "none";
        stream = null;

        // FIX dark screen issue
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
    });

    // CAPTURE IMAGE
    captureBtn.addEventListener("click", () => {
        if (!stream) return;

        canvas.width = webcam.videoWidth;
        canvas.height = webcam.videoHeight;

        const ctx = canvas.getContext("2d");
        ctx.drawImage(webcam, 0, 0);

      canvas.toBlob(blob => {

    const fileName = "capture_" + Date.now() + ".jpg";
    const file = new File([blob], fileName, { type: "image/jpeg" });

    const dt = new DataTransfer();
    dt.items.add(file);
    inputFile.files = dt.files;   // <-- Correct file input

    triggerInput.value = fileName; // UI display only

    bootstrap.Modal.getInstance(modal).hide();
        }, "image/jpeg", 0.95);
    });

});
</script>

<script>
$(document).ready(function () {

    $('#vehicle_id').select2({
        placeholder: "Search vehicle...",
        width: "100%",
        allowClear: true
    });

    // HTML for button inside dropdown
    let addBtnHtml = `
        <div id="addVehicleBtn"
             style="padding:10px; text-align:center; cursor:pointer;
                    border-top:1px solid #ddd; font-weight:bold; color:#007bff;">
            ➕ Add New Vehicle
        </div>
    `;

    // Inject button every time dropdown opens
    $('#vehicle_id').on('select2:open', function () {

        // Remove duplicates
        $('#addVehicleBtn').remove();

        // Append button to results
        $('.select2-results').append(addBtnHtml);
    });

    // BUTTON CLICK → redirect to page
    $(document).on('click', '#addVehicleBtn', function () {

        // Close dropdown
        $('#vehicle_id').select2('close');

        // Redirect to your page
        window.location.href = "{{ url('vehicledetail/create') }}";  
    });

});

</script>

{{-- ======================for vehicle entry model================================== --}}
<script>
$(function() {

    // Save Vehicle
   $("#saveVehicleBtn").click(function() {

    let fd = new FormData(document.getElementById("vehicleForm"));
    fd.append('_token', "{{ csrf_token() }}");

    $("#saveVehicleBtn").prop("disabled", true).text("Saving...");

    $.ajax({
        url: "{{ route('crusher.addstore') }}",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,

   success: function(res) {

    $("#vehicleModal").modal("hide");

    var newOption = new Option(res.data.Vehicle_no, res.data.id, true, true);
    $(newOption).attr("data-vehicle-measure", res.data.vehicle_measure);
    $(newOption).attr("data-vehicle-no", res.data.Vehicle_no);

    $('#vehicle_id').append(newOption).trigger('change');

    alert("Vehicle added successfully!");
}

,

        error: function(xhr) {
            $("#saveVehicleBtn").prop("disabled", false).text("Save");
            alert("Error saving vehicle");
            console.log(xhr.responseText);
        }
    });
});


    // SELECT BUTTON → Select highlighted vehicle
  $("#selectVehicleBtn").click(function () {

    let s = $("#vehicle_id").select2('data')[0];

    if (!s) {
        return alert("Please select a vehicle");
    }

    // Assign values
    $("#vehicle_measure").val($(s.element).data("vehicle-measure"));
    $("#vehicle_no").val($(s.element).data("vehicle-no"));

    alert("Vehicle selected!");
});

});
</script>
<!-- ======================end for vehicle entry model================================== -->    


<!-- ============= AUTO FILL + TOTAL ============= -->
<script>
$(function() {

    $('#search_id').change(function() {
        $('#party_name').val($(this).find(':selected').text().trim());
    });

  $('#vehicle_id').change(function() {
    let s = $(this).find(":selected");
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
