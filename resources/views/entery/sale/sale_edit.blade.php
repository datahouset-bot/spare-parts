@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Sale Invoice
        </div>

        <div class="card-body">
            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sales.update', $sale->voucher_no) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Terms --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Terms</label>
                        <input type="text"
                               name="voucher_terms"
                               class="form-control"
                               value="{{ old('voucher_terms', $sale->voucher_terms) }}">
                    </div>

                    {{-- Bill No --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bill No</label>
                        <input type="text"
                               name="voucher_bill_no"
                               class="form-control"
                               value="{{ old('voucher_bill_no', $sale->voucher_bill_no) }}"
                               required>
                    </div>

                    {{-- Bill Date --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bill Date</label>
                        <input type="date"
                               name="voucher_date"
                               class="form-control"
                               value="{{ old('voucher_date', \Carbon\Carbon::parse($sale->voucher_date)->format('Y-m-d')) }}"
                               required>
                    </div>

                    {{-- Party (Account) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Party</label>
                        <select name="account_id" class="form-select" required>
                            <option value="">-- Select Party --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}"
                                    {{ old('account_id', $sale->account_id) == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Total Qty --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Total Qty</label>
                        <input type="number"
                               step="0.01"
                               name="total_qty"
                               class="form-control"
                               value="{{ old('total_qty', $sale->total_qty) }}">
                    </div>

                    {{-- Taxable Amount --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Taxable Amount</label>
                        <input type="number"
                               step="0.01"
                               name="total_item_basic_amount"
                               class="form-control"
                               value="{{ old('total_item_basic_amount', $sale->total_item_basic_amount) }}">
                    </div>

                    {{-- Total Discount --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Total Discount</label>
                        <input type="number"
                               step="0.01"
                               name="total_disc_item_amount"
                               class="form-control"
                               value="{{ old('total_disc_item_amount', $sale->total_disc_item_amount) }}">
                    </div>

                    {{-- Tax Amount --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tax Amount</label>
                        <input type="number"
                               step="0.01"
                               name="total_gst_amount"
                               class="form-control"
                               value="{{ old('total_gst_amount', $sale->total_gst_amount) }}">
                    </div>

                    {{-- Bill Amount --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Bill Amount</label>
                        <input type="number"
                               step="0.01"
                               name="total_net_amount"
                               class="form-control"
                               value="{{ old('total_net_amount', $sale->total_net_amount) }}">
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
