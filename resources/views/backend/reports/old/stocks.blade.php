@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Stock Reports</li>
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
                                <h3 class="card-title">Stock Reports</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>Items</label>
                                        <select name="item_id" id="item_id" class="form-control" required>
                                            <option item-name="All Item" value="0" selected>All Item</option>
                                            @foreach ($data['items'] as $item)
                                                <option item-name="{{ $item->title }}" value="{{ $item->id }}">{{ $item->title }}</option>
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
            let item_id = $('#item_id').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let item_name = $('#item_id option:selected').attr('item-name');
            if(item_id==0){
                $('#description').html(`${item_name} Stock Report.`);
            }else{
                let description = `${item_name} Stock Report`;
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
        $('#item_id, #from_date, #to_date').on('change', function (event) {
            const data = getFormData();
            nsSetItem("itemReportSearchKeys",data);
            getData(data);
        });
    });

    function initialize() {
        const defaultData = {item_id: 0,from_date: null,to_date: null};
        const data = nsGetItem("itemReportSearchKeys") || defaultData;
        $('#item_id').val(data.item_id);
        $('#from_date').val(data.from_date);
        $('#to_date').val(data.to_date);
        nsSetItem("itemReportSearchKeys",data);
        getData(data);
    }
    async function getData(data){
        res = await nsAjaxPost("{{ route('reports.stocks') }}",data);
        if(data.item_id==0){
            allItem(res);
        }else{
            singleItem(res);
        }
    }
    function getFormData() {
        return {
            item_id: $('#item_id').val(),
            from_date: $('#from_date').val(),
            to_date: $('#to_date').val()
        }
    }
    function singleItem(res) {
        let tbody = ``;
        let thead = ``;
            thead += `<tr>`;
            thead += `<th>SN</th>`;
            thead += `<th>Date</th>`;
            thead += `<th>Particular</th>`;
            thead += `<th>Stock In Qty</th>`;
            thead += `<th>Stock Out Qty</th>`;
            thead += `<th>Current Stock</th>`;
            thead += `</tr>`;
            $('#thead').html(thead);

        res.stockHistory.forEach((val,index)=>{
            val.stock_in_qty = parseFloat(val.stock_in_qty) || 0;
            val.stock_out_qty = parseFloat(val.stock_out_qty) || 0;
            val.current_stock = parseFloat(val.current_stock) || 0;
            tbody += `<tr>`;
            tbody +=   `<td>${(index + 1)}</td>`;
            tbody +=   `<td>${val.date}</td>`;
            tbody +=   `<td>${val.particular}</td>`;
            tbody +=   `<td>${val.stock_in_qty?val.stock_in_qty +' '+res.unit:'__'}</td>`;
            tbody +=   `<td>${val.stock_out_qty?'-'+val.stock_out_qty +' '+res.unit:'__'}</td>`;
            tbody +=   `<td>${val.current_stock +' '+res.unit}</td>`;
            tbody += `</tr>`;
        });
        $('#tbody').html(tbody);
    }
    function allItem(res) {
        let tbody = ``;
        let thead = ``;
            thead = `<tr>`;
            thead +=    `<th width="5%">SN</th>`
            thead +=    `<th width="70%">Title</th>`
            thead +=    `<th width="25%">Current Stock</th>`
            thead += `</tr>`;
            $('#thead').html(thead);
            
        res.stockHistory.forEach((val,index)=>{
            tbody += `<tr>`;
            tbody +=   `<td>${(index + 1)}</td>`;
            tbody +=   `<td class="text-left">${val.title}</td>`;
            tbody +=   `<td>${val.current_stock} ${val.unit.title}</td>`;
            tbody += `</tr>`;
        });
        $('#tbody').html(tbody);
    }

</script>
@endsection
