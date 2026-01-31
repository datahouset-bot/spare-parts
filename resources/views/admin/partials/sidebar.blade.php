<style>/* ===============================
   PRO SIDEBAR BASE
================================ */
.sb-sidenav {
    background: linear-gradient(180deg, #0b1d33 0%, #061526 100%);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    box-shadow: 4px 0 20px rgba(0,0,0,0.35);
}

/* ===============================
   MAIN LINKS
================================ */
.sb-sidenav .nav-link {
    color: #cfd8e3 !important;
    font-size:29px;
    padding: 14px 22px;
    margin: 4px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.25s ease;
    position: relative;
    
}

/* ICON */
.sb-sidenav .sb-nav-link-icon i {
    font-size: 26px;
    color: #8fa3bf;
    min-width: 18px;
    transition: color 0.25s ease;
}
/* ===============================
   HOVER EFFECT (PRO STYLE)
================================ */
/* .sb-sidenav .nav-link:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff !important;
} */

.sb-sidenav .nav-link:hover i {
    color: #4fc3f7;
}

/* ===============================
   ACTIVE LINK
================================ */
.sb-sidenav .nav-link.active {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: 0 8px 18px rgba(0,0,0,0.35);
}

.sb-sidenav .nav-link.active i {
    color: #ffffff;
}

/* ===============================
   SECTION HEADINGS
================================ */
.sb-sidenav-menu-heading {
    color: #6b8dbd;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 18px 22px 8px;
    text-transform: uppercase;
}

/* ===============================
   SUBMENU CONTAINER
================================ */
.sb-sidenav-menu-nested {
    margin-left: 10px;
}

.shortcut-key {
    margin-left: auto;
    font-size: 19px;
    color: #9fb3c8;
    background: rgba(255,255,255,0.08);
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 600;
}


/* SUBMENU LINKS */
.sb-sidenav-menu-nested .nav-link {
    font-size: 24px;
    padding: 8px 16px 8px 42px;
    margin: 3px 10px;
    color: #b9c7dc !important;
}

/* SUBMENU HOVER */
.sb-sidenav-menu-nested .nav-link:hover {
    background: rgba(255,255,255,0.06);
    color: #ffffff !important;
}

/* ===============================
   DROPDOWN ARROW
================================ */
.sb-sidenav-collapse-arrow i {
    font-size: 18px;
    opacity: 0.6;
    transition: transform 0.25s ease;
}

/* Rotate arrow */
.nav-link:not(.collapsed) .sb-sidenav-collapse-arrow i {
    transform: rotate(90deg);
}

/* ===============================
   FOOTER
================================ */
.sb-sidenav-footer {
    background: rgba(185, 176, 176, 0.25);
    color:red;
    font-size: 18px;
    padding: 12px 18px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.sb-divider {
    margin: 14px 16px;
    border: none;
    height: 1px;
    background: linear-gradient(
        to right,
        rgba(255,255,255,0),
        rgba(255,255,255,0.25),
        rgba(255,255,255,0)
    );
}
/* =====================================
   GLOBAL SIDEBAR WIDTH FIX (SAFE)
===================================== */




</style>


<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-primary" id="sidenavAccordion" style="background-color:rgb(3, 43, 3)">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>

                    {{-- SPARE PARTS MENUS HERE --}}


                    {{-- If user has Crusher Module → redirect to crusher dashboard --}}
                    @can('Crusher Module')
                        <a class="nav-link fs-3" href="{{ url('/crusher') }}" style="color: white">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            REPORTS
                        </a>

                        {{-- If user has Attendance Module → redirect to check-in/out --}}
                    @elseif(auth()->user()->can('Attendance Module'))
                        <a class="nav-link fs-3" href="{{ url('/attendancecheckin') }}" style="color: white">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        {{-- Default Dashboard --}}
                    @else
                        <a class="nav-link fs-3" href="{{ url('/home') }}" style="color: white">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Home
                        </a>
                    @endcan




                    {{-- page section  --}}
                    @can('Master')
                        <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                            style=" ." data-bs-target="#collapsemaster" aria-expanded="false"
                            aria-controls="collapsemaster">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsemaster" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    style=" " data-bs-target="#pagesCollapseError"
                                    aria-expanded="false" aria-controls="pagesCollapseError">
                                    Account Master
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="{{ url('/account') }}"style=" "  title="shortcut:ctrl+A">Account</a>
                                        <a class="nav-link" href="{{ url('/accountgroups') }}"
                                            style=" ">Account Group</a>
                                        <a class="nav-link" href="{{ url('/primarygroups') }}"
                                            style=" ">Primary Group</a>
                                    </nav>
                                </div>

                                @cannot('Crusher Module')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        style=" " data-bs-target="#pagesCollapseAuth"
                                        aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Item Master
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href={{ url('item') }}  title="shortcut:ctrl+I"
                                                style=" ">Item</a>
                                            <a class="nav-link" href={{ url('company') }}
                                                style=" ">Company</a>
                                            <a class="nav-link" href={{ url('itemgroups') }}
                                                style=" ">Group</a>
                                            <a class="nav-link" href={{ url('units') }}
                                                style=" ">Unit</a>
                                        </nav>
                                    </div>

                                    {{-- @can('Hotel Module') --}}
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#room" aria-expanded="false" aria-controls="room"
                                        style=" ">
                                        Service Master
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    {{-- @endcan --}}
                                    <div class="collapse" id="room" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('/packages') }}"
                                                style=" ">Service Type</a>
                                            <a class="nav-link" href="{{ url('/roomtypes') }}"
                                                style=" ">Service Plan</a>
                                            <a class="nav-link" href="{{ url('/rooms') }}"
                                                style=" ">Slot</a>
                                        </nav>
                                    </div>

                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#gst" style="color:white; " aria-expanded="false"
                                        aria-controls="gst">
                                        Other
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="gst" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @can('Restaurant Module')
                                                <a class="nav-link" href="{{ url('/tables') }}"
                                                    style=" ">Table</a>
                                            @endcan
                                            <a class="nav-link" href="{{ url('/godowns') }}"
                                                style=" ">Godown (Store)</a>
                                            <a class="nav-link" href="{{ url('/account') }}"
                                                style=" ">Locker</a>
                                            <a class="nav-link" href="{{ url('/gstmasters') }}"
                                                style=" ">GST,TAX,VAT</a>

                                            <a class="nav-link" href="{{ url('/businesssources') }}"
                                                style=" ">Vehicle Type</a>
                                            <a class="nav-link" href="{{ url('/othercharges') }}"
                                                style=" ">Other Charge</a>

                                            <a class="nav-link" href="{{ url('/voucher_types') }}"
                                                style=" ">Voucher Type</a>
                                        </nav>
                                    </div>
                                @endcannot

                            </nav>


                        </div>
                    @endcan

                    {{-- =============================================== for cctv visit=============================================================================== --}}




                    {{-- ================================================================================================================================================== --}}

                    @can('Entry')
                        {{-- Entery section end  --}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#entery"
                            style=" ." aria-expanded="false" aria-controls="entery">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                            Entry
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="entery" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                {{-- ======================================================================================================= --}}




                                @if (auth()->user()->can('Crusher Module'))
                                    {{-- CRUSHER MENUS HERE --}}
                                    {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        style="color:white; " data-bs-target="#crush"
                                        aria-expanded="false" aria-controls="crush">
                                        Crusher
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="crush" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages"> --}}
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('crusher/create') }}"
                                                style=" ">New Entry</a>
                                            <a class="nav-link" href="{{ url('/crusher') }}"
                                                style=" ">Challan Details</a>
                                            {{-- <a class="nav-link" href="{{ url('/vehicledetail') }}"
                                                style=" ">Vehicle Details</a> --}}
                                            {{-- <a class="nav-link" href="{{ url('vehicledetail/create') }}" style=" ">Vehicle Entry</a> --}}
                                        </nav>
                                    {{-- </div> --}}
                                @endif
                                @cannot('Crusher Module')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#shownew" aria-expanded="false" aria-controls="shownew"
                                        style="color:white; ">
                                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                        Visits
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="shownew" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            {{-- <a class="nav-link" href={{ url('/amcform') }} style=" ">New Entry</a> --}}
                                            <a class="nav-link" href="{{ url('cctv/create') }}"
                                                style=" ">New Entry</a>
                                                <a class="nav-link" href="{{ url('/cctv') }}"
                                                style=" ">Data </a>

                                        </nav>
                                    </div>


                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                        style=" " aria-controls="pagesCollapseAuth">
                                        Vehical Service
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href={{ url('roombooking_home') }}
                                                style=" "> Book Slot</a>
                                            <a class="nav-link" href={{ url('roomcheckins') }}
                                                style=" ">Job Card</a>
                                            <a class="nav-link" href={{ url('roomservices') }}
                                                style=" ">Stock Issue </a>
                                            <a class="nav-link" href={{ url('foodbills') }}
                                                style=" ">Invoice</a>
                                            <a class="nav-link" href={{ url('roomcheckouts') }}
                                                style=" ">Gate Pass </a>
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
                                        data-bs-target="#inventory" aria-expanded="false" aria-controls="inventory"
                                        style=" ">
                                        Transection
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="inventory" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('/sales') }}"
                                                style=" "  title="shortcut:ctrl+S">Sale Invoice</a>
                                            <a class="nav-link" href="{{ url('/quotations') }}"
                                                style=" " title="shortcut:ctrl+S">Quotation</a>
                                            <a class="nav-link" href="{{ url('/sales') }}"
                                                style=" "  title="shortcut:ctrl+S">Estimate Sale</a>
                                            <a class="nav-link" href="{{ url('/sales') }}"
                                                style=" " title="shortcut:ctrl+S">Sale Order</a>
                                            <a class="nav-link" href="{{ url('/sales') }}"
                                                style=" " title="shortcut:ctrl+S">Sale Return</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" " title="shortcut:ctrl+P">Purchase</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" " title="shortcut:ctrl+P">Purchase Order</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" " title="shortcut:ctrl+P">Purchase Challan</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" " title="shortcut:ctrl+P">Purchase Return</a>

                                            <a class="nav-link" href="{{ url('/stocktransfers') }}"
                                                style=" ">Stock Transfer</a>

                                        </nav>
                                    </div>


                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        style="color:white; " data-bs-target="#gst" aria-expanded="false"
                                        aria-controls="gst">
                                        Fund
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="gst" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('/reciepts') }}"
                                                style=" ">Reciept</a>
                                            <a class="nav-link" href="{{ url('/payments') }}"
                                                style=" ">Payment</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" ">Countra</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" ">Journal Entry</a>
                                            <a class="nav-link" href="{{ url('/purchases') }}"
                                                style=" ">Bank Entry</a>
                                        </nav>
                                    </div>
                                @endcannot
                            </nav>
                        </div>

                    @endcan

