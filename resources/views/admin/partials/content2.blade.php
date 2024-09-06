
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
                        <a href="{{url('/room_dashboard')}}" class="btn btn-success"> Room Dashboard </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/roombookings/create')}}" class="btn btn-warning"> Room Booking </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/roomcheckins/create')}}" class="btn btn-info"> Room Check In  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/roomcheckouts/create')}}" class="btn btn-primary"> Room Checkout </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/kots/create')}}" class="btn btn-warning"> New Kot </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('foodbills/create')}}" class="btn btn-dark"> New Food Bill </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/advace_receipt')}}" class="btn btn-primary">Room Advance Reciept  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/reciepts')}}" class="btn btn-warning"> Reciept  </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/payments')}}" class="btn btn-info">Payment </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/ledgers')}}" class="btn btn-danger">Ledger </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <a href="{{url('/table_dashboard')}}" class="btn btn-info">Restaurant </a>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <a href="{{url('/report_dashboard')}}" class="btn btn-dark">Report </a>

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
                                <th>Room CheckIn  </th>
                                <th>Vacant </th>
                                <th>Occupied</th>
                                <th>Dirty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$roomcheckin}}</td>
                                <td>{{$vacantroom}}</td>
                                <td>{{$occupiedroom}}</td>
                                <td>{{$dirtyroom}}</td>

                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </main>
    