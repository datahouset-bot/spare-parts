@extends('layouts.blank')
@section('pagecontent')
    <!-- Styles & Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');
        });
    </script>

    <div class="container mt-4">
        @if (session('message'))
            <div class="alert alert-primary">{{ session('message') }}</div>
        @endif


        <div class="card p-4 shadow-sm">
            <h4 class="mb-3">Send Promotional WhatsApp</h4>
            <div class="row">
                <div class="col-md-4"><button type="button" id="copyGuestBtn" class="btn btn-success">Copy All Guest
                        No</button>
         
                </div>
<div class="col-md-4">
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#uploadModal">
        Upload Image
    </button>
            <input type="text" name="file_url" id="file_url">
        <input type="text" name="filename" id="filename">
</div>
                {{-- action="{{ url('start_wp_promotion') }}" method="POST" --}}
                <form id="whtsappform" class="row g-3">
                    @csrf

                    <!-- Mobile Numbers Input -->
                    <!-- Mobile Numbers Input -->
                    <div class="col-12">
                        <label for="mobile_numbers" class="form-label">Mobile Numbers (comma-separated)</label>
                        <textarea name="mobile_numbers" id="mobile_numbers" class="form-control" rows="5" style="font-size: 16px;"
                            placeholder="e.g. 9876543210,9876543211"></textarea>

                        <small id="numberCount" class="text-muted d-block mt-1">0 valid number(s)</small>
                        <span class="text-danger">
                            @error('mobile_numbers')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <!-- WhatsApp Message -->
                    <div class="col-12">
                        <label for="message" class="form-label">WhatsApp Message</label>
                        <textarea name="message" id="message" class="form-control" rows="12" style="min-height: 150px; font-size: 16px;"
                            placeholder="Type your promotional message here..."></textarea>
                        <span class="text-danger">
                            @error('message')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <!-- Message Progress UI -->
                    <div class="mt-3">
                        <div class="progress" style="height: 20px;">
                            <div id="messageProgress" class="progress-bar" role="progressbar" style="width: 0%">0%</div>
                        </div>
                        <p class="mt-2">Sent: <span id="sentCount">0</span> / <span id="totalCount">0</span></p>
                        <button id="startBtn" class="btn btn-success mt-2">Start</button>
                        <button id="stopBtn" class="btn btn-danger mt-2">Stop</button>
                    </div>


                    <!-- Buttons -->
                </form>
            </div>
        </div>

        <!-- Trigger Button -->


<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="imageUploadForm" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="upload_image" class="form-label">Choose Image</label>
            <input type="file" name="upload_image" id="upload_image" accept=".jpg,.jpeg,.png,.pdf" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>

        <script>
            function updateMobileCount() {
                let textarea = $('#mobile_numbers');
                let raw = textarea.val();

                // Replace newline/space with commas
                let cleaned = raw.replace(/[\n\r\s]+/g, ',');

                // Split, trim, and filter valid 10-digit numbers
                let numbers = cleaned
                    .split(',')
                    .map(n => n.trim())
                    .filter(n => /^\d{10}$/.test(n));

                // Remove duplicates
                let uniqueNumbers = [...new Set(numbers)];

                // Update textarea and number count
                textarea.val(uniqueNumbers.join(','));
                $('#numberCount').text(`${uniqueNumbers.length} valid number(s)`);
            }

            $(document).ready(function() {
                $('#mobile_numbers').on('input paste blur', function() {
                    setTimeout(updateMobileCount, 100);
                });
            });
        </script>


        <script>
            let shouldStop = false;

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            async function sendWhatsAppMessages(numbers, message) {
                let total = numbers.length;
                let sent = 0;

                $("#totalCount").text(total);
                $("#sentCount").text(0);
                $("#messageProgress").css("width", "0%").text("0%");
                let fileUrl = $('#file_url').val().trim();
    let filename = $('#filename').val().trim();

                for (let i = 0; i < total; i++) {
                    if (shouldStop) break;

                    let mobile = numbers[i];
                    try {
                        const response = await $.ajax({
                            url: '/start_wp_promotion',
                            method: 'POST',
                            data: {
                                mobile_numbers: mobile,
                                message: message,
                                 file_url: fileUrl,
                                 filename: filename,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        if (response.status === 200) {
                            sent++;
                            console.log(response);

                        }

                        // Update progress
                        let progress = Math.round((sent / total) * 100);
                        $("#sentCount").text(sent);
                        $("#messageProgress").css("width", `${progress}%`).text(`${progress}%`);
                    } catch (err) {
                        console.error(`Failed for ${mobile}`, err);
                    }

                    // Random delay between 10 to 30 seconds
                    const delay = Math.floor(Math.random() * (30 - 10 + 1) + 10) * 1000;
                    await sleep(delay);
                }

                $("#startBtn").prop("disabled", false);
                $("#stopBtn").prop("disabled", true);
                shouldStop = false;
            }

            $(document).ready(function() {
                $("#startBtn").on("click", function(e) {
                    e.preventDefault();

                    let numbers = $('#mobile_numbers').val()
                        .split(',')
                        .map(n => n.trim())
                        .filter(n => /^\d{10}$/.test(n));

                    let message = $('#message').val().trim();

                    if (numbers.length === 0 || message === "") {
                        alert("Please enter valid mobile numbers and a message.");
                        return;
                    }

                    $("#startBtn").prop("disabled", true);
                    $("#stopBtn").prop("disabled", false);
                    shouldStop = false;

                    sendWhatsAppMessages(numbers, message);
                });

                $("#stopBtn").on("click", function() {
                    shouldStop = true;
                });
            });
        </script>
        <script>
            // script for copy mobile no 
            $('#copyGuestBtn').click(function() {
                $.ajax({
                    url: '/get_guest_mobile_numbers',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 200) {
                            const numbers = response.mobiles.join(',');
                            $('#mobile_numbers').val(numbers).trigger('input');
                        } else {
                            alert('Failed to fetch guest numbers');
                        }
                    },
                    error: function() {
                        alert('Error fetching mobile numbers');
                    }
                });
            });
        </script>
<script>
$('#imageUploadForm').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: '{{ route("whatsapp.upload") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);

            $('#file_url').val(response.file_url);
                $('#filename').val(response.filename);
                alert('Upload Successful!');
$('#uploadModal').modal('hide').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});

        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Upload Failed');
        }
    });
});
</script>

@endsection
