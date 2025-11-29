<style>/* Main menu hover (Dashboard, Master, Entry, Report, etc.) */
.sb-sidenav .nav-link:hover {
    background-color: rgba(0, 255, 0, 0.20) !important;   /* Soft green overlay */
    color: #ffffff !important;
    padding-left: 28px;
    border-left: 4px solid #00ff55;
    transition: all 0.25s ease-in-out;
}

</style>




<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-primary" id="sidenavAccordion" style="background-color:rgb(3, 43, 3)">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link fs-3" href={{ url('/home') }} style="color: white">
                        <div class="sb-nav-link-icon" ><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    {{-- page section  --}}
                    @can('Master')
                        <a class="nav-link collapsed " href="#" data-bs-toggle="collapse" style="color: white; font-size:27px;"
                            data-bs-target="#collapsemaster" aria-expanded="false" aria-controls="collapsemaster">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsemaster" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" style="color: white; font-size:22px;"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Item Master
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav" >
                                        <a class="nav-link" href={{ url('item') }} style="color: white; font-size:24px;">Item</a>
                                        <a class="nav-link" href={{ url('company') }}  style="color: white; font-size:24px;">Company</a>
                                        <a class="nav-link" href={{ url('itemgroups') }}  style="color: white; font-size:24px;">Group</a>
                                        <a class="nav-link" href={{ url('units') }} style="color: white; font-size:24px;">Unit</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"  style="color: white; font-size:22px;"
                                    data-bs-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Account Master
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/account') }}"style="color: white; font-size:24px;">Account</a>
                                        <a class="nav-link" href="{{ url('/accountgroups') }}"  style="color: white; font-size:24px;">Account Group</a>
                                        <a class="nav-link" href="{{ url('/primarygroups') }}"  style="color: white; font-size:24px;">Primary Group</a>
                                    </nav>
                                </div>
                                {{-- @can('Hotel Module') --}}
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#room" aria-expanded="false" aria-controls="room" style="color: white; font-size:22px;">
                                        Service Master
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                {{-- @endcan --}}
                                <div class="collapse" id="room" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/packages') }}" style="color: white; font-size:24px;">Service Type</a>
                                        <a class="nav-link" href="{{ url('/roomtypes') }}" style="color: white; font-size:24px;">Service Plan</a>
                                        <a class="nav-link" href="{{ url('/rooms') }}"  style="color: white; font-size:24px;">Slot</a>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#gst" style="color:white; font-size:22px;"
                                    aria-expanded="false" aria-controls="gst">
                                    Other
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="gst" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        @can('Restaurant Module')
                                            <a class="nav-link" href="{{ url('/tables') }}"  style="color: white; font-size:24px;">Table</a>
                                        @endcan
                                        <a class="nav-link" href="{{ url('/godowns') }}"  style="color: white; font-size:24px;">Godown (Store)</a>
                                        <a class="nav-link" href="{{ url('/account') }}" style="color: white; font-size:24px;">Locker</a>
                                        <a class="nav-link" href="{{ url('/gstmasters') }}"  style="color: white; font-size:24px;">GST,TAX,VAT</a>
                                 
                                            <a class="nav-link" href="{{ url('/businesssources') }}" style="color: white; font-size:24px;">Vehicle Type</a>
                                            <a class="nav-link" href="{{ url('/othercharges') }}"  style="color: white; font-size:24px;">Other Charge</a>
                                 
                                        <a class="nav-link" href="{{ url('/voucher_types') }}"  style="color: white; font-size:24px;">Voucher Type</a>
                                    </nav>
                                </div>



                            </nav>


                        </div>
                    @endcan
                    @can('Entry')
                        {{-- Entery section end  --}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#entery" style="color: white; font-size:27px;"
                            aria-expanded="false" aria-controls="entery">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Entry
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="entery" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"  style="color: white; font-size:22px;"
                                    aria-controls="pagesCollapseAuth">
                                    Vehical Service
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('roombooking_home') }}  style="color: white; font-size:24px;"> Book Slot</a>
                                        <a class="nav-link" href={{ url('roomcheckins') }}  style="color: white; font-size:24px;">Job Card</a>
                                        <a class="nav-link" href={{ url('roomservices') }}  style="color: white; font-size:24px;">Stock Issue </a>
                                        <a class="nav-link" href={{ url('foodbills') }}  style="color: white; font-size:24px;">Invoice</a>
                                        <a class="nav-link" href={{ url('roomcheckouts') }}  style="color: white; font-size:24px;">Gate Pass </a>
                                    </nav>
                                </div>
                                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#bed" aria-expanded="false" aria-controls="bed">
                                Dormitory
                                 <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                             </a>
                             <div class="collapse" id="bed" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                 <nav class="sb-sidenav-menu-nested nav">
                                     <a class="nav-link" href={{url('item')}}>Bed Booking</a>
                                     <a class="nav-link" href={{url('company')}}> Bed Check In</a>
                                     <a class="nav-link" href={{url('itemgroups')}}>Bed Service </a>
                                     <a class="nav-link" href={{url('itemgroups')}}>Advance Reciept </a>
                                     <a class="nav-link" href={{url('itemgroups')}}>Bed Check Out  </a>
                                 </nav>
                             </div> --}}

                                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Spare_parts
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/restaurant_kot') }}">Parts Kot </a>
                                        <a class="nav-link" href="{{ url('/table_dashboard') }}">pendings </a>
                                        <a class="nav-link" href="{{ url('/table_foodbills') }}">Parts Bill
                                        </a>

                                    </nav>
                                </div> --}}

                                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Banquet" aria-expanded="false" aria-controls="Banquet">
                                Banquet Hall 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="Banquet" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/banquets/create')}}">Quotaion</a>
                                    <a class="nav-link" href="404.html">Booking</a>
                                    <a class="nav-link" href="500.html">Invoice</a>
                                </nav>
                            </div> --}}

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#inventory" aria-expanded="false" aria-controls="inventory"  style="color: white; font-size:22px;">
                                    Transection
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="inventory" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                       <a class="nav-link" href="{{ url('/sales') }}"  style="color: white; font-size:24px;">Sale Invoice</a>
                                       <a class="nav-link" href="{{ url('/sales') }}"  style="color: white; font-size:24px;">Quotation</a>
                                       <a class="nav-link" href="{{ url('/sales') }}" style="color: white; font-size:24px;">Estimate Sale</a>
                                       <a class="nav-link" href="{{ url('/sales') }}"   style="color: white; font-size:24px;">Sale Order</a>
                                      <a class="nav-link" href="{{ url('/sales') }}" style="color: white; font-size:24px;">Sale Return</a>
                                        <a class="nav-link" href="{{ url('/purchases') }}" style="color: white; font-size:24px;">Purchase</a>
                                         <a class="nav-link" href="{{ url('/purchases') }}" style="color: white; font-size:24px;">Purchase Order</a>
                                         <a class="nav-link" href="{{ url('/purchases') }}"  style="color: white; font-size:24px;">Purchase Challan</a>
                                         <a class="nav-link" href="{{ url('/purchases') }}"  style="color: white; font-size:24px;">Purchase Return</a>

                                      <a class="nav-link" href="{{ url('/stocktransfers') }}" style="color: white; font-size:24px;">Stock Transfer</a>
 
                                    </nav>
                                </div>


                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"  style="color:white; font-size:22px;"
                                    data-bs-target="#gst" aria-expanded="false" aria-controls="gst">
                                    Fund
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="gst" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/reciepts') }}" style="color: white; font-size:24px;">Reciept
                                        </a>
                                        <a class="nav-link" href="{{ url('/payments') }}"  style="color: white; font-size:24px;">Payment</a>
                                      <a class="nav-link" href="{{ url('/purchases') }}" style="color: white; font-size:24px;">Countra</a>
                                      <a class="nav-link" href="{{ url('/purchases') }}" style="color: white; font-size:24px;">Journal Entry</a>
                                      <a class="nav-link" href="{{ url('/purchases') }}" style="color: white; font-size:24px;">Bank Entry</a>
                                    </nav>
                                </div>

                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"  style="color:white; font-size:22px;"
                                    data-bs-target="#crush" aria-expanded="false" aria-controls="crush">
                                    Crusher
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="crush" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('crusher/create') }}" style="color: white; font-size:20px;">New Entry</a>
                                         <a class="nav-link" href="{{ url('/crusher') }}" style="color: white; font-size:20px;">Challan Details</a>
                                    </nav>
                                </div>

                            </nav>

                        </div>
                    @endcan
                    @can('ReportList')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#report" style="color: white; font-size:27px;"
                            aria-expanded="false" aria-controls="report">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Report
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="report" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                @can('Hotel Module')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" style="color:white; font-size:22px;"
                                        data-bs-target="#room_reprt" aria-expanded="false" aria-controls="room_reprt">
                                        Room Report
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                @endcan
                                <div class="collapse" id="room_reprt" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('booking_calendar') }} style="color: white; font-size:24px;">Booking Calendar</a>
                                        <a class="nav-link" href={{ url('roombooking_home') }} style="color: white; font-size:24px;">Booking Register</a>
                                        <a class="nav-link" href={{ url('roomcheckins') }} style="color: white; font-size:24px;">Check In Register</a>
                                        <a class="nav-link" href={{ url('foodbills') }} style="color: white; font-size:24px;">Room Food Bill</a>
                                        <a class="nav-link" href={{ url('advace_receipt') }} style="color: white; font-size:24px;">Advance Reciept Register</a>
                                        <a class="nav-link" href={{ url('roomcheckout_register') }} style="color: white; font-size:24px;">Check Out Register</a>
                                    </nav>
                                </div>
                                @can('Restaurant Module')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" 
                                        data-bs-target="#reta_report" aria-expanded="false" aria-controls="reta_report" 
                                        style="color:white; font-size:22px;">
                                        Restaurant
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>

                                    <div class="collapse" id="reta_report" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('/table_foodbills') }}"style="color: white; font-size:24px;">Restaurant Register</a>
                                            <a class="nav-link" href={{ url('kichen_dashboard') }} style="color: white; font-size:24px;">Kichen Dashoard </a>

                                        </nav>
                                    </div>
                                @endcan

                                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Banquet_report" aria-expanded="false" aria-controls="Banquet_report">
                                Banquet Hall  Report
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="Banquet_report" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/account')}}">Quotation Report</a>
                                    <a class="nav-link" href="404.html">Booking Report</a>
                                    <a class="nav-link" href="500.html">Invoice Report</a>
                                </nav>
                            </div> --}}

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#stock_report" aria-expanded="false" aria-controls="stock_report" style="color:white; font-size:22px;">
                                    Stock Report
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="stock_report" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/inventories') }}"style="color: white; font-size:24px;">Stock Status </a>
                                        <a class="nav-link" href="{{ url('/store_wise_stock') }}" style="color: white; font-size:24px;">Store Wise Stock </a>
                                        <a class="nav-link" href="{{ url('/purchases') }}" style="color: white; font-size:24px;">Stock In Register</a>
                                        <a class="nav-link" href="{{ url('/sales') }}" style="color: white; font-size:24px;">Stock Out Register</a>
                                        <a class="nav-link" href="{{ url('/stocktransfers') }}" style="color: white; font-size:24px;">Stock Transfer
                                            Register</a>

                                    </nav>
                                </div>


                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#gst" aria-expanded="false" aria-controls="gst" style="color:white; font-size:22px;">
                                    Fund
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="gst" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/ledgers') }}"style="color: white; font-size:24px;">Ledger Report</a>
                                        <a class="nav-link" href="{{ url('/outstanding_receivable') }}" style="color: white; font-size:24px;">Outstanding
                                            Receivable</a>
                                        <a class="nav-link" href="{{ url('/outstanding_payable') }}" style="color: white; font-size:24px;">Oustanding
                                            Payable</a>
                                        @can('Day End Report')
                                            <a class="nav-link" href="{{ url('/dayend_report') }}" style="color: white; font-size:24px;">Day End Report</a>
                                        @endcan



                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#otherreport" aria-expanded="false" aria-controls="otherreport" style="color:white; font-size:22px;">
                                    Other Report
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="otherreport" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/item_wise_sale_report_view') }}"style="color: white; font-size:24px;">Item Wise
                                            Sale </a>



                                    </nav>
                                </div>





                            </nav>



                        </div>
                    @endcan

                    @can('Membership')
                        {{-- entery  section  start  --}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" style="color: white; font-size:27px;"
                            data-bs-target="#collapsePages1" aria-expanded="false" aria-controls="collapsePages1">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            {{ $compinfofooter->ct2 }}
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages1" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth" style="color:white; font-size:22px;">
                                    {{ $compinfofooter->ct2 }} Entry
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('/amcform') }} style="color: white; font-size:24px;">New
                                            {{ $compinfofooter->ct2 }}&nbsp; Entry</a>
                                        <a class="nav-link" href={{ url('/amclist') }} style="color: white; font-size:24px;">{{ $compinfofooter->ct2 }}&nbsp;
                                            Register </a>
                                        <a class="nav-link" href={{ url('/amclist_end_month') }} style="color: white; font-size:24px;">Month Wise End
                                            &nbsp;{{ $compinfofooter->ct2 }} </a>
                                        <a class="nav-link"
                                            href={{ url('/amclist_due') }} style="color: white; font-size:24px;">{{ $compinfofooter->ct2 }}&nbsp; Due list </a>
                                        <a class="nav-link" href={{ url('/amclist_due_month') }} style="color: white; font-size:24px;">Month WiseDue
                                            &nbsp;{{ $compinfofooter->ct2 }} </a>
                                        <a class="nav-link"
                                            href={{ url('/amc_inactive') }} style="color: white; font-size:24px;">{{ $compinfofooter->ct2 }}&nbsp; Inactive </a>
                                        <a class="nav-link" href={{ url('/amc_month_inactive') }} style="color: white; font-size:24px;">Month Wise Inactive </a>


                                    </nav>
                                </div>
                                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Services 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> --}}
                                @can('Lead Module')
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('/testshowform') }}" style="color: white; font-size:24px;">Test Form </a>
                                            <a class="nav-link" href="#" style="color: white; font-size:24px;">Pending Service</a>
                                            <a class="nav-link" href="#" style="color: white; font-size:24px;">New Enquiry</a>
                                            <a class="nav-link" href="#" style="color: white; font-size:24px;">Follow Up</a>
                                            <a class="nav-link" href="#" style="color: white; font-size:24px;">Demo List </a>


                                        </nav>
                                    </div>
                                @endcan
                            </nav>
                        </div>
                    @endcan
                    {{-- entery section end  --}}

                    @can('Activity')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" style="color: white; font-size:27px;"
                            data-bs-target="#collapsemkt" aria-expanded="false" aria-controls="collapsemkt">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Activity
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsemkt" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false" style="color:white; font-size:22px;"
                                    aria-controls="pagesCollapseAuth">
                                    Task & Enquiry
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('todolist') }} style="color: white; font-size:24px;">To Do (Task)</a>
                                        <a class="nav-link" href={{ url('coldcall') }} style="color: white; font-size:24px;">New Enquiry</a>
                                        <a class="nav-link" href={{ url('followup_list') }} style="color: white; font-size:24px;">Follow-Up</a>
                                    </nav>
                                </div>

                        </div>
                    @endcan



                    @can('Setting')

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" style="color: white; font-size:27px;"
                            data-bs-target="#collapsesetting" aria-expanded="false" aria-controls="collapsesetting">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Setting
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsesetting" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth" style="color:white; font-size:22px;">
                                    Company Setting
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('company_info_form') }} style="color: white; font-size:24px;">Company Info </a>
                                        <a class="nav-link" href={{ url('comp_pic_form') }} style="color: white; font-size:24px;">Company Logo</a>
                                        <a class="nav-link" href={{ url('comp_info_footer') }} style="color: white; font-size:24px;">Other Details</a>
                                        <a class="nav-link" href={{ url('optionlists') }} style="color: white; font-size:24px;">Option List</a>
                                        <a class="nav-link" href={{ url('whatsapp_sms') }} style="color: white; font-size:24px;">Whats app & SMS </a>
                                        @can('Hotel Module')
                                            <a class="nav-link" href={{ route('businesssettings.create') }} style="color: white; font-size:24px;">Business
                                                Setting</a>
                                            <a class="nav-link" href="{{ url('financialyears') }}" style="color: white; font-size:24px;">Finacial Year </a>
                                        @endcan

                                        @if (auth()->check() && auth()->user()->email === 'datahouset@gmail.com')
                                            @can('sql_query')
                                                <a class="nav-link" href={{ url('sql_query') }} style="color: white; font-size:24px;">Sql Query</a>
                                            @endcan

                                            <a class="nav-link" href="{{ url('softwarecompanies') }}" style="color: white; font-size:24px;">Software
                                                Companies</a>

                                            <a class="nav-link" href="{{ url('super_comp_lists') }}" style="color: white; font-size:24px;">Super Compny List
                                            </a>

                                            <a class="nav-link" href="{{ url('mantinace_mode') }}" style="color: white; font-size:24px;">Maintenancemode
                                            </a>
                                            
                                            <a class="nav-link" href="{{ url('clear-cache') }}" style="color: white; font-size:24px;">Clear-Cache
                                            </a>
                                        @endif

                                        @if (auth()->check() && Auth::user()->email === Auth::user()->firm_id . '@gmail.com')
                                            <a class="nav-link" href="{{ url('softwarecompanies') }}">Software
                                                Companies</a>
                                        @endif




                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#usersetting" aria-expanded="false" aria-controls="usersetting" style="color:white; font-size:22px;">
                                    User Setting
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="usersetting" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/roles') }}" style="color: white; font-size:24px;">Roles & Permission </a>

                                    </nav>
                                </div>

                                                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#attendance" aria-expanded="false" aria-controls="attendance" style="color:white; font-size:22px;">
                                    Attendance
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="attendance" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/attendance_index') }}" style="color: white; font-size:24px;">Mark Attendance </a>

                                    </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/attendance_report') }}" style="color: white; font-size:24px;">attendance_report </a>

                                    </nav>
                                </div>
                            </nav>
                        </div>
                    @endcan
                           
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" style="color: white; font-size:27px;"
                            data-bs-target="#collapsehelp" aria-expanded="false" aria-controls="collapsehelp">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Help
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsehelp" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth" style="color:white; font-size:22px;">
                                   Software Training
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('helps') }} style="color: white; font-size:24px;">Video Help  </a>
                                        <a class="nav-link" href={{ url('#') }} style="color: white; font-size:24px;">Article</a>
                                        <a class="nav-link" href={{ url('#') }} style="color: white; font-size:24px;">On Call</a>
                                        <a class="nav-link" href={{ url('#') }} style="color: white; font-size:24px;">WhatsApp </a>
                                        <a class="nav-link" href="https://dht.datahouseerp.com/todo_by_customer" style="color: white; font-size:24px;">Support Request</a>
                                       

                                       



                                    </nav>
                                </div>
                            </nav>
                        </div>
  
                </div>



            </div>



            <div class="sb-sidenav-footer" style="color: black; font-size:20px;">
                <div class="small">Logged in as:</div>
                {{-- AMC Management Software  --}}
                {{ $compinfofooter->ct2 }}
            </div>

        </nav>
    </div>
