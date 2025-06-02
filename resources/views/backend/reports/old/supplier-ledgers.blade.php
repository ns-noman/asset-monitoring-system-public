@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Supplier Ledgers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supplier Ledgers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Supplier Ledgers</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control" required
                                            @isset($data['purchase']) @disabled(true) @endisset>
                                            <option supplier-name="All Supplier" value="0" selected>All Supplier</option>
                                            @foreach ($data['suppliers'] as $supplier)
                                                <option supplier-name="{{ $supplier->name }}" value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>From Date</label>
                                        <input name="from_date" id="from_date" type="date" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>To Date</label>
                                        <input name="to_date" id="to_date" type="date" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3 col-lg-3">
                                        <label>&nbsp;</label>
                                        <button ame="print" id="print" type="button" class="form-control btn btn-primary">Print</button>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12" id="printable">
                                        <div id="print_header" hidden>
                                            <div class="row justify-content-center">
                                                <div class="col-12 text-center">
                                                    <h1>Supplier Ledger Report</h1>
                                                </div>
                                                <div class="col-12">
                                                    <h4>Description: <span id="description"></span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bootstrap-data-table-panel text-center">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-centre">
                                                    <thead id="thead">
                                                    </thead>
                                                    <tbody id="tbody">
                                                    </tbody>
                                                    <tfoot id="tfoot">
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('#print').click(function() {
                let supplier_id = $('#supplier_id').val();
                let from_date = $('#from_date').val();
                let to_date = $('#to_date').val();
                let supplier_name = $('#supplier_id option:selected').attr('supplier-name');
                if(supplier_id==0){
                    $('#description').html(`${supplier_name} Ledeger.`);
                }else{
                    let description = `${supplier_name} Ledeger`;
                    if(from_date){
                        description += ` from ${from_date}`;
                        if(to_date){
                            description += ` to ${to_date}`;
                        }
                    }
                    description += `.`;
                    $('#description').html(description);
                }
                // Prepare for printing by expanding the table and showing hidden elements
                let originalOverflow = $('.table-responsive').css('overflow');
                let originalMaxHeight = $('.table-responsive').css('max-height');
                $('.table-responsive').css({
                    'overflow': 'visible',
                    'max-height': 'none'
                });
                $('#print_header').prop('hidden', false);
                var printContents = $('#printable').html();
                $('#print_header').prop('hidden', true);
                var originalContents = $('body').html();
                $('body').html(printContents);
                window.print();
                $('body').html(originalContents);
                // Restore the original state
                $('.table-responsive').css({
                    'overflow': originalOverflow,
                    'max-height': originalMaxHeight
                });
            });
        });


        $(document).ready(function(){
            initialize();
            $('#supplier_id, #from_date, #to_date').on('change', function (event) {
                const data = getFormData();
                nsSetItem("supplierLedgerSearchKeys",data);
                getData(data);
            });
        });

        function initialize() {
            const defaultData = {supplier_id: 0,from_date: null,to_date: null};
            const data = nsGetItem("supplierLedgerSearchKeys") || defaultData;
            $('#supplier_id').val(data.supplier_id);
            $('#from_date').val(data.from_date);
            $('#to_date').val(data.to_date);
            nsSetItem("supplierLedgerSearchKeys",data);
            getData(data);
        }
        async function getData(data){
            res = await nsAjaxPost("{{ route('reports.supplier-ledgers') }}",data);
            if(data.supplier_id==0){
                allSupplier(res);
            }else{
                singleSupplier(res);
            }
        }
        function getFormData() {
            return {
                supplier_id: $('#supplier_id').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            }
        }
        function singleSupplier(res) {
            let tbody = ``;
            let balance = 0;
            let total_debit_amount = 0;
            let total_credit_amount = 0;
            let previous_balance = res.previous_balance;
            let thead = ``;
                thead += `<tr>`;
                thead += `<th>SN</th>`;
                thead += `<th>Date</th>`;
                thead += `<th>Particular</th>`;
                thead += `<th>Note</th>`;
                thead += `<th>Debit</th>`;
                thead += `<th>Credit</th>`;
                thead += `<th>Balance</th>`;
                thead += `</tr>`;
                $('#thead').html(thead);

            res.supplierLedger.forEach((val,index) => {
                val.debit_amount = parseFloat(val.debit_amount);
                val.credit_amount = parseFloat(val.credit_amount);
                balance += val.credit_amount - val.debit_amount;
                total_debit_amount += val.debit_amount;
                total_credit_amount += val.credit_amount;
                    if(val.purchase_id){
                        url = '{{ route("purchases.vouchar", ":id") }}'.replace(":id", val.purchase_id);
                        val.particular = val.particular +' '+ '<a target="_blank" href="'+url+'"><b>#'+val.purchase.vouchar_no+'</b></a>';
                    }
                    tbody += `<tr>`;
                    tbody +=   `<td>${index + 1}</td>`;
                    tbody +=   `<td>${val.date}</td>`;
                    tbody +=   `<td>${val.particular}</td>`;
                    tbody +=   `<td>${val.note?val.note:''}</td>`;
                    tbody +=   `<td style="text-align: right;">${val.debit_amount? res.currency_symbol +" "+val.debit_amount.toFixed(2):''}</td>`;
                    tbody +=   `<td style="text-align: right;">${val.credit_amount? res.currency_symbol +" "+val.credit_amount.toFixed(2):''}</td>`;
                    tbody +=   `<td style="text-align: right;">${res.currency_symbol+" "+balance.toFixed(2)}</td>`;
                    tbody += `</tr>`;
                });

                tbody += `<tr>`;
                tbody +=   `<th style="text-align: left;" colspan="4">Total: </th>`;
                tbody +=   `<th style="text-align: right;">${res.currency_symbol+' '+total_debit_amount.toFixed(2)}</th>`;
                tbody +=   `<th style="text-align: right;">${res.currency_symbol+' '+total_credit_amount.toFixed(2)}</th>`;
                tbody +=   `<th style="text-align: right;">${res.currency_symbol+' '+balance.toFixed(2)}</th>`;
                tbody += `</tr>`;
                tbody += `<tr>`;
                tbody +=   `<th style="text-align: right;" colspan="6">Previous Balance: </th>`;
                tbody +=   `<th style="text-align: right;">${res.currency_symbol+' '+previous_balance.toFixed(2)}</th>`;
                tbody += `</tr>`;
                tbody += `<tr>`;
                tbody +=   `<th style="text-align: right;" colspan="6">Final Balance: </th>`;
                tbody +=   `<th style="text-align: right;">${res.currency_symbol+' '+(balance + previous_balance).toFixed(2)}</th>`;
                tbody += `</tr>`;
                $('#tbody').html(tbody);
        }
        function allSupplier(res) {
            let thead = ``;
            let tbody = ``;
                thead += `<tr>`;
                thead +=    `<th>SN</th>`;
                thead +=    `<th>Supplier Name</th>`;
                thead +=    `<th>Phone</th>`;
                thead +=    `<th>Email</th>`;
                thead +=    `<th>Address</th>`;
                thead +=    `<th>Organization</th>`;
                thead +=    `<th>Current Balance</th>`;
                thead += `</tr>`;
                $('#thead').html(thead);
                let total_balance = 0;
                res.supplierLedger.forEach((val,index) => {
                    total_balance += val.current_balance = parseFloat(val.current_balance);
                    tbody += `<tr>`;
                    tbody +=   `<td>${index + 1}</td>`;
                    tbody +=   `<td>${val.name}</td>`;
                    tbody +=   `<td>${val.phone}</td>`;
                    tbody +=   `<td>${val.email}</td>`;
                    tbody +=   `<td>${val.address}</td>`;
                    tbody +=   `<td>${val.organization}</td>`;
                    tbody +=   `<td style="text-align: right;">${res.currency_symbol+" "+val.current_balance.toFixed(2)}</td>`;
                    tbody += `</tr>`;
                });
                tbody += `<tr>`;
                tbody +=   `<th style="text-align: right;" colspan="6">Total Balance: </th>`;
                tbody +=   `<th style="text-align: right;">${res.currency_symbol+' '+total_balance.toFixed(2)}</th>`;
                tbody += `</tr>`;
                $('#tbody').html(tbody);
        }

    </script>
@endsection
