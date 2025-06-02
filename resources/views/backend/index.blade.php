@inject('authorization', 'App\Services\AuthorizationService')
@extends('layouts.admin.master')
@section('content')
    @php
        $menuID = [46, 47, 48, 49, 50];
    @endphp
    <style>
        table tr td:nth-child(2), table tr th:nth-child(2){
            text-align: left!important;
        }
        .cursor-pointer{
            cursor: pointer;
        }
        .active-cust {
            border: 2px solid #03d6ba;
            background-color: #dcebe9;
        }
    </style>
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3" {{ !$authorization->hasMenuAccess(46) ? 'hidden' : null }}>
                        <div class="info-box cursor-pointer filter-by-condition drawable" data-condition="-1">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-desktop"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Assets</span>
                                <span class="info-box-number" id="total_asset"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3" {{ !$authorization->hasMenuAccess(47) ? 'hidden' : null }}>
                        <div class="info-box cursor-pointer mb-3 filter-by-condition drawable" data-condition="1">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Good & Running</span>
                                <span class="info-box-number" id="good_and_running"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-6 col-md-3" {{ !$authorization->hasMenuAccess(48) ? 'hidden' : null }}>
                        <div class="info-box cursor-pointer mb-3 filter-by-condition drawable" data-condition="0">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-thumbs-down"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bad & Damaged</span>
                                <span class="info-box-number" id="bad_damaged"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3" {{ !$authorization->hasMenuAccess(49) ? 'hidden' : null }}>
                        <div class="info-box cursor-pointer mb-3 filter-by-condition" id="in-transit">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shipping-fast"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">In transit</span>
                                <span class="info-box-number" id="in_transit"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12" {{ !$authorization->hasMenuAccess(50) ? 'hidden' : null }}>
                        <div class="card">
                            <div class="card-header bg-dark p-1">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h1 class="card-title text-info">Asset List</h1>
                                    </div>
                                    <div class="col-md-10">
                                        @if(count($data['notworking']))
                                            <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                                <h4 class="txt-danger" style="text-shadow: 1px 1px 2px white; color: red;">
                                                    @foreach ($data['notworking'] as $key => $nta)
                                                    <span class="text-warning">{{ $loop->iteration }}.</span> {{ $nta['title'] }} ({{ $nta['code'] }}) NWFD: {{ $nta['trouble_from_date'] }} &nbsp;&nbsp;&nbsp;
                                                    @endforeach    
                                                </h4>    
                                            </marquee>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive" id="table-holder">
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
    //Asset_Start________________________________
    let isAssetTableInitialized = false;
    $(document).ready(function(){
        loadAssetData();
        isAssetTableInitialized = true;
    });
    function loadAssetData() {
        loadTableAsset();
        var table = $('#dataTable').DataTable({
            initComplete: function () {
                const filterContainer = $('.dataTables_filter').parent();
                const colmd = `{{ $data['is_main_branch'] =='0' ? 4 : 3  }}`;
                $('#dataTable_length').parent().removeClass('col-md-6').addClass(`col-md-${colmd}`);
                $('#dataTable_filter').parent().removeClass('col-md-6').addClass(`col-md-${colmd}`);
                filterContainer.before(`
                    <div id="category_div" class="col-sm-12 col-md-${colmd}">
                        <div class="dataTables_filter" style="display: flex; align-items: center; justify-content: center;">
                            <label style="font-weight: normal; white-space: nowrap; display: flex; align-items: center;margin-bottom: .5rem;">
                                Category:
                                <select data-column="1" class="form-control form-control-sm filter" id="category_id" name="category_id" style="margin-left: 10px;">
                                    <option selected value="">Select Category</option>
                                    @foreach ($data['categories'] as $category)
                                        <option value="{{ $category['id'] }}">
                                            {{ $category['title'] }}
                                        </option>
                                        @foreach ($category['subcategories'] as $subcategory)
                                            <option value="{{ $subcategory['id'] }}">
                                                &nbsp;&nbsp;&rightarrow;{{ $subcategory['title'] }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                `);
                filterContainer.before(`
                    <div {{ $data['is_main_branch'] == 0 ? "hidden" : null  }} class="col-sm-12 col-md-${colmd}">
                        <div class="dataTables_filter" style="display: flex; align-items: center; justify-content: center;">
                            <label style="font-weight: normal; white-space: nowrap; display: flex; align-items: center;margin-bottom: .5rem;">
                                Branch:&nbsp;&nbsp;
                                <select class="form-control form-control-sm filter" name="branch_id" id="branch_id">
                                    <option value=''>Select Branch</option>
                                    @foreach ($data['branches'] as $branch)
                                        <option class="{{ $branch['is_main_branch'] ? 'bg-warning' : null }}"
                                            @if(!$data['is_main_branch'])
                                                @selected($data['userBranch'] == $branch['id'])
                                            @endif
                                            value="{{ $branch['id'] }}">
                                            {{ $branch['title'] }} {{ $branch['is_main_branch'] ? '(Main)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                `);
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("dashboard.asset-list") }}',
                type: 'GET',
                data: function (d) {
                    let activeElement = $('.filter-by-condition.active-cust');
                    let asset_condition = -1;
                    if (activeElement.length > 0) asset_condition = activeElement.data('condition');
                    d.category_id = $('#category_id').val() || '';
                    d.branch_id = $('#branch_id').val() || '';
                    d.asset_condition = asset_condition;
                },
                dataSrc: function (res) {
                    $('#total_asset').html(res.total_asset);
                    $('#good_and_running').html(res.good_and_running);
                    $('#bad_damaged').html(res.bad_damaged);
                    $('#in_transit').html(res.in_transit);
                    return res.data;
                }
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'title', name: 'assets.title' },
                { data: 'code', name: 'assets.code' },
                { data: 'category_title', name: 'categories.title' },
                {
                    data: null,
                    name: 'assets.is_assigned',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="badge badge-${row.is_assigned == '0' ? 'success' : 'danger'}">${row.is_assigned == '0' ? 'Yes' : 'No'}</span>`;
                    }
                },
                {
                    data: null,
                    name: 'assets.is_okay',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="badge badge-${row.is_okay == '1' ? 'success' : 'danger'}">${row.is_okay == '1' ? 'Ok' : 'Not Ok'}</span>`;
                    }
                },
                {
                    data: null,
                    name: 'assets.location',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        if(row.location=='1'){
                            return `${row.branch_title}(${row.branch_code})`;
                        }else{
                            const locationMap = {
                                '0': { label: 'In Store', color: 'info' },
                                '1': { label: `In ${row.branch_code}`, color: 'success' },
                                '2': { label: 'In Transit', color: 'warning' },
                                '3': { label: 'In Garage', color: 'danger' },
                            };
                            const locationData = locationMap[row.location] || { label: 'Not Mentioned', color: 'secondary' };
                            return `<span class="badge badge-${locationData.color}">${locationData.label}</span>`;
                        }
                    }
                },
                {
                    data: null,
                    name: 'assets.status',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="badge badge-${row.status == '1' ? 'success' : 'danger'}">${row.status == '1' ? 'Active' : 'Inactive'}</span>`;
                    }
                }
            ],
            rowCallback: function (row, data, index) {
                const pageInfo = table.page.info();
                const serialNumber = pageInfo.start + index + 1;
                $('td:eq(0)', row).html(serialNumber);
            },
            order: [],
            search: { return: false }
        });

        $(document).on('change', '.filter', function () {
            table.draw();
        });
        $('.filter-by-condition.drawable').on('click', function () {
            if(!isAssetTableInitialized){
                //Destroy The previous DataTable instance...
                if($.fn.dataTable.isDataTable('#dataTableIntransitAsset')){
                    $('#dataTableIntransitAsset').DataTable().clear().destroy();
                }
                loadAssetData();
                isAssetTableInitialized = true;
            }else{
                table.draw();
            }   
        });
       
    }
    //Generate Table Structure for Asset************
    function loadTableAsset() {
        const table = (`
            <table id="dataTable" class="table table-sm table-striped table-bordered table-centre text-center">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Asset Name</th>
                        <th>Code</th>
                        <th>Category Name</th>
                        <th>Is Assignable?</th>
                        <th>Condition</th>
                        <th>Location</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Asset Name</th>
                        <th>Code</th>
                        <th>Category Name</th>
                        <th>Is Assignable?</th>
                        <th>Condition</th>
                        <th>Location</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
        `);
        $('#table-holder').html(table);
    }
    //Asset_End________________________________


    
    //Common________________________________Start
    $('.filter-by-condition').on('click', function () {
        $('.filter-by-condition').removeClass('active-cust');
        $(this).toggleClass('active-cust');
    });
    //Common________________________________End


    //Intransfer_________________________________Start
    $('#in-transit').on('click', function () {
        //Destroy The previous DataTable instance...
        if($.fn.dataTable.isDataTable('#dataTable')){
            $('#dataTable').DataTable().clear().destroy();
        }
        loadDataInTransit();
        isAssetTableInitialized = false;
    });
    function loadDataInTransit() {
        tableIntransit();
        var table = $('#dataTableIntransitAsset').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("dashboard.in-transit-asset-list") }}',
                type: 'GET',
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'asset_title', name: 'assets.title'},
                { data: 'code_title', name: 'assets.code'},
                { data: 'from_branch_title', name: 'from_branches.title'},
                { data: 'to_branch_title', name: 'to_branches.title'},
                { data: 'date', name: 'asset_transfers.date'},
                { data: 'created_by', name: 'admins_creator.name'},
                { 
                    data: null, 
                    name: 'asset_transfers.status', 
                    orderable: true, 
                    searchable: false, 
                    render: function(data, type, row, meta) {
                        return `<span class="badge badge-${row.status == '0' ? 'warning' :'success'}">${row.status == '0' ? 'In transit' : 'Received'}</span>`;
                    }
                },
            ],
            rowCallback: function (row, data, index) {
                const pageInfo = table.page.info();
                const serialNumber = pageInfo.start + index + 1;
                $('td:eq(0)', row).html(serialNumber);
            },
            order: [],
            search: { return: false }
        });
    }
    //Generate Table Structure for Transit************
    function tableIntransit() {
        const table = (`
            <table id="dataTableIntransitAsset" class="table table-sm table-striped table-bordered table-centre">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Asset Name</th>
                        <th>Asset Code</th>
                        <th>Transfer From</th>
                        <th>Transfer To</th>
                        <th>Date</th>
                        <th>Transfered By</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Asset Name</th>
                        <th>Asset Code</th>
                        <th>Transfer From</th>
                        <th>Transfer To</th>
                        <th>Date</th>
                        <th>Transfered By</th>
                        <th>Location</th>
                    </tr>
                </tfoot>
            </table>
        `);
        $('#table-holder').html(table);
    }
    //Intransfer________________________________End
</script>
@endsection