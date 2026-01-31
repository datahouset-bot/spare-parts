@extends('layouts.blank')
@section('pagecontent')

<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

<style>
/* ===================== GLOBAL ===================== */
body {
    background: #f4f6f9;
    font-family: "Segoe UI", Arial, sans-serif;
}

/* ===================== CARD ===================== */
.ledger-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    padding: 15px;
}

/* ===================== COMPANY HEADER ===================== */
.company_info {
    display: none;
    border: 1px solid #000;
    padding: 8px;
    margin-bottom: 6px;
    grid-template-columns: 1fr 4fr 1fr;
}

.company_info img {
    max-width: 80px;
}

.firm_detail {
    text-align: center;
    font-size: 13px;
}

/* ===================== TABLE ===================== */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #1e3a8a !important;
    font-size: 12px;
    padding: 2px 4px !important;
}

thead th {
    background: #f1f5ff;
    font-weight: 700;
}

/* ===================== BUTTON BAR ===================== */
.action-bar {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 15px 0;
}

.action-bar button {
    padding: 6px 18px;
    font-size: 14px;
    border-radius: 20px;
}

/* ===================== PRINT ===================== */
@media print {

    body {
        background: #fff;
    }

    .company_info {
        display: grid;
    }

    .action-bar,
    button,
    .sb-sidenav,
    .navbar,
    .bg-dark,
    .sb-sidenav-footer {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    table {
        page-break-inside: avoid;
    }

    th, td {
        font-size: 11px;
    }
}
</style>

<div class="container-fluid my-2">

    {{-- ALERT --}}
    @if (session('message'))
        <div class="alert alert-danger text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="ledger-card">

        {{-- COMPANY HEADER --}}
        <div class="company_info">
            <div>
                <img src="{{ asset('storage/app/public/image/' . $pic->logo) }}">
            </div>

            <div class="firm_detail">
                <strong>{{ $componyinfo->cominfo_firm_name }}</strong><br>
                {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }}<br>
                {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} {{ $componyinfo->cominfo_pincode }}<br>
                {{ $compinfofooter->country }}<br>
                Mobile: {{ $componyinfo->cominfo_mobile }}
            </div>

            <div style="text-align:right">
                <img src="{{ asset('storage/app/public/image/' . $pic->brand) }}">
            </div>
        </div>

        {{-- LEDGER TABLES --}}
        @foreach ($all_reports as $report)
            <div class="table-responsive mb-4">
                <table data-sheet="{{ $report['account_name'] }}">
                    <thead>
                        <tr>
                            <th colspan="7" style="text-align:center">
                                Ledger : {{ $report['account_name'] }} |
                                Date : {{ \Carbon\Carbon::parse($formatted_current_date)->format('d-m-Y') }}
                            </th>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Account</th>
                            <th>Remark</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $debitBalance = 0;
                            $creditBalance = 0;
                            $runningBalance = $report['final_opning_balance'];
                            $balanceDisplay = abs($runningBalance) . ($runningBalance >= 0 ? ' Dr' : ' Cr');
                        @endphp

                        <tr>
                            <td colspan="6"><strong>Opening Balance</strong></td>
                            <td><strong>{{ $balanceDisplay }}</strong></td>
                        </tr>

                        @foreach ($report['ledgers'] as $ledger)
                            @php
                                $runningBalance += ($ledger->debit - $ledger->credit);
                                $debitBalance += $ledger->debit;
                                $creditBalance += $ledger->credit;
                                $balanceDisplay = abs($runningBalance) . ($runningBalance >= 0 ? ' Dr' : ' Cr');
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ledger->entry_date)->format('d-m-Y') }}</td>
                                <td>{{ $ledger->transaction_type }}</td>
                                <td>{{ $ledger->payment_mode_name }}</td>
                                <td>{{ $ledger->remark }}</td>
                                <td>{{ $ledger->debit }}</td>
                                <td>{{ $ledger->credit }}</td>
                                <td>{{ $balanceDisplay }}</td>
                            </tr>
                        @endforeach

                        <tr style="font-weight:bold;background:#eef2ff">
                            <td>TOTAL</td>
                            <td colspan="3"></td>
                            <td>{{ $debitBalance }}</td>
                            <td>{{ $creditBalance }}</td>
                            <td>{{ $balanceDisplay }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        @endforeach

    </div>

    {{-- ACTION BAR --}}
    <div class="action-bar">
        <button class="btn btn-dark" onclick="window.print()">
            <i class="fa fa-print"></i> Print
        </button>

        <button class="btn btn-success" onclick="exportAllTables()">
            <i class="fa fa-file-excel-o"></i> Export Excel
        </button>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
function exportAllTables() {
    const wb = XLSX.utils.book_new();

    document.querySelectorAll("table").forEach((table, index) => {
        let name = table.getAttribute('data-sheet') || 'Sheet' + (index + 1);
        name = name.replace(/[\[\]\*\/\\\?\:]/g, '').substring(0, 31);
        const ws = XLSX.utils.table_to_sheet(table.cloneNode(true));
        XLSX.utils.book_append_sheet(wb, ws, name);
    });

    XLSX.writeFile(wb, "Ledger_Report_{{ \Carbon\Carbon::now()->format('d-m-Y') }}.xlsx");
}
</script>

@endsection
