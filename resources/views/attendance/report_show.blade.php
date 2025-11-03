@extends('layouts.blank')
@section('pagecontent')

<style>
    /* Print Compact Styling */
    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm;
        }
        body {
            font-size: 11px;
        }
        table {
            border-collapse: collapse !important;
            width: 100%;
        }
        th, td {
            border: 1px solid #000 !important;
            padding: 2px 4px !important;
        }
        th {
            background: #f2f2f2 !important;
        }
        tr {
            line-height: 1.1;
        }
        .table-secondary th {
            background: #ddd !important;
        }
        h4, p {
            margin: 2px 0;
            text-align: center;
        }
    }

    /* Screen view styling */
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }
    tr,th, td {
        border: 1px solid #000;
        padding: 3px 5px;
        text-align: center;
    }
    th {
        background-color: #f0f0f0;
    }
    h4, p {
        text-align: center;
        margin-bottom: 5px;
    }
 </style>



@php
    // ऑफिस टाइम (इन और आउट)
    $official_in = $official_in;
    $official_out = $official_out;

    // Helper function for time difference in minutes
    function timeDiffInMinutes($start, $end) {
        if (!$start || !$end) return 0;
        $startTime = strtotime($start);
        $endTime = strtotime($end);
        return round(($endTime - $startTime) / 60);
    }
@endphp

<div class="container">
    <h4>Attendance Report of {{ $user->name }}</h4>
<p><strong>Period:</strong> 
    {{ \Carbon\Carbon::parse($request->start_date)->format('d-m-y') }} 
    to 
    {{ \Carbon\Carbon::parse($request->end_date)->format('d-m-y') }}
</p>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Status</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Late (min)</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_present = $total_absent = $total_half = $total_sunday = $total_late_minutes = 0;
            @endphp

            @foreach($report as $r)
                @php
                    // रंग सेटिंग
                    $color = match($r['status']) {
                        'P' => '#d4edda', // green
                        'A' => '#f8d7da', // red
                        'H' => '#e2d5f5', // purple
                        'S' => '#fff3cd', // orange
                        default => 'white'
                    };

                    // ऑफिस टाइम्स
                    $official_in_time = strtotime($official_in);
                    $official_out_time = strtotime($official_out);

                    // यूज़र के टाइम्स
                    $in_time = $r['in_time'] ? strtotime($r['in_time']) : null;
                    $out_time = $r['out_time'] ? strtotime($r['out_time']) : null;

                    // लेट टाइम कैलकुलेशन
                    $late_in = 0;
                    $early_out = 0;

                    if ($in_time && $in_time > $official_in_time) {
                        $late_in = ($in_time - $official_in_time) / 60;
                    }

                    if ($out_time && $out_time < $official_out_time) {
                        $early_out = ($official_out_time - $out_time) / 60;
                    }

                    $total_late = round($late_in + $early_out);
                    $total_late_minutes += $total_late;

                    // टोटल स्टेटस काउंट
                    if ($r['status'] == 'P') $total_present++;
                    if ($r['status'] == 'A') $total_absent++;
                    if ($r['status'] == 'H') $total_half++;
                    if ($r['status'] == 'S') $total_sunday++;
                @endphp

                <tr style="background-color: {{ $color }}; {{ $r['remark'] ? 'font-weight:bold; border:2px solid black;' : '' }}">
                  <td>{{ \Carbon\Carbon::parse($r['date'])->format('d-m-Y') }}</td>
                    <td>{{ $r['day'] }}</td>
                    <td>{{ $r['status'] }}</td>
                    <td>
                        {{ $r['in_time'] ?? '-' }}
                        <small class="text-muted">({{ $official_in }})</small>
                    </td>
                    <td>
                        {{ $r['out_time'] ?? '-' }}
                        <small class="text-muted">({{ $official_out }})</small>
                    </td>
                    <td>
                        {{ $total_late > 0 ? $total_late . ' min' : '-' }}
                    </td>
                    <td>{{ $r['remark'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot class="table-secondary">
            <tr>
                <th colspan="3">Totals</th>
                <th colspan="2">
                    P: {{ $total_present }} | 
                    A: {{ $total_absent }} | 
                    H: {{ $total_half }} | 
                    S: {{ $total_sunday }}
                </th>
                <th colspan="2">Total Late: {{ $total_late_minutes }} min</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