<hr class="sb-divider">



                    @can('ReportList')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#report"
                            style=" ." aria-expanded="false" aria-controls="report">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                            Report
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="report" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                @can('Hotel Module')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        style="color:white; " data-bs-target="#room_reprt"
                                        aria-expanded="false" aria-controls="room_reprt">
                                        Room Report
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                @endcan
                                <div class="collapse" id="room_reprt" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('booking_calendar') }}
                                            style=" ">Booking Calendar</a>
                                        <a class="nav-link" href={{ url('roombooking_home') }}
                                            style=" ">Booking Register</a>
                                        <a class="nav-link" href={{ url('roomcheckins') }}
                                            style=" ">Check In Register</a>
                                        <a class="nav-link" href={{ url('foodbills') }}
                                            style=" ">Room Food Bill</a>
                                        <a class="nav-link" href={{ url('advace_receipt') }}
                                            style=" ">Advance Reciept Register</a>
                                        <a class="nav-link" href={{ url('roomcheckout_register') }}
                                            style=" ">Check Out Register</a>
                                    </nav>
                                </div>
                                @can('Restaurant Module')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#reta_report" aria-expanded="false" aria-controls="reta_report"
                                        style="color:white; ">
                                        Restaurant
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>

                                    <div class="collapse" id="reta_report" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link"
                                                href="{{ url('/table_foodbills') }}"style=" ">Restaurant
                                                Register</a>
                                            <a class="nav-link" href={{ url('kichen_dashboard') }}
                                                style=" ">Kichen Dashoard </a>

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
                                    data-bs-target="#stock_report" aria-expanded="false" aria-controls="stock_report"
                                    style="color:white; ">
                                    Stock Report
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="stock_report" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="{{ url('/inventories') }}"style=" ">Stock
                                            Status </a>
                                        <a class="nav-link" href="{{ url('/store_wise_stock') }}"
                                            style=" ">Store Wise Stock </a>
                                        <a class="nav-link" href="{{ url('/purchases') }}"
                                            style=" ">Purchase</a>
                                        <a class="nav-link" href="{{ url('/sales') }}"
                                            style=" ">Sale invoice</a>
                                        <a class="nav-link" href="{{ url('/stocktransfers') }}"
                                            style=" ">Stock Transfer
                                            Register</a>

                                    </nav>
                                </div>


                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#gst" aria-expanded="false" aria-controls="gst"
                                    style="color:white; ">
                                    Fund
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="gst" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="{{ url('/ledgers') }}"style=" " title="shortcut:ctrl+L">Ledger
                                            Report</a>
                                        <a class="nav-link" href="{{ url('/outstanding_receivable') }}"
                                            style=" ">Outstanding
                                            Receivable</a>
                                        <a class="nav-link" href="{{ url('/outstanding_payable') }}"
                                            style=" ">Oustanding
                                            Payable</a>
                                        @can('Day End Report')
                                            <a class="nav-link" href="{{ url('/dayend_report') }}"
                                                style=" ">Day End Report</a>
                                        @endcan



                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#otherreport" aria-expanded="false" aria-controls="otherreport"
                                    style="color:white; ">
                                    Other Report
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="otherreport" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="{{ url('/item_wise_sale_report_view') }}"style=" ">Item
                                            Wise
                                            Sale </a>



                                    </nav>
                                </div>
                            </nav>
                        </div>
                    @endcan

                    {{-- @can('Membership')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            style=" ." data-bs-target="#collapsePages1" aria-expanded="false"
                            aria-controls="collapsePages1">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            {{ $compinfofooter->ct2 }}
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages1" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth" style="color:white; ">
                                    {{ $compinfofooter->ct2 }} Entry
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('/amcform') }}
                                            style=" ">New
                                            {{ $compinfofooter->ct2 }}&nbsp; Entry</a>
                                        <a class="nav-link" href={{ url('/amclist') }}
                                            style=" ">{{ $compinfofooter->ct2 }}&nbsp;
                                            Register </a>
                                        <a class="nav-link" href={{ url('/amclist_end_month') }}
                                            style=" ">Month Wise End
                                            &nbsp;{{ $compinfofooter->ct2 }} </a>
                                        <a class="nav-link" href={{ url('/amclist_due') }}
                                            style=" ">{{ $compinfofooter->ct2 }}&nbsp; Due
                                            list </a>
                                        <a class="nav-link" href={{ url('/amclist_due_month') }}
                                            style=" ">Month WiseDue
                                            &nbsp;{{ $compinfofooter->ct2 }} </a>
                                        <a class="nav-link" href={{ url('/amc_inactive') }}
                                            style=" ">{{ $compinfofooter->ct2 }}&nbsp;
                                            Inactive </a>
                                        <a class="nav-link" href={{ url('/amc_month_inactive') }}
                                            style=" ">Month Wise Inactive </a>


                                    </nav>
                                </div>
                             
                                @can('Lead Module')
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ url('/testshowform') }}"
                                                style=" ">Test Form </a>
                                            <a class="nav-link" href="#" style=" ">Pending
                                                Service</a>
                                            <a class="nav-link" href="#" style=" ">New
                                                Enquiry</a>
                                            <a class="nav-link" href="#" style=" ">Follow
                                                Up</a>
                                            <a class="nav-link" href="#" style=" ">Demo
                                                List </a>


                                        </nav>
                                    </div>
                                @endcan
                            </nav>
                        </div>
                    @endcan --}}
                    {{-- entery section end  --}}
