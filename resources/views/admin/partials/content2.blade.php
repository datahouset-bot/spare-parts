<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                    width="80px">
                <h1 class="mt-4"> {{ $componyinfo->cominfo_firm_name }} </h1>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    {{ $compinfofooter->ct2 }} Dashboard Date {{ now()->format('d-m-y') }} Time
                    <span id="current-time"></span>

                </li>

            </ol>
         




            <div class="row">

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/room_dashboard') }}" class="btn btn-success"> Room Dashboard </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/roombookings/create') }}" class="btn btn-warning"> Room Booking </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/roomcheckins/create') }}" class="btn btn-info"> Room Check In </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/roomcheckouts/create') }}" class="btn btn-primary"> Room Checkout </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/kots/create') }}" class="btn btn-warning"> New Kot </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('foodbills/create') }}" class="btn btn-dark"> New Food Bill </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/advace_receipt') }}" class="btn btn-primary">Room Advance Reciept </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/reciepts') }}" class="btn btn-warning"> Reciept </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/payments') }}" class="btn btn-info">Payment </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/ledgers') }}" class="btn btn-danger">Ledger </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <a href="{{ url('/table_dashboard') }}" class="btn btn-info">Restaurant </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/purchases') }}" class="btn btn-primary">Purchase </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <a href="{{ url('/stocktransfers') }}" class="btn btn-success">Stock Transfer </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <a href="{{ url('/sales') }}" class="btn btn-sales">Stock Issue </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/report_dashboard') }}" class="btn btn-dark">Report </a>

                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body"><canvas id="myBarChart1" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div> --}}
            <div class="row">

                <div class="col-md-6">
                    <h4>Overview</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Room CheckIn </th>
                                <th>Vacant </th>
                                <th>Occupied</th>
                                <th>Dirty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $roomcheckin }}</td>
                                <td>{{ $vacantroom }}</td>
                                <td>{{ $occupiedroom }}</td>
                                <td>{{ $dirtyroom }}</td>

                            </tr>
                        </tbody>

                    </table>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" autocomplete="off">
                    </div>
                    <div class="col-md-2 mx-2">
                        <!-- First Button: Redirect to WhatsApp with just the mobile number -->
                        <a href="#" id="whatsapp-link" target="_blank">
                            <i class="fa fa-bullhorn" style="font-size:40px;color:green"></i>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <!-- Second Button: Send message to WhatsApp -->
                        <a href="#" id="send-message" class="btn btn-success">Send Website Link</a>
                    </div>
                </div>
                
                <script>
                    // First Button: Only mobile number
                    document.getElementById("whatsapp-link").addEventListener("click", function (event) {
                        event.preventDefault(); // Prevents the link from navigating immediately
                        var mobileNumber = document.getElementById("mobile").value;
                
                        if (mobileNumber) {
                            // Redirect to WhatsApp with the entered mobile number
                            var whatsappUrl = "https://wa.me/91" + mobileNumber;
                            window.open(whatsappUrl, "_blank"); // Opens the link in a new tab
                        } else {
                            alert("Please enter a valid mobile number.");
                        }
                    });
                
                    // Second Button: Mobile number + message
                    document.getElementById("send-message").addEventListener("click", function (event) {
                        event.preventDefault(); // Prevents the link from navigating immediately
                        var mobileNumber = document.getElementById("mobile").value;
                        var message = encodeURIComponent("{{ url('/') }}/{{ $compinfofooter->ct4 }}");
                        // URL encode the message
                
                        if (mobileNumber) {
                            // Redirect to WhatsApp with the entered mobile number and message
                            var whatsappUrl = "https://wa.me/91" + mobileNumber + "?text=" + message;
                            window.open(whatsappUrl, "_blank"); // Opens the link in a new tab
                        } else {
                            alert("Please enter a valid mobile number.");
                        }
                    });
                </script>
                

        </div>
    </main>
    <script>
        // script for getting current time from browser pc 
        $(document).ready(function() {
            function getCurrentTime() {
                var currentDate = new Date();
                var hours = currentDate.getHours();
                var minutes = currentDate.getMinutes();
                var seconds = currentDate.getSeconds();
                
                // Add leading zeros to hours, minutes, and seconds
                hours = (hours < 10) ? "0" + hours : hours;
                minutes = (minutes < 10) ? "0" + minutes : minutes;
                seconds = (seconds < 10) ? "0" + seconds : seconds;
                
                var timeString = hours + ":" + minutes + ":" + seconds;
                $('#current-time').text(timeString);
            }
    
            // Call the function once to display the time initially
            getCurrentTime();
    
            // Update the time every second
            setInterval(getCurrentTime, 1000);
        });
    </script>
