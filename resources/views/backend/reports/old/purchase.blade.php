@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purchase Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Purchase Report</li>
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
                                <h3 class="card-title">Purchase Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                                            <option supplier-name="All Supplier" value="0" selected>All Supplier</option>
                                            @foreach ($data['suppliers'] as $supplier)
                                                <option
                                                    supplier-name="{{ $supplier->name }}"
                                                    value="{{ $supplier->id }}">
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>On/From Date</label>
                                        <input name="from_date" id="from_date" type="date" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>To Date</label>
                                        <input name="to_date" id="to_date" type="date" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>&nbsp;</label>
                                        <button ame="print" id="print" type="button" class="form-control btn btn-dark p-1"><i class="fa fa-print"></i>Print</button>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12" id="printable">
                                        <div id="print_header" hidden>
                                            <div class="row justify-content-center">
                                                <div class="col-12 text-center">
                                                    <h1>Purchase Report</h1>
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
            let item_name = $('#supplier_id option:selected').attr('supplier-name');
            if(supplier_id==0){
                $('#description').html(`${item_name} Purchase Report.`);
            }else{
                let description = `${item_name} Purchase Report`;
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
            nsSetItem("purchaseReportSearchKeys",data);
            getData(data);
        });
    });

    function initialize() {
        const defaultData = {supplier_id: 0,from_date: null,to_date: null};
        const data = nsGetItem("purchaseReportSearchKeys") || defaultData;
        $('#supplier_id').val(data.supplier_id);
        $('#from_date').val(data.from_date);
        $('#to_date').val(data.to_date);
        nsSetItem("purchaseReportSearchKeys",data);
        getData(data);
    }
    async function getData(data){
        res = await nsAjaxPost("{{ route('reports.purchase') }}",data);
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
        let thead = ``;
            thead += `<tr>`;
            thead +=    `<th>SN</th>`;
            thead +=    `<th>Vouchar No</th>`;
            thead +=    `<th>Date</th>`;
            thead +=    `<th>Payment Status</th>`;
            thead +=    `<th>Note</th>`;    
            thead +=    `<th>Vat</th>`;
            thead +=    `<th>Discount</th>`;
            thead +=    `<th>Payable</th>`;
            thead +=    `<th>Due</th>`;
            thead += `</tr>`;
            $('#thead').html(thead);
        res.purchase.forEach((element,index)=>{
            url = '{{ route("purchases.vouchar",":id") }}'.replace(":id",element.id);
            tbody += `<tr>`;
            tbody +=     `<td>${index+1}</td>`;
            tbody +=     `<td><a target="_blank" href="${url}"><b>${element.vouchar_no}</b></a></td>`;
            tbody +=     `<td>${element.date}</td>`;
            tbody +=     `<td><span class="badge badge-${element.payment_status==1?'success':'danger'}">${element.payment_status==1?'Paid':'Due'}</span></td>`;
            tbody +=     `<td>${element.note??''}</td>`;
            tbody +=     `<td>${res.currency_symbol} ${element.vat_tax}</td>`;
            tbody +=     `<td>${res.currency_symbol} ${element.discount}</td>`;
            tbody +=     `<td>${res.currency_symbol} ${element.total_payable}</td>`;
            tbody +=     `<td style="text-align: center;">${res.currency_symbol} ${element.total_payable - element.paid_amount}</td>`;
            tbody += `</tr>`;
        });
        $('#tbody').html(tbody);
    }
    function allSupplier(res) {
        let tbody = ``;
        let thead = ``;
            thead += `<tr>`;
            thead +=    `<th>SN</th>`;
            thead +=    `<th>Vouchar No</th>`;
            thead +=    `<th>Supplier</th>`;
            thead +=    `<th>Date</th>`;
            thead +=    `<th>Payment Status</th>`;
            thead +=    `<th>Note</th>`;    
            thead +=    `<th>Vat</th>`;
            thead +=    `<th>Discount</th>`;
            thead +=    `<th>Payable</th>`;
            thead +=    `<th>Due</th>`;
            thead += `</tr>`;
            $('#thead').html(thead);
        res.purchase.forEach((element,index)=>{
            url = '{{ route("purchases.vouchar",":id") }}'.replace(":id",element.id);
            tbody += `<tr>`;
            tbody +=     `<td>${index+1}</td>`;
            tbody +=     `<td><a target="_blank" href="${url}"><b>${element.vouchar_no}</b></a></td>`;
            tbody +=     `<td>${element.supplier.name}</td>`;
            tbody +=     `<td>${element.date}</td>`;
            tbody +=     `<td><span class="badge badge-${element.payment_status==1?'success':'danger'}">${element.payment_status==1?'Paid':'Due'}</span></td>`;
            tbody +=     `<td>${element.note??''}</td>`;
            tbody +=     `<td>${res.currency_symbol} ${element.vat_tax}</td>`;
            tbody +=     `<td>${res.currency_symbol} ${element.discount}</td>`;
            tbody +=     `<td>${res.currency_symbol} ${element.total_payable}</td>`;
            tbody +=     `<td style="text-align: center;">${res.currency_symbol} ${element.total_payable - element.paid_amount}</td>`;
            tbody += `</tr>`;
        });
        $('#tbody').html(tbody);
    }

</script>
@endsection
