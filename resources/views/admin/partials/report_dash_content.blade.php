
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\'.$pic->logo) }}" alt="qr_code" width="80px"><h1 class="mt-4"> {{ $componyinfo->cominfo_firm_name }} </h1></div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    {{ $compinfofooter->ct2 }} Dashboard Date {{ now()->format('d-m-y') }} Time {{ now()->format('H:i:s') }}
                  </li>
                  
            </ol>

            
            <div class="row">
                <!-- Booking Calendar -->
                @can('Booking Calendar')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{ url('/booking_calendar') }}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Booking Calendar</span>
                        </a>
                    </div>
                </div>
                 @endcan 
                <!-- Pending Booking for Confirmation -->
                @can('Unconfirmed Bookings')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/pending_booking')}}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-exclamation-circle"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Unconfirmed Bookings</span>
                        </a>
                    </div>
                </div>
                @endcan
            
                <!-- Kitchen Dashboard -->
                {{-- @can('Kitchen Dash Board')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/kichen_dashboard')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Kitchen Dash Board</span>
                        </a>
                    </div>
                </div>
                @endcan
             --}}
                <!-- Outstanding Receivable -->
                @can('Outstanding Receivable')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/outstanding_receivable')}}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-money-bill-wave"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Outstanding Receivable</span>
                        </a>
                    </div>
                </div>
                @endcan
                
                <!-- Outstanding Payable -->
                @can('Outstanding Payable')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/outstanding_payable')}}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Outstanding Payable</span>
                        </a>
                    </div>
                </div>
                @endcan
                <!-- Police Station Report -->
                @can('Police Station Report')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/police_station_report')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Customer Details</span>
                        </a>
                    </div>
                </div>
                @endcan
                <!-- Item Wise Sale Report -->
                @can('Item Wise Sale Report')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('item_wise_sale_report_view')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Item Wise Sale Report</span>
                        </a>
                    </div>
                </div>
               @endcan

                <!-- Day End Report -->
               @can('Day End Report')
                   

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('dayend_report')}}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-clock"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Day End Report</span>
                        </a>
                    </div>
                </div>
                                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('dayend_datewise')}}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-clock"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Day End Date Wise</span>
                        </a>
                    </div>
                </div>

                
                @endcan
            
                <!-- Booking Register -->
                @can('Booking Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('roombooking_register')}}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Booking Register</span>
                        </a>
                    </div>
                </div>
                @endcan
            
                <!-- Check-in Register -->
                @can('Check-in Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('roomcheckins')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Move-in Register</span>
                        </a>
                    </div>
                </div>
                 @endcan
                <!-- Room Food Bills -->
                @can('Room Food Bills')
                    
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('foodbills')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Invoices Bills</span>
                        </a>
                    </div>
                </div>
                 {{-- <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('fnbrerport_pageshow')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">F & B Report</span>
                        </a>
                    </div>
                </div> --}}
               @endcan

                               <!-- Room Food Bills -->
                        @can('Room Food Bills')
            
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <a href="{{url('roomsales_report_pageshow')}}" class="btn btn-success d-flex align-items-center justify-content-start">
                                    <span class="d-flex" style="width: 10%;">
                                        <i class="fas fa-file-invoice"></i>
                                    </span>
                                    <span class="ms-2" style="width: 90%;">Service Report </span>
                                </a>
                            </div>
                        </div>
                        @endcan
               
                <!-- Advance Receipt Register -->
                @can('Advance Receipt Reg')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('advace_receipt')}}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-receipt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Advance Receipt Register</span>
                        </a>
                    </div>
                </div>
                 @endcan
                <!-- Checkout Register -->
                @can('Checkout Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('roomcheckout_register')}}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;"> Moveout Register</span>
                        </a>
                    </div>
                </div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-success text-white mb-4">
        <a href="{{url('payment_register_pageshow')}}" class="btn btn-success d-flex align-items-center justify-content-start">
            <span class="d-flex" style="width: 10%;">
                <i class="fas fa-rupee-sign"></i> <!-- Rupee Icon -->
            </span>
            <span class="ms-2" style="width: 90%;">Payment Register</span>
        </a>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-warning text-white mb-4">
        <a href="{{url('reciept_register_pageshow')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
            <span class="d-flex" style="width: 10%;">
                <i class="fab fa-bitcoin"></i> <!-- Bitcoin Icon -->
            </span>
            <span class="ms-2" style="width: 90%;">Receipt Register</span>
        </a>
    </div>
</div>


                                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('guestlog')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Customer Log</span>
                        </a>
                    </div>
                </div>
                 @endcan
                <!-- Restaurant Food Bills -->
                @can('Restaurant Food Bills')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('table_foodbills')}}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Spare Part Bills</span>
                        </a>
                    </div>
                </div>
                {{-- <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('restaurant_pageshow')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Restaurant Register</span>
                        </a>
                    </div>
                </div> --}}
                @endcan 
                <!-- Kot Register -->
                @can('Kot Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('kots')}}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-receipt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Service Bill Register</span>
                        </a>
                    </div>
                </div>
                @endcan
                <!-- Stock Status -->
                @can('Stock Status')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('inventories')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-warehouse"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Stock Status</span>
                        </a>
                    </div>
                </div>
                {{-- <div class="col-xl-3 col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <a href="{{url('liqour_stock_brand_wise')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-warehouse"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Liqour Stock Brand Wise </span>
                        </a>
                    </div>
                </div> --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('item_wise_stock_pageshow')}}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-warehouse"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Item Wise Stock</span>
                        </a>
                    </div>
                </div>
                @endcan 
                <!-- Store Wise Stock -->
                @can('Store Wise Stock')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('store_wise_stock')}}" class="btn btn-info d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-store"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Store Wise Stock</span>
                        </a>
                    </div>
                </div>
                @endcan
            
                <!-- Stock In Register -->
                @can('Stock In Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('purchases')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-arrow-down"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Stock In Register</span>
                        </a>
                    </div>
                </div>
            
                @endcan
                <!-- Stock Out Register -->
                @can('Stock Out Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('sales')}}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-arrow-up"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Stock Out Register</span>
                        </a>
                    </div>
                </div>
                @endcan
                <!-- Stock Transfer Register -->
                @can('Stock Transfer Register')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('stocktransfers')}}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Stock Transfer Register</span>
                        </a>
                    </div>
                </div>
               @endcan
                <!-- Item List -->
                @can('Item List')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('item')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-box"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Item List</span>
                        </a>
                    </div>
                </div>
                @endcan
            
                <!-- Room List -->
                @can('Room List')
                    
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('rooms')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-bed"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Slot List</span>
                        </a>
                    </div>
                </div>
                @endcan
            
                <!-- Account List -->
                @can('Account List')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('account')}}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Account List</span>
                        </a>
                    </div>
                </div>
                @endcan
                @can('Handover')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('handover_view')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Handover (User Shift)</span>
                        </a>
                    </div>
                </div>
                @endcan
                @can('Mycheckout')
                {{-- <div class="col-xl-3 col-md-6">
                    <div class="card bg-warining text-white mb-4">
                        <a href="{{url('my_checkout_register_pageshow')}}" class="btn btn-warning d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">My Check Out  Register Only</span>
                        </a>
                    </div>
                </div> --}}
                @endcan
                @can('Checkout_Reg')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warining text-white mb-4">
                        <a href="{{url('checkout_register_pageshow')}}" class="btn btn-primary d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">Moveout Out Register Only</span>
                        </a>
                    </div>
                </div>
                @endcan
                @can('GST Report')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <a href="{{url('room_food_gstreport_pageshow')}}" class="btn btn-success d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">GST Report </span>
                        </a>
                    </div>
                </div>
                @endcan
                {{-- @can('B2B Sale')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <a href="{{url('b2bsales_pageshow')}}" class="btn btn-dark d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">B2B Sales Room Checkout </span>
                        </a>
                    </div>
                </div>
                @endcan
                @can('B2C Sale')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <a href="{{url('b2csales_pageshow')}}" class="btn btn-danger d-flex align-items-center justify-content-start">
                            <span class="d-flex" style="width: 10%;">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="ms-2" style="width: 90%;">B2C Sales Room Checkout </span>
                        </a>
                    </div>
                </div>
                @endcan
  --}}
 
            </div>
            
              
            <div class="row">
                {{-- <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div> --}}
                {{-- <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body"><canvas id="myBarChart1" width="100%" height="40"></canvas></div>
                    </div>
                </div> --}}
            </div>

        </div>
    </main>
    