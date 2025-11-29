@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script>
        < script >
            $(document).ready(function() {
                let table = new DataTable('#remindtable');
            });
    </script>



    @extends('layouts.blank')
    {{-- @include('layouts.blank') --}}
@section('pagecontent')
    <style>
        .visible0 {
            display: none;
        }

        #batch_record td {
            padding: 0;
            border: 2px solid blue;
            padding-left: 3px;
        }
    </style>

    <div class="container ">

        <body class="bg-primary">
            <div id="layoutAuthentication">
                <div id="layoutAuthentication_content">
                    <main>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="card shadow-lg border-0 rounded-lg mt-0">
                                        <div class="card-header">
                                            <h3 class="text-center font-weight-light ">Edit Item</h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ url('/edititem') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div> <input type="hidden" value="{{ $data['id'] }}" name="id">
                                                </div>

                                                <div class="row mb-3">
    <div class="col-md-8 col-9 text-center">
        <div class="form-group">
            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $data['item_name'] }}" placeholder=" " required autocomplete="off">
            <label class="floating-label" for="item_name">Item/Product Name</label>
            <span class="text-danger">@error('item_name'){{ $message }}@enderror</span>
        </div>
    </div>

    <div class="col-md-4 col-3 text-center">
        <div class="form-group">
            <input type="text" class="form-control" id="item_barcode" name="item_barcode" value="{{ $data['id'] }}" placeholder=" " required autocomplete="off">
            <label class="floating-label" for="item_barcode">Barcode</label>
            <span class="text-danger">@error('item_barcode'){{ $message }}@enderror</span>
        </div>
    </div>

    <div class="col-md-3 mt-2">
        <div class="form-group">
            <select name="company_id" id="company" class="mycompany form-select" required>
                <option value="" disabled>Select Company</option>
                @foreach ($companydata as $record)
                    <option value="{{ $record['id'] }}" {{ isset($data) && $data->company_id == $record['id'] ? 'selected' : '' }}>
                        {{ $record['comp_name'] }}
                    </option>
                @endforeach
            </select>
            <label class="floating-label" for="company">Company</label>
            <span class="text-danger">@error('company_id'){{ $message }}@enderror</span>
        </div>
    </div>

    <div class="col-md-3 mt-2">
        <div class="form-group">
            <select name="group_id" id="myitemgroup" class="myitemgroup form-select" required>
                <option value="" disabled>Select Group</option>
                @foreach ($itemgroupdata as $record)
                    <option value="{{ $record['id'] }}" {{ isset($data) && $data->group_id == $record['id'] ? 'selected' : '' }}>
                        {{ $record['item_group'] }}
                    </option>
                @endforeach
            </select>
            <label class="floating-label" for="myitemgroup">Item Group</label>
            <span class="text-danger">@error('group_id'){{ $message }}@enderror</span>
        </div>
    </div>

    @php
        $fields = [
            ['mrp', 'MRP'],
            ['sale_rate', 'Sale Rate'],
            ['sale_rate_a', 'Rate A'],
            ['sale_rate_b', 'Rate B'],
            ['sale_rate_c', 'Rate C'],
            ['purchase_rate', 'Purchase Rate'],
        ];
    @endphp

    @foreach ($fields as [$field, $label])
    <div class="col-md-2 mt-2">
        <div class="form-group">
            <input class="form-control" id="{{ $field }}" name="{{ $field }}" type="text" value="{{ $data[$field] ?? '' }}" placeholder=" " >
            <label class="floating-label" for="{{ $field }}">{{ $label }}</label>
            <span class="text-danger">@error($field){{ $message }}@enderror</span>
        </div>
    </div>
    @endforeach

    <div class="col-md-2 mt-2">
        <div class="form-group">
            <select name="unit_id" id="unit" class="form-select" required>
                <option disabled selected>Select Unit</option>
                @foreach ($unit as $u)
                    <option value="{{ $u->id }}" {{ isset($data) && $data->unit_id == $u->id ? 'selected' : '' }}>
                        {{ $u->primary_unit_name }}
                    </option>
                @endforeach
            </select>
            <label class="floating-label" for="unit">Unit</label>
            <span class="text-danger">@error('unit_id'){{ $message }}@enderror</span>
        </div>
    </div>

    <div class="col-md-2 mt-2">
        <div class="form-group">
            <select name="item_gst_id" id="item_gst" class="form-select" required>
                <option disabled selected>GST / Tax %</option>
                @foreach ($gstmaster as $gst)
                    <option value="{{ $gst->id }}" {{ isset($data) && $data->item_gst_id == $gst->id ? 'selected' : '' }}>
                        {{ $gst->taxname }}
                    </option>
                @endforeach
            </select>
            <label class="floating-label" for="item_gst">GST / Tax %</label>
            <span class="text-danger">@error('item_gst_id'){{ $message }}@enderror</span>
        </div>
    </div>
