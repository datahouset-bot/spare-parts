
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

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/booking_calendar')}}" class="btn btn-success"> Booking Calander </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/kichen_dashboard')}}" class="btn btn-warning">Kichen Dash Board</a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/outstanding_receivable')}}" class="btn btn-info"> Out Standing Receivable  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/outstanding_payable')}}" class="btn btn-primary"> Outstanding Payable</a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/police_station_report')}}" class="btn btn-warning"> Police Station Report  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('item_wise_sale_report_view')}}" class="btn btn-dark"> Item Wise Sale Report </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('dayend_report')}}" class="btn btn-danger"> Day End Report  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('roombooking_home')}}" class="btn btn-success"> Booking Register  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('roomcheckins')}}" class="btn btn-dark"> Check in Register  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('foodbills')}}" class="btn btn-warning">Room Food Bills  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('advace_receipt')}}" class="btn btn-info"> Advance Reciept Register   </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('roomcheckout_register')}}" class="btn btn-primary"> Checkout Register  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('table_foodbills')}}" class="btn btn-success"> Restaurent Food Bills  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('kots')}}" class="btn btn-danger"> Kot Register  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('inventories')}}" class="btn btn-warning"> Stock Status  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('store_wise_stock')}}" class="btn btn-info"> Store Wise Stock</a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('purchases')}}" class="btn btn-dark">Stock In Register  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('sales')}}" class="btn btn-primary"> Stock Out Register  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('stocktransfers')}}" class="btn btn-success"> Stock Transfer Register   </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('item')}}" class="btn btn-warning"> Item List  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('rooms')}}" class="btn btn-dark"> Room List  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('account')}}" class="btn btn-danger"> Account List  </a>

                    </div>
                </div>
                
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
    