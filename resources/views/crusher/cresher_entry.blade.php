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

{{-- for print style --}}
<style>
/* ===== PRINT STYLE ===== */
@media print {

    body * {
        visibility: hidden;
    }

    #printArea, #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }

    .title-bar {
        background:#333 !important;
        color:#fff !important;
        padding:10px;
        text-align:center;
        font-size:22px;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-table {
        width:100%;
        border-collapse:collapse;
        margin-top:15px;
    }

    .print-table td {
        padding:6px;
        border-bottom:1px dotted #000;
    }

    .print-footer {
        display:flex;
        justify-content:space-between;
        margin-top:40px;
    }

    .print-footer div {
        width:30%;
        border-top:1px solid #000;
        text-align:center;
        padding-top:6px;
    }
}
</style>





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
        <option value="{{ $acc->id }}"
            data-address="{{ $acc->address }}"
            data-phone="{{ $acc->mobile }}">
            {{ $acc->account_name }}
        </option>
    @endforeach
</select>

                    <input type="hidden" id="party_name" name="party_name">
                </div>
                <!-- ADD VEHICLE MODAL -->


               <!-- Vehicle ID -->
<!-- Vehicle ID -->
<div class="col-md-4 col-12">
    <label>* Vehicle Number</label>
    <input type="text"
           class="form-control"
           id="vehicle_no"
           name="vehicle_no"
           placeholder="Enter vehicle number">
</div>




                <!-- Vehicle Measure -->
             <div class="col-md-4 col-12">
    <label>Vehicle Measure</label>
    <input class="form-control"
           id="vehicle_measure"
           type="text"
           name="vehicle_measure"
           placeholder="Enter vehicle measure">
</div>

                <!-- Material -->
                <div class="col-md-4 col-12">
                    <label>* Material</label>
                    <input class="form-control" id="Material" type="text" name="Material">
                </div>

                <!-- Material Remark -->
              <div class="col-md-4 col-12">
    <label>* Unit</label>
    <select class="form-select" id="unit" name="unit">
        <option value="" disabled selected>Select unit</option>
        <option value="Feet">Feet</option>
        <option value="Ton">Ton</option>
    </select>
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
                {{-- cash credit --}}
                <div class="col-md-4 col-12">
    <label>* Cash / Credit</label>
    <select class="form-select" name="payment_type" id="payment_type" required>
        <option value="" disabled selected>Select</option>
        <option value="Cash">Cash</option>
        <option value="Credit">Credit</option>
    </select>
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
                
                {{-- RST --}}
<div class="col-md-4 col-12">
    <label>RST</label>
    <input class="form-control" id="rst" type="number" step="0.01" name="rst" placeholder=" RST">
</div>

                <div class="col-md-4 col-12">
                    <label> Loader Operator</label>
                    <input class="form-control" id="loader" type="text" name="loader">
                </div>

                <div class="col-md-4 col-12">
                    <label>Driver</label>
                    <input class="form-control" id="Driver" type="text" name="Driver">
                </div>

                <div class="col-md-4 col-12">
                    <label>Cresher supervisor</label>
                    <input class="form-control" id="supervisor" type="text" name="supervisor">
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
<div class="modal fade"
     id="captureModal"
     tabindex="-1"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Capture Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <video id="webcam" autoplay playsinline style="width:100%; max-height:180px; display:none;"></video>
                <canvas id="canvas" style="display:none;"></canvas>
<button type="button" id="captureBtn" class="btn btn-primary btn-sm mt-2">
    Capture
</button>


            </div>
            <input type="hidden" name="vehicle_id" value="1"  id="vehicle_id">


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



<!-- JS SCRIPTS -->
<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



{{-- <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


{{-- <script>
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
            stream = await navigator.mediaDevices.getUserMedia({
    video: {
        facingMode: { exact: "environment" }
    }
});

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
    captureBtn.addEventListener("click", (e) => {
    e.preventDefault();

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
        document.getElementById("pic").files = dt.files;

        document.getElementById("pic_trigger").value = fileName;

        bootstrap.Modal.getInstance(document.getElementById("captureModal")).hide();
    }, "image/jpeg", 0.95);
});


});
</script> --}}
<script>
$(document).ready(function () {

    const webcam = document.getElementById("webcam");
    const canvas = document.getElementById("canvas");
    const captureBtn = document.getElementById("captureBtn");
    const modal = document.getElementById("captureModal");
    const fileInput = document.getElementById("pic");
    const triggerInput = document.getElementById("pic_trigger");

    let stream = null;

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: "environment" } }
            });
        } catch {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user" }
            });
        }

        webcam.srcObject = stream;
        webcam.style.display = "block";
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
        }
        stream = null;
        webcam.srcObject = null;
        webcam.style.display = "none";
    }

    modal.addEventListener("shown.bs.modal", startCamera);
    modal.addEventListener("hidden.bs.modal", stopCamera);

    // ✅ CAPTURE IMAGE (NO RESET ISSUE)
    captureBtn.addEventListener("click", function () {

        if (!stream) return;

        canvas.width = webcam.videoWidth;
        canvas.height = webcam.videoHeight;

        canvas.getContext("2d").drawImage(webcam, 0, 0);

        canvas.toBlob(blob => {

            const file = new File(
                [blob],
                "capture_" + Date.now() + ".jpg",
                { type: "image/jpeg" }
            );

            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;

            triggerInput.value = file.name;

            bootstrap.Modal.getInstance(modal).hide();

        }, "image/jpeg", 0.95);
    });

});
</script>


