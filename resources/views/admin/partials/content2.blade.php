<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* ===============================
   GLOBAL POLISH
================================ */
/* =====================================================
   FIX: Recent Sales / Outstanding / Purchase Section
   RESPONSIVE ONLY — NO HTML CHANGE
===================================================== */

/* Ensure equal height behavior */
#recent-sales-section,
#recent-sales-section + .col-xl-6 {
    display: flex;
    flex-direction: column;
}

/* Desktop: side-by-side stays SAME */
@media (min-width: 1200px) {
    #recent-sales-section,
    #recent-sales-section + .col-xl-6 {
        height: 100%;
    }
}

/* ===================== TABLET ===================== */
@media (max-width: 991px) {

    /* Stack LEFT and RIGHT blocks */
    #recent-sales-section,
    #recent-sales-section + .col-xl-6 {
        width: 100%;
        max-width: 100%;
    }

    /* Remove forced heights */
    #recent-sales-section .card,
    #recent-sales-section + .col-xl-6 .card {
        height: auto !important;
    }

    /* Tables scroll horizontally */
    #recent-sales-section table,
    .col-xl-6 table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    /* Purchase chart height control */
    #purchaseBarChart {
        height: 220px !important;
    }
}

/* ===================== MOBILE ===================== */
@media (max-width: 767px) {

    /* Full stacking */
    #recent-sales-section,
    #recent-sales-section + .col-xl-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    /* Card spacing */
    #recent-sales-section .card,
    .col-xl-6 .card {
        margin-bottom: 16px;
    }

    /* Reduce header font */
    .card-header {
        font-size: 14px;
        padding: 10px 12px;
    }

    /* Table text size */
    table th,
    table td {
        font-size: 13px;
        padding: 6px;
    }

    /* Chart fits screen */
    #purchaseBarChart {
        height: 200px !important;
    }
}

/* ===================== SMALL MOBILE ===================== */
@media (max-width: 480px) {

    /* Smaller chart */
    #purchaseBarChart {
        height: 180px !important;
    }

    /* Reduce table spacing further */
    table th,
    table td {
        font-size: 12px;
        padding: 5px;
    }
}

body {
    background:gray;
}

