<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link" href={{url('/home')}}>
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    {{-- page section  --}}
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsemaster" aria-expanded="false" aria-controls="collapsemaster">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Master
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsemaster" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                              Item Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href={{url('item')}}>Item</a>
                                    <a class="nav-link" href={{url('company')}}>Company</a>
                                    <a class="nav-link" href={{url('itemgroups')}}>Group</a>
                                    <a class="nav-link" href={{url('units')}}>Unit</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Account Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/account')}}">Account</a>
                                    <a class="nav-link" href="{{url('/accountgroups')}}">Account Group</a>
                                    <a class="nav-link" href="{{url('/primarygroups')}}">Primary Group</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#room" aria-expanded="false" aria-controls="room">
                                Room Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="room" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/packages')}}">Package</a>
                                    <a class="nav-link" href="{{url('/roomtypes')}}">Room Type</a>
                                    <a class="nav-link" href="{{url('/rooms')}}">Room</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#gst" aria-expanded="false" aria-controls="gst">
                                Other 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="gst" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/tables')}}">Table</a>
                                    <a class="nav-link" href="{{url('/godowns')}}">Godown (Store)</a>
                                    <a class="nav-link" href="{{url('/account')}}">Locker</a>
                                    <a class="nav-link" href="{{url('/gstmasters')}}">GST,TAX,VAT</a>
                                    <a class="nav-link" href="{{url('/businesssources')}}">Business Source</a>
                                    <a class="nav-link" href="{{url('/othercharges')}}">Other Charge</a>
                                    <a class="nav-link" href="{{url('/voucher_types')}}">Voucher Type</a>
                                </nav>
                            </div>



                        </nav>



                    </div>

                    {{-- Entery section end  --}}
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#entery" aria-expanded="false" aria-controls="entery">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Entry
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="entery" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                               Room 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href={{url('roombooking_home')}}>Booking</a>
                                    <a class="nav-link" href={{url('roomcheckins')}}>Check In</a>
                                    <a class="nav-link" href={{url('roomservices')}}>Room Service </a>
                                    <a class="nav-link" href={{url('advace_receipt')}}>Advance Receipt </a>
                                    <a class="nav-link" href={{url('roomcheckouts')}}>Check Out </a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#bed" aria-expanded="false" aria-controls="bed">
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
                             </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Restaurant
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/table_dashboard')}}">Restaurant </a>
                                    <a class="nav-link" href="{{url('/table_foodbills')}}">Restaurant Food Bill </a>
                                    <a class="nav-link" href="500.html">Token</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Banquet" aria-expanded="false" aria-controls="Banquet">
                                Banquet Hall 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="Banquet" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/banquets/create')}}">Quotaion</a>
                                    <a class="nav-link" href="404.html">Booking</a>
                                    <a class="nav-link" href="500.html">Invoice</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#inventory" aria-expanded="false" aria-controls="inventory">
                                Stock
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="inventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/purchases')}}">Purchase</a>
                                    <a class="nav-link" href="404.html">Stock  Transfer</a>
                                    <a class="nav-link" href="{{url('/sales')}}">Stock Issue</a>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#gst" aria-expanded="false" aria-controls="gst">
                                Fund  
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="gst" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/reciepts')}}">Reciept 
                                    </a>
                                    <a class="nav-link" href="{{url('/payments')}}">Payment</a>


                                    
                                    
                                </nav>
                            </div>

                            



                        </nav>



                    </div>
                   
                    
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#report" aria-expanded="false" aria-controls="report">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Report
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="report" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#room_reprt" aria-expanded="false" aria-controls="room_reprt">
                               Room Report 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="room_reprt" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href={{url('booking_calendar')}}>Booking Calendar</a>
                                    <a class="nav-link" href={{url('kichen_dashboard')}}>Kichen Dashoard </a>
                                    <a class="nav-link" href={{url('itemgroups')}}>Room Service  Report</a>
                                    <a class="nav-link" href={{url('itemgroups')}}>Advance Reciept  Report</a>
                                    <a class="nav-link" href={{url('itemgroups')}}>Check Out  Report</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#reta_report" aria-expanded="false" aria-controls="reta_report">
                                Restaurant
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="reta_report" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/account')}}">Restaurant Bill Report</a>
                                    <a class="nav-link" href="404.html">Parcel Report</a>
                                    <a class="nav-link" href="500.html">Token Report</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Banquet_report" aria-expanded="false" aria-controls="Banquet_report">
                                Banquet Hall  Report
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="Banquet_report" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/account')}}">Quotation Report</a>
                                    <a class="nav-link" href="404.html">Booking Report</a>
                                    <a class="nav-link" href="500.html">Invoice Report</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#stock_report" aria-expanded="false" aria-controls="stock_report">
                                Stock Report
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="stock_report" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/inventories')}}">Stock Status </a>
                                    <a class="nav-link" href="{{url('/store_wise_stock')}}">Store Wise Stock </a>
                                    <a class="nav-link" href="{{url('/sales')}}">Stock Issue</a>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#gst" aria-expanded="false" aria-controls="gst">
                                Fund  
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="gst" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/outstanding_receivable')}}">Outstanding Receivable</a>
                                    <a class="nav-link" href="{{url('/outstanding_payable')}}">Oustanding Payable</a>
                                    <a class="nav-link" href="{{url('/ledgers')}}">Ledger Report</a>

                                    
                                    
                                </nav>
                            </div>

                            



                        </nav>



                    </div>



                    {{-- entery  section  start  --}}
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages1" aria-expanded="false" aria-controls="collapsePages1">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        {{ $compinfofooter->ct2 }}
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages1" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                {{ $compinfofooter->ct2 }} Entry
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href={{url('/amcform')}}>New {{ $compinfofooter->ct2 }}&nbsp; Entry</a>
                                    <a class="nav-link" href={{url('/amclist')}}>{{ $compinfofooter->ct2 }}&nbsp; Register </a>
                                    <a class="nav-link" href={{url('/amclist_end_month')}}>Month Wise End &nbsp;{{ $compinfofooter->ct2 }} </a>
                                    <a class="nav-link" href={{url('/amclist_due')}}>{{ $compinfofooter->ct2 }}&nbsp; Due list </a>
                                    <a class="nav-link" href={{url('/amclist_due_month')}}>Month WiseDue &nbsp;{{ $compinfofooter->ct2 }}  </a>
                                    <a class="nav-link" href={{url('/amc_inactive')}}>{{ $compinfofooter->ct2 }}&nbsp; Inactive </a>
                                    <a class="nav-link" href={{url('/amc_month_inactive')}}>Month Wise Inactive </a>


                                    <a class="nav-link" href={{url('/amclisttest')}}>amc list test   </a>
                                </nav>
                            </div>
                            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Services 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> --}}
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{url('/testshowform')}}">Test Form  </a>
                                    <a class="nav-link" href="#">Pending Service</a>
                                    <a class="nav-link" href="#">New Enquiry</a>
                                    <a class="nav-link" href="#">Follow Up</a>
                                    <a class="nav-link" href="#">Demo List </a>


                                </nav>
                            </div>
                        </nav>
                    </div>
                  {{-- entery section end  --}}


                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsemkt" aria-expanded="false" aria-controls="collapsemkt">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Activity
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsemkt" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                         Task & Enquiry
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href={{url('todolist')}}>To Do (Task)</a>
                                <a class="nav-link" href={{url('coldcall')}}>New Enquiry</a>
                                <a class="nav-link" href={{url('followup_list')}}>Follow-Up</a>
                            </nav>
                        </div>
                        
                </div>






                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsesetting" aria-expanded="false" aria-controls="collapsesetting">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Setting
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsesetting" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Company Setting
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> 
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href={{url('company_info_form')}}>Company Info </a>
                                    <a class="nav-link" href={{url('comp_pic_form')}}>Company Logo</a>
                                    <a class="nav-link" href={{url('comp_info_footer')}}>Other Details</a>
                                    <a class="nav-link" href={{url('optionlists')}}>Option List</a>
                                    <a class="nav-link" href={{route('businesssettings.create')}}>Business Setting</a>
                                    <a class="nav-link" href={{url('sql_query')}}>Sql Query</a>
                                    
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#usersetting" aria-expanded="false" aria-controls="usersetting">
                                User Setting
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="usersetting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/roles') }}">Roles & Permission </a>

                                </nav>
                            </div>
                        </nav>
                    </div>

                </div>

                
            </div>
            
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                {{-- AMC Management Software  --}}
                {{ $compinfofooter->ct2 }}
            </div>
        </nav>
    </div>

   
     