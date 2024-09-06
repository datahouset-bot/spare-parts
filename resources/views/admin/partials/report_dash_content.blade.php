
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
                        <a href="{{url('item_wise_sale_report')}}" class="btn btn-dark"> Item Wise Sale Report </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('#')}}" class="btn btn-primary">Business Source Wise Report </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('#')}}" class="btn btn-warning"> Month Wise Sale   </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('dayend_report')}}" class="btn btn-info"> Day End Report  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('#')}}" class="btn btn-danger">Bank Book  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/report_dashboard')}}" class="btn btn-dark">Report </a>

                    </div>
                </div>
            </div>
              
            <div class="row">
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
            </div>

        </div>
    </main>
    