<hr class="sb-divider">

                    @can('Activity')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            style=" ." data-bs-target="#collapsemkt" aria-expanded="false"
                            aria-controls="collapsemkt">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                            Activity
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsemkt" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    style="color:white; " aria-controls="pagesCollapseAuth">
                                    Task & Enquiry
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('todolist') }}
                                            style=" ">To Do (Task)</a>
                                        <a class="nav-link" href={{ url('coldcall') }}
                                            style=" ">New Enquiry</a>
                                        <a class="nav-link" href={{ url('followup_list') }}
                                            style=" ">Follow-Up</a>
                                    </nav>
                                </div>

                        </div>
                    @endcan

                    @can('Setting')

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            style=" ." data-bs-target="#collapsesetting" aria-expanded="false"
                            aria-controls="collapsesetting">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                            Setting
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsesetting" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth" style="color:white; ">
                                    Company Setting
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('company_info_form') }}
                                            style=" ">Company Info </a>
                                        <a class="nav-link" href={{ url('comp_pic_form') }}
                                            style=" ">Company Logo</a>
                                        <a class="nav-link" href={{ url('comp_info_footer') }}
                                            style=" ">Other Details</a>
                                        <a class="nav-link" href={{ url('optionlists') }}
                                            style=" ">Option List</a>
                                        <a class="nav-link" href={{ url('whatsapp_sms') }}
                                            style=" ">Whats app & SMS </a>
                                    
                                            <a class="nav-link" href={{ route('businesssettings.create') }}
                                                style=" ">Business
                                                Setting</a>
                                            <a class="nav-link" href="{{ url('financialyears') }}"
                                                style=" ">Finacial Year </a>
                                    

                                        @if (auth()->check() && auth()->user()->email === 'datahouset@gmail.com')
                                            @can('sql_query')
                                                <a class="nav-link" href={{ url('sql_query') }}
                                                    style=" ">Sql Query</a>
                                            @endcan

                                            <a class="nav-link" href="{{ url('softwarecompanies') }}"
                                                style=" ">Software
                                                Companies</a>

                                            <a class="nav-link" href="{{ url('super_comp_lists') }}"
                                                style=" ">Super Compny List
                                            </a>

                                            <a class="nav-link" href="{{ url('mantinace_mode') }}"
                                                style=" ">Maintenancemode
                                            </a>

                                            <a class="nav-link" href="{{ url('clear-cache') }}"
                                                style=" ">Clear-Cache
                                            </a>
                                        @endif

                                        @if (auth()->check() && Auth::user()->email === Auth::user()->firm_id . '@gmail.com')
                                            <a class="nav-link" href="{{ url('softwarecompanies') }}">Software
                                                Companies</a>
                                        @endif




                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#usersetting" aria-expanded="false" aria-controls="usersetting"
                                    style="color:white; ">
                                    User Setting
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="usersetting" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/roles') }}"
                                            style=" ">Roles & Permission </a>

                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#attendance" aria-expanded="false" aria-controls="attendance"
                                    style="color:white; ">
                                    Attendance
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="attendance" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/attendance_index') }}"
                                            style=" ">Mark Attendance </a>
                                    </nav>

                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ url('/attendance_report') }}"
                                            style=" ">attendance/report </a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                    @endcan

                    @can('help')
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            style=" ." data-bs-target="#collapsehelp" aria-expanded="false"
                            aria-controls="collapsehelp">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Help
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsehelp" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth" style="color:white; ">
                                    Software Training
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href={{ url('helps') }}
                                            style=" ">Video Help </a>
                                        <a class="nav-link" href={{ url('#') }}
                                            style=" ">Article</a>
                                        <a class="nav-link" href={{ url('#') }}
                                            style=" ">On Call</a>
                                        <a class="nav-link" href={{ url('#') }}
                                            style=" ">WhatsApp </a>
                                        <a class="nav-link" href="https://dht.datahouseerp.com/todo_by_customer"
                                            style=" ">Support Request</a>




                                    </nav>
                                </div>
                            </nav>
                        </div>
                    @endcan




                @if (auth()->user()->can('Attendance Module'))
                     <a class="nav-link" href="{{ url('attendancecheckin') }}"
                                style=" ">Check In/Out</a>
                        @can('create role')
                                  <a class="nav-link" href="{{ url('attendancephoto') }}"
                                style=" ">Attendance Records</a>
                        <a  class="nav-link" href="{{ url('attendances') }}"  style=" ">
                        Add New Employee</a>
                        @endcan
                        @can('view user')
                            <a class="nav-link" href="{{ url('attendances/create') }}"
                                style=" ">Employee Details</a>
                        @endcan
                      
                    @endif



