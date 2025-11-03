@extends('layouts.blank')
@section('pagecontent')
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
        <script src="jquery/master.js"></script>
        <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="jquery/master.js"></script>




        <script>
            $(document).ready(function() {
                let table = new DataTable('#remindtable');

            });
        </script>



    </head>

    <style>
        /* Custom CSS to remove padding from td elements */
        .company_info {
            display: none;
        }



        td {
            padding: 0px !important;
            padding-left: 2px !important;

        }

        th,
        td {
            border: 1px solid darkblue !important;
            text-align: center;
            text-align: left;

        }

        table {
            width: 100%;
        }

        @media print {
            .company_info {
                background-color: yellow;
                display: grid;
                grid-template-columns: 1fr 4fr 1fr;
                border: 1px solid black;
                margin-bottom: 0px;
            }

            .logo1 {}

            .firm_detail {
                text-align: center;

            }

            .logo2 {
                align-content: :flex-end;

            }

            .page_header {
                display: block;
                /* Displayed when printing */
                height: auto;
                /* Changed height to auto */
                width: 190mm;
                /* Width of A4 paper */
                margin: 0px;
                margin-top: 0px;
                padding: 0px;
                border-radius: 2px;
                width: 100%;
                padding: 0in;

            }

            td,
            th {
                border: solid 1px;


            }

            td {
                padding: 0px !important;
                padding-left: 3px !important;

            }


            button,
            #print_button,
            #account_select_form {
                display: none;
            }

            .button-container {
                display: none;
                justify-content: center;
                align-items: center;

            }


            .page {
                size: A4;
                page-break-inside: avoid;
                position: initial;
                margin: 0in 0in 0in 0in;
                width: 100%;
                border: 1px solid;
            }

            .bg-dark,
            .d-flex {
                display: none !important;
            }

            .bg-dark {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>

    <body>


        {{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#recordtable');
  });
  </script> --}}

        <div class="container-fluid my-1">
            @if (session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif

            <div class="row justify-content-center align-items-center form-group">




                <div class="container mt-5" id="account_select_form">
                    <form action="{{ url('ledger_show') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3 mx-2">
                                <select name="account_id" class="form-control" id="account_id" required>
                                    <option value="" selected disabled>Select Account Name</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->account_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">OK</button>

                            </div>


                        </div>

                    </form>

                </div>

                <div class="company_info">
                    <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                            width="80px"></div>
                    <div class="firm_detail">
                        <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
                        <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span><br>
                        <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                            &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;<br>{{ $compinfofooter->country }}</span>
                        <span>Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                            Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} </span>
                    </div>
                    <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->brand) }}" alt="qr_code"
                            width="80px"></div>
                </div>


                <h5>Ledger for Account: {{ $account_name->account_name }} &nbsp; From Date-&nbsp;{{ $from_date }} To
                    Date-&nbsp;{{ $to_date }}</h5>

                <div class= "table-scrollable">

                    <table class ="table table-striped " id="remindtable">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Type</td>
                                <td>Account Name</td>
                                <td>Remark</td>
                                <td>Debit </td>
                                <td>Credit </td>
                                <td>Balance</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php

                                $debitBalance = 0;
                                $creditBalance = 0;
                                $runningBalance=$final_opning_balance;
                                $opening_balanceDisplay = abs($final_opning_balance) . ($final_opning_balance >= 0 ? ' Dr' : ' Cr');

                            @endphp
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Opening Balnce </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ sprintf('%.2f', (float) $opening_balanceDisplay) }}
                                
                                
                                </td>

                            </tr>

                            @foreach ($ledgers as $ledger)
                            <tr>
                                <td scope="col">{{ \Carbon\Carbon::parse($ledger->entry_date)->format('d-m-y') }}</td>
                                <td>{{ $ledger->transaction_type }}</td>
                                <td>{{ $ledger->payment_mode_name }}</td>
                                <td>{{ $ledger->remark }}</td>
                                <td>{{ $ledger->debit }}</td>
                                <td>{{ $ledger->credit }}</td>
                                @php
                                    // Calculate the current balance for this row
                                    $currentBalance = $ledger->debit - $ledger->credit;
                                    // Update the running balance
                                    $debitBalance += $ledger->debit;
                                    $creditBalance += $ledger->credit;
                                    $runningBalance += $currentBalance;
                                    $balanceDisplay = abs($runningBalance) . ($runningBalance >= 0 ? ' Dr' : ' Cr');
                                @endphp
                                <td>{{ $balanceDisplay }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>TOTAL</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $debitBalance }} </td>
                                <td>{{ $creditBalance }} </td>
                                <td>{{ $balanceDisplay }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <h5>Closing Balance ={{ $balanceDisplay }}</h5>

                </div>



            </div>



        </div>

        <div class="row my-2 item-justify-center" id="print_button">
            <button class="btn btn-dark btn-sm" onclick="printInvoice()">Print</button>
        </div>




        <!-- jQuery -->
        <script>
            function printInvoice() {
                window.print();
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script>
            $("#account_id").select2({
                placeholder: "Select Account Name ",
                allowClear: true
            });
        </script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
        <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>

    </body>

    </html>
@endsection
