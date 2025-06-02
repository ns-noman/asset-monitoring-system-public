@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Collections Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Collections Report</li>
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
                                <h3 class="card-title">Collections Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>Users</label>
                                        <select name="created_by_id" id="created_by_id" class="form-control" required>
                                            <option created-by-name="All Users" value="0" selected>All Users</option>
                                            @foreach ($data['users'] as $user)
                                                <option created-by-name="{{ $user->name }}" value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>From/On Date</label>
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
                                                    <h1>Collection Report</h1>
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
            let created_by_id = $('#created_by_id').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let created_by_name = $('#created_by_id option:selected').attr('created-by-name');
            let description = `Collection report of ${created_by_name}`;

            if (from_date && to_date) description += ` from ${from_date} to ${to_date}`;
            else if (from_date) description += ` on ${from_date}`;
            $('#description').html(description+`.`);


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
        $('#created_by_id, #from_date, #to_date').on('change', function (event) {
            const data = getFormData();
            nsSetItem("collectionsReportSearchKeys",data);
            getData(data);
        });
    });

    function initialize() {
        const defaultData = {created_by_id: 0,from_date: null,to_date: null};
        const data = nsGetItem("collectionsReportSearchKeys") || defaultData;
        $('#created_by_id').val(data.created_by_id);
        $('#from_date').val(data.from_date);
        $('#to_date').val(data.to_date);
        nsSetItem("collectionsReportSearchKeys",data);
        getData(data);
    }
    async function getData(data){
        res = await nsAjaxPost("{{ route('reports.collections') }}",data);
        if(data.created_by_id==0){
            allUser(res);
        }else{
            singleUser(res);
        }
    }
    function getFormData() {
        return {
            created_by_id: $('#created_by_id').val(),
            from_date: $('#from_date').val(),
            to_date: $('#to_date').val()
        }
    }
    function singleUser(res) {
        let total = 0;
        let tbody = ``;
        let thead = ``;
            thead += `<tr>`;
            thead +=    `<th>SN</th>`;
            thead +=    `<th>Date</th>`;
            thead +=    `<th>Time</th>`;
            thead +=    `<th>Order No</th>`;
            thead +=    `<th>Amount</th>`;
            thead += `</tr>`;
            $('#thead').html(thead);
            res.collections.forEach((val,index)=>{
                val.paid_amount = parseFloat(val.paid_amount);
                tbody += `<tr>`;
                tbody +=   `<td>${(index + 1)}</td>`;
                tbody +=   `<td>${nsYYYYMMDD(val.created_at)}</td>`;
                tbody +=   `<td>${nsTime12(val.created_at)}</td>`;
                tbody +=   `<td>${val.order_no}</td>`;
                tbody +=   `<td class="text-right">${res.currency_symbol} ${val.paid_amount.toFixed(2)}</td>`;
                tbody += `</tr>`;
                total += val.paid_amount;
            });
            tbody += `<tr>`;
            tbody +=   `<th colspan="4" class="text-left">Total Amount: </th>`;
            tbody +=   `<th class="text-right">${res.currency_symbol} ${total.toFixed(2)}</th>`;
            tbody += `</tr>`;
            $('#tbody').html(tbody);
    }
    function allUser(res) {
        let total = 0;
        let tbody = ``;
        let thead = ``;
            thead = `<tr>`;
            thead +=    `<th width="5%">SN</th>`;
            thead +=    `<th width="70%">User Name</th>`;
            thead +=    `<th width="25%">Collection Amount</th>`;
            thead += `</tr>`;
            $('#thead').html(thead);
        res.collections.forEach((val,index)=>{
            val.total_collection_amount = parseFloat(val.total_collection_amount);
            tbody += `<tr>`;
            tbody +=   `<td>${(index + 1)}</td>`;
            tbody +=   `<td class="text-left">${val.name}</td>`;
            tbody +=   `<td class="text-right">${res.currency_symbol} ${val.total_collection_amount.toFixed(2)}</td>`;
            tbody += `</tr>`;
            total += val.total_collection_amount;
        });
        tbody += `<tr>`;
        tbody +=   `<th colspan="2" class="text-left">Total Amount: </th>`;
        tbody +=   `<th class="text-right">${res.currency_symbol} ${total.toFixed(2)}</th>`;
        tbody += `</tr>`;
        $('#tbody').html(tbody);
    }

</script>
@endsection