/* ===============================
   LOGO + TITLE
================================ */
.logo1 {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.logo1 h1 {
    font-size: 26px;
    font-weight: 800;
    color: #1f2937;
}

/* ===============================
   BREADCRUMB INFO BAR
================================ */
.breadcrumb {
    background: linear-gradient(90deg, #ffffff, #f9fafb);
    padding: 14px 16px;
    border-radius: 10px;
    box-shadow: 0 12px 12px rgba(243, 2, 2, 0.);
    font-size: 14px;
}

/* ===============================
   DASHBOARD CARDS – BIG & CLICKABLE
================================ */
.card {
    border-radius: 14px;
    overflow: hidden;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 30px 40px #35b8dd;
}

/* ===============================
   BIG BUTTONS INSIDE CARD
================================ */
.card a.btn {
    width: 100%;
    height: 75px;               /* BIG BUTTON */
    font-size: 30px;            /* BIG TEXT */
    font-weight: 700;
    border-radius: 14px;
    padding: 0 18px;
    display: flex;
    align-items: center;
    gap: 15px;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
}

/* ===============================
   ICONS – BIG & ANIMATED
================================ */
.card i {
    font-size:38px;
    transition: transform 0.3s ease;
}

.card:hover i {
    transform: rotate(-6deg) scale(1.2);
}

/* ===============================
   BUTTON HOVER EFFECT
================================ */
.card a.btn:hover {
    filter: brightness(1.05);
}

/* ===============================
   COLOR DEPTH
================================ */
.btn-success { background: linear-gradient(135deg, #22c55e, #16a34a); }
.btn-danger  { background: linear-gradient(135deg, #ef4444, #b91c1c); }
.btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
.btn-info    { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
.btn-dark    { background: linear-gradient(135deg, #374151, #111827); }
.btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); }


/* =====================================================
   FULL PAGE ALIGNMENT FIX – NO HTML CHANGE
===================================================== */

/* Prevent flex containers from affecting next rows */

/* Desktop: keep Recent Sale & Outstanding side-by-side */


</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="layoutSidenav_content" style="background-color: whitesmoke">
   
    <main  >
        <div class="container-fluid px-4">

            <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                    width="80px">
                <h1 class="mt-4"> {{ $componyinfo->cominfo_firm_name }} </h1>

            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                   <h5>{{ $compinfofooter->ct2 }} Dashboard Today Date  {{ now()->format('d-m-y') }} Time 
                    <span id="current-time"></span>
                    <span id="finacial_year" style="background-color: rgb(247, 164, 164); font-weight: 800px; color: rgb(8, 32, 243);">
           @if ($financialyear)
    FY From{{ \Carbon\Carbon::parse( $financialyear->financial_year_start)->format('d-m-y') }}  to   {{ \Carbon\Carbon::parse( $financialyear->financial_year_end)->format('d-m-y') }} 
@endif
 
  
                    </span>
                    <br>Activation Date:&nbsp;{{ \Carbon\Carbon::parse($softwarecompinfo->activation_date)->format('d-m-y') }}  & Renew Date:&nbsp;{{ \Carbon\Carbon::parse($softwarecompinfo->expiry_date)->format('d-m-y') }} & Day Remaining:&nbsp;{{$daysDifference}}
                                @if ($softwarecompinfo->software_af6 == 'af')
                                  <span style="background-color: orange; font-weight: 800px; color: white;"> WhatsApp Not Active99 </span>  
</h5>
 @else
    @php
        $validity_date = \Carbon\Carbon::parse($softwarecompinfo->software_af6)->startOfDay();
        $current_date = now()->startOfDay();
    @endphp

    @if ($current_date->greaterThan($validity_date))
     <span style="background-color: red; font-weight: 800px; color: white;"> WhatsApp Validity Expired On {{ $validity_date->format('d-m-Y') }}</span>  
    @else
    <span style="background-color: green; font-weight: 800px; color: white;">WhatsApp Validity: {{ $validity_date->format('d-m-Y') }}</span>
        
    @endif
@endif

                </li>


            </ol>
             <div class="row">
                 @can('Room_Dashboard')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/room_dashboard') }}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"> <h3>Dashboard</h3></span>
                        </a>
                    </div>
                </div>
                @endcan 



                {{-- @can('roombooking')
                <div class="col-xl-3 col-md-6">
                    
                    <div class="card bg-primary text-white mb-4">
                     
                          
                        <a href="{{ url('/roombookings/create') }}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-calendar-plus"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Room Booking</span>
                        </a>

                    </div>
                </div>
                @endcan  --}}
                {{-- @can('roomcheckin') 
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/roomcheckins/create') }}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Room Check In</span>
                        </a>
                    </div>
                </div>
                @endcan
                @can('roomcheckout')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/roomcheckouts/create') }}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Room Checkout</span>
                        </a>
                    </div>
                </div>
            @endcan
            @can('kot')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/kots/create') }}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">New Kot</span>
                        </a>
                    </div>
                </div>
            @endcan --}}
            {{-- @can('foodbills')
                

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('foodbills/create') }}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-receipt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">New Food Bill</span>
                        </a>
                    </div>
                </div>
           @endcan
           @can('advance_reciept') 
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/advace_receipt') }}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Room Advance Receipt</span>
                        </a>
                    </div>
                </div>
            @endcan--}}
            @can('Lead Module')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/amclist') }}" class="btn btn-success d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-database"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">AMC - {{ $amcCount }} </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/amclist_due') }}" class="btn btn-danger d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Toatl Due - {{ $dueAmcCount }} </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/todolist') }}" class="btn btn-warning d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-tasks"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Pending Task - {{ $pendingTask }} </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/followup_list') }}" class="btn btn-dark d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-calendar-check"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Today's Follow Up -  {{ $todayFollowup }}</span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/coldcall') }}" class="btn btn-success d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Add New Lead </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/amclist_end_month') }}" class="btn btn-dark d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-chart-bar"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Month Wise Amc  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/amc_month_inactive') }}" class="btn btn-danger d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-clock"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Month Wise Inactive  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <a href="{{ url('/amclist_due_month') }}" class="btn btn-info d-flex align-items-center justify-content-start">
                        <span class="d-flex" style="width: 10%;">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <span class="ms-2" style="width: 90%;">Month Wise Due  </span>
                    </a>
                </div>
            </div>
        @endcan
<div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <a href="{{ url('/roomcheckins/create') }}"
           class="btn btn-danger d-flex align-items-center justify-content-start">
            
            <span class="d-flex" style="width: 10%;">
                <i class="fas fa-tools"></i>
            </span>
            <span class="ms-2" style="width: 90%;">
                <h3>Job Card</h3>
            </span>
        </a>
    </div>