@if (auth()->user()->can('Staff Management'))
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    style=" " data-bs-target="#pagesCollapseError"
                                    aria-expanded="false" aria-controls="pagesCollapseError">
                                    Staff Management
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('attendancecheckin') }}"
                                style=" ">Check In/Out</a>

                                    @can('create role')
                                <a class="nav-link" href="{{ url('attendancephoto') }}"
                                style=" ">Attendance Records</a>
                        <a  class="nav-link" href="{{ url('attendances') }}"  style=" ">
                        Add New Employee</a>
                        @endcan
                         @can('view user')
                            <a class="nav-link" href="{{ url('attendances/create') }}"
                                style=" ">Employee Details</a>
                        @endcan
                                    </nav>
                                </div>

                </div>
                    @endif



            </div>



            <div class="sb-sidenav-footer" style="color: black; ">
                <div class="small">Logged in as:</div>
                {{-- AMC Management Software  --}}
                {{ $compinfofooter->ct2 }}
            </div>

        </nav>
    </div>
<script>
document.addEventListener('keydown', function (e) {

    // Ignore typing inside inputs
    if (['INPUT','TEXTAREA','SELECT'].includes(e.target.tagName)) return;

    if (e.ctrlKey) {
        switch (e.key.toLowerCase()) {
            case 'd': // Dashboard
                e.preventDefault();
                window.location.href = "{{ url('/home') }}";
                break;

        }
    }
});
</script>
