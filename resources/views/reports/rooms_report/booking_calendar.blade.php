@extends('layouts.blank')

@section('pagecontent')

<style>
/* =========================
   PAGE BACKGROUND
========================= */
body {
    background: #f4f6f9;
    font-family: "Segoe UI", Arial, sans-serif;
}

/* =========================
   TABLE WRAPPER
========================= */
.table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
    background: #fff;
}

/* =========================
   TABLE BASE
========================= */
.table {
    margin-bottom: 0;
    font-size: 13px;
    white-space: nowrap;
    border-collapse: collapse;
}

/* =========================
   HEADER
========================= */
.table thead th {
    position: sticky;
    top: 0;
    background: #1e293b;
    color: #fff;
    text-align: center;
    font-weight: 600;
    z-index: 3;
    padding: 8px;
}

/* Sticky first column */
.table thead th:first-child,
.table tbody td:first-child {
    position: sticky;
    left: 0;
    background: #f8fafc;
    font-weight: 600;
    z-index: 2;
}

/* =========================
   CELLS
========================= */
.table td {
    text-align: center;
    padding: 6px;
    border: 1px solid #e5e7eb;
    min-width: 36px;
}

/* =========================
   STATUS COLORS
========================= */
.booked {
    background: #16a34a;
    color: #fff;
    font-weight: bold;
    border-radius: 4px;
}

.vacant {
    background: #f1f5f9;
    color: #64748b;
}

/* =========================
   ROW HOVER
========================= */
.table tbody tr:hover td {
    background: #eff6ff;
}

/* =========================
   LEGEND
========================= */
.legend {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
    font-size: 14px;
}

.legend span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.legend-box {
    width: 16px;
    height: 16px;
    border-radius: 4px;
}

/* =========================
   ALERT
========================= */
.alert {
    border-radius: 10px;
}

/* =========================
   MOBILE
========================= */
@media (max-width: 768px) {
    .table {
        font-size: 12px;
    }
}
</style>

<div class="container mt-4">

    {{-- MESSAGE --}}
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (isset($message))
                <div class="alert alert-info text-center">
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>

    {{-- LEGEND --}}
    <div class="legend">
        <span>
            <div class="legend-box booked"></div> Booked
        </span>
        <span>
            <div class="legend-box vacant"></div> Vacant
        </span>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Room No</th>
                    @php
                        $current_date = clone $currentDate;
                        for ($i = 0; $i < 30; $i++) {
                            echo '<th>' . $current_date->format('d-m') . '</th>';
                            $current_date->modify('+1 day');
                        }
                    @endphp
                </tr>
            </thead>

            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->room_no }}</td>

                        @php
                            $current_date = clone $currentDate;

                            for ($i = 0; $i <= 30; $i++) {
                                $roomNo = $room->room_no;

                                $isBooked = $roombookings
                                    ->where('room_no', $roomNo)
                                    ->where('checkin_date', '<=', $current_date)
                                    ->where('checkout_date', '>=', $current_date)
                                    ->count() > 0;

                                if ($isBooked) {
                                    echo "<td class='booked'>B</td>";
                                } else {
                                    echo "<td class='vacant'>-</td>";
                                }

                                $current_date->modify('+1 day');
                            }
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>

@endsection