</div>

        @can('sale')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <a href="{{ url('/sales') }}" class="btn btn-sales d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-box-open"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Sale invoice</h3></span>
                        </a>
                    </div>
                </div>
            @endcan
        
           
         @can('purchase')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/purchases') }}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-cart-plus"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Purchase</h3></span>
                        </a>
                    </div>
                </div>
            @endcan
              

 @can('receipt')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/reciepts') }}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Receipt</h3></span>
                        </a>
                    </div>
                </div>
            @endcan
@can('payment')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/payments') }}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-money-bill"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Payment </h3>

                            </span>
                        </a>
                    </div>
                </div>
@endcan
 
 
            {{-- @can('Restaurant')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">

                        <a href="{{ url('/table_dashboard') }}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-store"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">dashboard</span>
                        </a>
                    </div>
                </div>
                @endcan --}}
                 @can('ledger')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/ledgers') }}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Ledger</h3></span>
                        </a>
                    </div>
                </div>
            @endcan

            
            @can('Stock_Transfer')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <a href="{{ url('/stocktransfers') }}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Stock Transfer</h3></span>
                        </a>
                    </div>
                </div>
            @endcan
           
            
            @can('Report')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/report_dashboard') }}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"><h3>Report</h3></span>
                        </a>
                    </div>
                </div>
            @endcan   
          

              <!-- =========================
    MOBILE NUMBER SECTION