{{-- =================================for data print preview============================================== --}}
<script>
function openPrintPreview(data) {

    let w = window.open('', '_blank');

    w.document.write(`
<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<title>मटेरियल चालान</title>

<style>
@page {
    size: A4;
    margin: 20mm;
}

body {
    font-family: Mangal, "Noto Sans Devanagari", Arial, sans-serif;
    font-size: 15px;
    color: #000;
}

/* ===== TOP LOGOS ===== */
.logos {
    width: 100%;
    display: table;
    margin-bottom: 10px;
}
.logos div {
    display: table-cell;
    text-align: center;
}
.logos img {
    height: 45px;
}

/* ===== TITLE BAR ===== */
.title {
    background: #333 !important;
    color: #fff !important;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    padding: 8px;
    margin: 12px 0 25px;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
}

td {
    padding: 6px 4px;
    vertical-align: bottom;
}

.label {
    width: 120px;
    white-space: nowrap;
}

.value {
    border-bottom: 1px dotted #000;
    min-width: 180px;
    padding-left: 6px;
}

.spacer td {
    padding-top: 12px;
}

/* ===== FOOTER ===== */
.footer {
    margin-top: 45px;
    display: table;
    width: 100%;
}
.footer div {
    display: table-cell;
    text-align: center;
    width: 33%;
}
.footer span {
    display: inline-block;
    border-top: 1px solid #000;
    padding-top: 6px;
    min-width: 180px;
}
</style>
</head>

<body>

<!-- LOGOS -->
<div class="logos">
    <div><img src="${data.left_logo || ''}"></div>
    <div><img src="${data.center_logo || ''}"></div>
    <div><img src="${data.right_logo || ''}"></div>
</div>

<!-- TITLE -->
<div class="title">मटेरियल चालान</div>

<!-- CONTENT -->
<table>
<tr>
    <td class="label">क्रमांक</td>
    <td class="value">${data.slip_no || ''}</td>
    <td class="label">दिनांक</td>
    <td class="value">${data.date || ''}</td>
</tr>

<tr>
    <td class="label">समय</td>
    <td class="value">${data.time || ''}</td>
    <td class="label">सुबह / शाम</td>
    <td class="value"></td>
</tr>

<tr>
    <td class="label">वाहन नं.</td>
    <td class="value">${data.vehicle_no || ''}</td>
    <td></td><td></td>
</tr>

<tr>
    <td class="label">माल</td>
    <td class="value">${data.Material || ''}</td>
    <td></td><td></td>
</tr>

<tr>
    <td class="label">मात्रा</td>
    <td class="value">${data.Quantity || ''}</td>
    <td class="label">गाड़ी का नाप</td>
    <td class="value">${data.vehicle_measure || ''}</td>
</tr>

<tr class="spacer">
    <td colspan="4">
        पार्टी का नाम व पता :
        <span style="border-bottom:1px dotted #000; padding-left:6px;">
            ${data.party_name || ''}, ${data.phone || ''}
        </span>
    </td>
</tr>

<tr class="spacer">
    <td class="label">कैश / खाता</td>
    <td class="value">${data.payment_type || ''}</td>
    <td class="label">RST</td>
    <td class="value">${data.rst || ''}</td>
</tr>
</table>

<!-- FOOTER -->
<div class="footer">
    <div>
        <span>लोडर ऑपरेटर<br>
        ${data.loader || ''}</span>
    </div>

    <div>
        <span>हस्ता. ड्राइवर<br>
        ${data.Driver || ''}</span>
    </div>

    <div>
        <span>हस्ता. क्रेशर सुपरवाइजर<br>
        ${data.supervisor || ''}</span>
    </div>
</div>


<script>
window.onload = function() {
    window.print();
}
<\/script>

</body>
</html>
    `);

    w.document.close();
}
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

    

        error: function(xhr) {
            $("#saveVehicleBtn").prop("disabled", false).text("Save");
            alert("Error saving vehicle");
            console.log(xhr.responseText);
        }
    });
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

