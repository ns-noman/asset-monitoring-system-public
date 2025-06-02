@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sales Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sales Report</li>
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
                                <h3 class="card-title">Sales Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                        <label>Users</label>
                                        <select name="created_by_id" id="created_by_id" class="form-control" required>
                                            <option user_name="All Users" value="0" selected>All Users</option>
                                            @foreach ($data['admins'] as $user)
                                                <option user_name="{{ $user->name }}" value="{{ $user->id }}">{{ $user->name }}</option>
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
                                                    <h1>Sales Report</h1>
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
            let user_name = $('#created_by_id option:selected').attr('user_name');
            if(created_by_id==0){
                $('#description').html(`${user_name} Sales Report.`);
            }else{
                let description = `${user_name} Sales Report`;
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
        $('#created_by_id, #from_date, #to_date').on('change', function (event) {
            const data = getFormData();
            nsSetItem("salesReportSearchKeys",data);
            getData(data);
        });
    });

    function initialize() {
        const defaultData = {created_by_id: 0,from_date: null,to_date: null};
        const data = nsGetItem("salesReportSearchKeys") || defaultData;
        $('#created_by_id').val(data.created_by_id);
        $('#from_date').val(data.from_date);
        $('#to_date').val(data.to_date);
        nsSetItem("salesReportSearchKeys",data);
        getData(data);
    }
    async function getData(data){
        data.created_by_id = parseInt(data.created_by_id);

        res = await nsAjaxPost("{{ route('reports.sales') }}",data);

        let badge = ['danger','warning','dark','info','primary','success'];
        let order_status = ['Pending','Approved','Cancelled','Processing','Processed','Completed'];

        let tbody = ``;
        let thead = ``;                             
            thead += `<tr>`;
            thead +=    `<th>SN</th>`;
            thead +=    `<th>Order No</th>`;
            if(!data.created_by_id) thead += `<th>Created By</th>`;
            thead +=    `<th>Total Amount</th>`;
            thead +=    `<th>Vat</th>`;
            thead +=    `<th>Discount</th>`;
            thead +=    `<th>Net Payable</th>`;
            thead +=    `<th>Note</th>`;
            thead +=    `<th>Order Status</th>`;
            thead +=    `<th>Payment Status</th>`;
            thead += `</tr>`;
            $('#thead').html(thead);

        res.orders.forEach((element,index)=>{
            url = '{{ route("orders.invoice",":id") }}'.replace(":id", element.id);
            tbody += `<tr>`;
            tbody +=  `<td>${index+1}</td>`;
            tbody +=      `<td><a target="_blank" href="${url}"><b>${element.order_no}</b></a></td>`;
            if(!data.created_by_id) tbody += `<td>${element.admin.name}</td>`;
            tbody +=      `<td>${res.currency_symbol} ${element.mrp}</td>`;
            tbody +=      `<td>${res.currency_symbol} ${element.vat}</td>`;
            tbody +=      `<td>${res.currency_symbol} ${element.discount}</td>`;
            tbody +=      `<td>${res.currency_symbol} ${element.net_bill}</td>`;
            tbody +=      `<td>${element.note??''}</td>`;
            tbody +=      `<td><span class="badge badge-${badge[element.order_status]}">${order_status[element.order_status]}</span></td>`;
            tbody +=      `<td><span class="badge badge-${element.payment_status == 1 ? 'success' : 'danger'}">${element.payment_status==1?'Paid':'Unpaid'}</span></td>`;
            tbody +=  `</tr>`;
        });
        $('#tbody').html(tbody);
    }
    function getFormData() {
        return {
            created_by_id: $('#created_by_id').val(),
            from_date: $('#from_date').val(),
            to_date: $('#to_date').val()
        }
    }

</script>
@endsection