</div>




                                                    {{-- <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="unit" type="text" name="unit" value="{{ old('unit') }}" />
                                                      <span class="text-danger"> 
                                                        @error('unit')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="unit">Unit</label>
                                                       
                                                    </div> --}}

                                                </div>


                                        </div>






                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit"class="btn btn-primary btn-block">Update</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    @php
                                        $fields = [
                                            'batch_no',
                                            'batch_af1',
                                            'batch_af2',
                                            'batch_af3',
                                            'batch_af4',
                                            'batch_af5',
                                            'mfg_date',
                                            'exp_date',
                                            'batch_mrp',
                                            'batch_sale_rate',
                                            'batch_basic_rate',
                                            'batch_a_rate',
                                            'batch_b_rate',
                                            'batch_c_rate',
                                            'batch_purchase_rate',
                                            'batch_op_qty',
                                            'batch_op_value',
                                            'batch_barcode',
                                            'batch_op_remark',
                                            'rack',
                                        ];
                                    @endphp
                                    <div class="table-scrollable">
                                        <form id="batch_form">

                                            <table class="table table-light table-bordered">
                                                <tr>
                                                    <input type="hidden" value="{{ $data['id'] }}" name="item_id"
                                                        id="item_id">
                                                        <input type="hidden" id="editing_id" name="editing_id">
                                                    @foreach ($fields as $field)
                                                        @php
                                                            $setting = $labelsetting->firstWhere('field_name', $field);
                                                        @endphp
                                                        @if ($setting)
                                                            <td class="visible{{ $setting->is_visible }}">
                                                                <div class="form-group">
                                                                    <input type="text" name="{{ $field }}"
                                                                        id="{{ $field }}"
                                                                        class="form-control     visible{{ $setting->is_visible }} ">
                                                                    <label
                                                                        class="floating-label visible{{ $setting->is_visible }}">{{ $setting->replaced_field_name ?? $field }}</label>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    <td>
                                                        <button id="batch_save" type="submit"
                                                            class="btn btn-primary btn-block">+</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>


                                    <table id ="batch_record" class="table table-light table-bordered">
                                        <tr>
                                            @foreach ($fields as $field)
                                                @php
                                                    $setting = $labelsetting->firstWhere('field_name', $field);
                                                @endphp
                                                @if ($setting)
                                                    <td class="visible{{ $setting->is_visible }}">
                                                        {{ $setting->replaced_field_name ?? $field }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td></td>
                                        </tr>
                                    </table>

















                                    <script></script>


                                    <!-- jQuery -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                    <!-- Select2 -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
                                    <script>
                                        $('.myitemgroup').chosen();
                                        $('.mycompany').chosen();
                                    </script>
                                    <link rel="stylesheet"
                                        href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
                                    <link rel="stylesheet" href="/resources/demos/style.css">
                                    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
                                    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>



                    

                    <script type="text/javascript">
    const visibleFields = @json($labelsetting->filter(fn($s) => $s->is_visible == 1)->pluck('field_name')->values());

    function fetchAndDisplayRecords(item_id) {
        $('#batch_record tbody').empty();

        $.ajax({
            url: '/batchs/' + item_id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 200) {
                    var batchrecords = response.batchrecords;

                    batchrecords.forEach(function(record) {
                        var row = '<tr>';

                        visibleFields.forEach(function(field) {
                            row += `<td>${record[field] ?? ''}</td>`;
                        });

                        row += `
                            <td>
                                <button class="btn btn-info btn-sm edit-record" data-id="${record.id}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-record" data-id="${record.id}">Delete</button>
                            </td>
                        `;

                        row += '</tr>';
                        $('#batch_record tbody').append(row);
                    });
                } else {
                    alert('Failed to fetch records');
                }
            },
            error: function() {
                alert('Error fetching records');
            }
        });
    }

    $(document).ready(function() {
        var initialitem_id = $("#item_id").val();
        if (initialitem_id) {
            fetchAndDisplayRecords(initialitem_id);
        }

        // Submit Form (Create or Update)
        $('#batch_form').submit(function(e) {
            e.preventDefault();
            var editingId = $('#editing_id').val();

            var data = {
                item_id: $('#item_id').val(),
                batch_no: $('#batch_no').val(),
                batch_af1: $('#batch_af1').val(),
                batch_af2: $('#batch_af2').val(),
                batch_af3: $('#batch_af3').val(),
                batch_af4: $('#batch_af4').val(),
                batch_af5: $('#batch_af5').val(),
                mfg_date: $('#mfg_date').val(),
                exp_date: $('#exp_date').val(),
                batch_mrp: $('#batch_mrp').val(),
                batch_sale_rate: $('#batch_sale_rate').val(),
                batch_basic_rate: $('#batch_basic_rate').val(),
                batch_a_rate: $('#batch_a_rate').val(),
                batch_b_rate: $('#batch_b_rate').val(),
                batch_c_rate: $('#batch_c_rate').val(),
                batch_purchase_rate: $('#batch_purchase_rate').val(),
                batch_op_qty: $('#batch_op_qty').val(),
                batch_op_value: $('#batch_op_value').val(),
                batch_barcode: $('#batch_barcode').val(),
                batch_op_remark: $('#batch_op_remark').val(),
                rack: $('#rack').val(),
                _token: '{{ csrf_token() }}'
            };

            let url = '/batchs';
            let method = 'POST';

            if (editingId) {
                url = '/batchs/' + editingId;
                data._method = 'PUT';
            }

            $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        fetchAndDisplayRecords($('#item_id').val());
                        $('#batch_form')[0].reset();
                        $('#editing_id').val('');
                    } else {
                        alert('Save failed');
                    }
                },
                error: function() {
                    alert('Error saving record');
                }
            });
        });

        // DELETE
        $(document).on('click', '.delete-record', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: '/batchs/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.status === 200) {
                            fetchAndDisplayRecords($('#item_id').val());
                        } else {
                            alert('Delete failed');
                        }
                    },
                    error: function() {
                        alert('Error deleting record');
                    }
                });
            }
        });

        // EDIT
        $(document).on('click', '.edit-record', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/batchs/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        var record = response.data;

                        $('#editing_id').val(record.id);
                        $('#item_id').val(record.item_id);
                        $('#batch_no').val(record.batch_no);
                        $('#batch_af1').val(record.batch_af1);
                        $('#batch_af2').val(record.batch_af2);
                        $('#batch_af3').val(record.batch_af3);
                        $('#batch_af4').val(record.batch_af4);
                        $('#batch_af5').val(record.batch_af5);
                        $('#mfg_date').val(record.mfg_date);
                        $('#exp_date').val(record.exp_date);
                        $('#batch_mrp').val(record.batch_mrp);
                        $('#batch_sale_rate').val(record.batch_sale_rate);
                        $('#batch_basic_rate').val(record.batch_basic_rate);
                        $('#batch_a_rate').val(record.batch_a_rate);
                        $('#batch_b_rate').val(record.batch_b_rate);
                        $('#batch_c_rate').val(record.batch_c_rate);
                        $('#batch_purchase_rate').val(record.batch_purchase_rate);
                        $('#batch_op_qty').val(record.batch_op_qty);
                        $('#batch_op_value').val(record.batch_op_value);
                        $('#batch_barcode').val(record.batch_barcode);
                        $('#batch_op_remark').val(record.batch_op_remark);
                        $('#rack').val(record.rack);
                    }
                },
                error: function() {
                    alert('Error fetching record for edit');
                }
            });
        });
    });
</script>




@endsection