========================= -->
      
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
                @can('Hotel Module')

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
                                        <table >
                        <thead>
   @if($kot_Unprinted > 0 || $Rkot_Unprinted > 0)
    <style>
        .kot-alert-row {
            background-color: #ffe6e6; /* Light red background for row */
            color: #d60000;
            font-weight: bold;
        }

        .blinking-bulb {
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-right: 8px;
            background-color: red;
            border-radius: 50%;
            animation: blinker 1.2s linear infinite;
            box-shadow: 0 0 6px red;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .kot-link {
            text-decoration: none;
            color: #d60000;
            font-size: 16px;
        }

        .kot-link:hover {
            text-decoration: underline;
        }
    </style>

    @if($kot_Unprinted > 0)
        <tr class="kot-alert-row">
            <th>
                <span class="blinking-bulb"></span>
                <a href="{{ route('kots.index') }}" class="kot-link">Room Kot Unprinted - {{ $kot_Unprinted }}</a>
            </th>
        </tr>
    @endif

    @if($Rkot_Unprinted > 0)
        <tr class="kot-alert-row">
            <th>
                <span class="blinking-bulb"></span>
                <a href="{{ url('/restaurant_kot') }}" class="kot-link">Restaurant Kot Unprinted - {{ $Rkot_Unprinted }}</a>
            </th>
        </tr>
    @endif
@endif




                      
                            
                            </tr>
                        </thead>
                    

                    </table>
                </div>
                @endcan
                <div class="col-md-6 d-flex">
                    {{-- <div class="col-md-3">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" autocomplete="off">
                    </div>
                    <div class="col-md-2 mx-2">
                        <!-- First Button: Redirect to WhatsApp with just the mobile number -->
                        <a href="#" id="whatsapp-link" target="_blank">
                            <i class="fa fa-bullhorn" style="font-size:40px;color:green"></i>
                        </a>
                    </div> --}}
                    {{-- @can('Hotel Module')
            
                    <div class="col-md-2">
                        <!-- Second Button: Send message to WhatsApp -->
                        <a href="#" id="send-message" class="btn btn-success">Send Website Link</a>
                    </div>
                        

                    <div class="col-md-2">
                        <!-- Second Button: Send message to WhatsApp -->
                        <a href="{{ url('/') }}/{{ Auth::user()->firm_id }}" id="send-message" class="btn btn-danger mx-1">Visit Website</a>
                    </div>
                     <div  style="{{ $componyinfo->componyinfo_af2 == 1 ? '' : 'display:none;' }}" class="col-md-2">
                        <!-- Second Button: Send message to WhatsApp -->
                        <a href="{{ url('/pushInventory') }}" id="send-message" class="btn btn-warning mx-1"> <i class="fas fa-cloud-upload-alt" style="font-size:18px;"></i> &nbsp;Push Room Inventory</a>
                    </div>

                    @endcan --}}
            @if(
    !Auth::user()->can('Attendance Module') &&
    !Auth::user()->can('Crusher Module')
)
{{-- ======================= DASHBOARD QUICK ACTIONS ======================= --}}
<div class="row mt-4 g-4 text-center">

    {{-- Sales --}}
    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white fw-bold">
                <i class="fas fa-box-open me-2"></i> Sales
            </div>
            <div class="card-body d-flex align-items-center">
                <a href="{{ url('/sales') }}"
                   class="btn btn-success btn-lg w-100 py-4 fs-5">
                    <i class="fas fa-eye me-2"></i> View Sales
                </a>
            </div>
        </div>
    </div>

    {{-- Purchase --}}
    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-cart-plus me-2"></i> Purchase
            </div>
            <div class="card-body d-flex align-items-center">
                <a href="{{ url('/purchases') }}"
                   class="btn btn-primary btn-lg w-100 py-4 fs-5">
                    <i class="fas fa-eye me-2"></i> View Purchase
                </a>
            </div>
        </div>
    </div>

    {{-- Payable --}}
    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-danger text-white fw-bold">
                <i class="fas fa-file-invoice-dollar me-2"></i> Payable
            </div>
            <div class="card-body d-flex align-items-center">
                <a href="{{ url('/outstanding_payable') }}"
                   class="btn btn-outline-danger btn-lg w-100 py-4 fs-5">
                    <i class="fas fa-eye me-2"></i> View Payable
                </a>
            </div>
        </div>
    </div>

    {{-- Receivable --}}
    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white fw-bold">
                <i class="fas fa-money-bill-wave me-2"></i> Receivable
            </div>
            <div class="card-body d-flex align-items-center">
                <a href="{{ url('/outstanding_receivable') }}"
                   class="btn btn-outline-success btn-lg w-100 py-4 fs-5">
                    <i class="fas fa-eye me-2"></i> View Receivable
                </a>
            </div>
        </div>
    </div>

</div>

</div>


@can('Crusher Module')
<div class="row justify-content-center my-4">
    <div class="col-xl-12 col-lg-12 col-md-12 text-center">
        <div class="card">
            <a href="{{ route('crusher.index') }}"
               class="btn btn-success d-flex align-items-center justify-content-center"
               style="height:90px; font-size:22px; font-weight:800; border-radius:16px;">
                
                <i class="fas fa-user-clock me-3" style="font-size:34px; align:center;"></i>
                Material Challan Details
            </a>
        </div>
    </div>
</div>
@endcan
@can('Attendance Module')
<div class="row justify-content-center my-4">
    <div class="col-xl-12 col-lg-8 col-md-10 text-center">
        <div class="card">
            <a href="{{ route('attendance.checkin') }}"
               class="btn btn-success d-flex align-items-center justify-content-center"
               style="height:90px; font-size:22px; font-weight:800; border-radius:16px;">
                
                <i class="fas fa-user-clock me-3" style="font-size:34px;"></i>
                Check-In / Check-Out
            </a>
        </div>
    </div>
</div>
@endcan

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('purchaseBarChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($purchaseChart as $p)
                    "{{ $p->account->account_name ?? 'Unknown' }}",
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($purchaseChart as $p)
                        {{ $p->total_net_amount ?? 0 }},
                    @endforeach
                ],
                backgroundColor: '#0ea5e9',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: { maxRotation: 45, minRotation: 20 }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
</script>

@endif



                <script>
                    // // First Button: Only mobile number
                    // document.getElementById("whatsapp-link").addEventListener("click", function (event) {
                    //     event.preventDefault(); // Prevents the link from navigating immediately
                    //     var mobileNumber = document.getElementById("mobile").value;
                
                    //     if (mobileNumber) {
                    //         // Redirect to WhatsApp with the entered mobile number
                    //         var whatsappUrl = "https://wa.me/91" + mobileNumber;
                    //         window.open(whatsappUrl, "_blank"); // Opens the link in a new tab
                    //     } else {
                    //         alert("Please enter a valid mobile number.");
                    //     }
                    // });
                
                    // Second Button: Mobile number + message
                    document.getElementById("send-message").addEventListener("click", function (event) {
                        event.preventDefault(); // Prevents the link from navigating immediately
                        var mobileNumber = document.getElementById("mobile").value;
                        var message = encodeURIComponent("{{ url('/') }}/{{ Auth::user()->firm_id }}");
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