<script>
    $('#search_id').change(function () {
    let selected = $(this).find(":selected");

    // Fill hidden party name
    $('#party_name').val(selected.text().trim());

    // Auto-fill address
    $('#address').val(selected.data('address') || '');

    // Auto-fill phone
    $('#phone').val(selected.data('phone') || '');
});

</script>
<!-- ============= AJAX SAVE FORM ============= -->
<script>
$(function () {

    $('#saveForm').submit(function (e) {
        e.preventDefault();

        let fd = new FormData(this);

        $('#saveButton').prop('disabled', true).text('Saving...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,

            success: function (res) {

                $('#saveButton').prop('disabled', false).text('Save');

                // 🔹 Collect form data for print
                let data = {};
                $('#saveForm').find('input, select, textarea').each(function () {
                    if (this.name) {
                        data[this.name] = $(this).val();
                    }
                });

                // Slip no
                data.slip_no = "{{ $nextSlip }}";

                // ✅ PRINT AFTER SAVE
                openPrintPreview(data);
            },

            error: function (xhr) {
                $('#saveButton').prop('disabled', false).text('Save');

                if (xhr.status === 422) {
                    let msg = '';
                    $.each(xhr.responseJSON.errors, function (k, v) {
                        msg += v[0] + "\n";
                    });
                    alert(msg);
                } else {
                    alert('Server error');
                    console.error(xhr.responseText);
                }
            }
        });
    });

});
</script>

<script>
$(document).ready(function () {

    function calculateGrandTotal() {
        let total   = parseFloat($('#total').val()) || 0;
        let royalty = parseFloat($('#Royalty').val()) || 0;

        let grandTotal = total + royalty;

        $('#grand_total').val(grandTotal.toFixed(2));
    }

    // Royalty se cursor bahar jate hi
    $('#Royalty').on('blur', function () {
        calculateGrandTotal();
    });

});
</script>
<script>
$('#captureModal').on('hidden.bs.modal', function () {

    // remove stuck backdrop
    $('.modal-backdrop').remove();

    // remove body lock
    $('body').removeClass('modal-open')
             .css('overflow', 'auto')
             .css('padding-right', '');

});
</script>

@endsection

