@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info p-1 d-flex justify-content-end justify-align-center">
                                <h3 class="card-title">
                                    <a href="javascript:void(0)"class="btn btn-dark shadow rounded" onclick="print()"><i
                                            class="fas fa-print"></i>
                                        <span>Print</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="bootstrap-data-table-panel">
                                        <div class="table-responsive" id="table-holder">
                                            <table id="dataTable" class="table table-sm table-striped table-bordered table-centre text-center">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Asset Code</th>
                                                        <th>Asset Name</th>
                                                        <th>Category Name</th>
                                                        <th>Location</th>
                                                        <th>Condition</th>
                                                        <th>Status</th>
                                                        <th>Acquisition Date</th>
                                                        <th>Value(BDT)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Asset Code</th>
                                                        <th>Asset Name</th>
                                                        <th>Category Name</th>
                                                        <th>Location</th>
                                                        <th>Condition</th>
                                                        <th>Status</th>
                                                        <th>Acquisition Date</th>
                                                        <th>Value(BDT)</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
<script>
    //Asset_Start________________________________
    $(document).ready(function(){
        loadAssetData();
    });
    function loadAssetData() {
        var table = $('#dataTable').DataTable({
            initComplete: function () {
                const filterContainer = $('.dataTables_filter').parent();
                const colmd = 3;
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
                    <div class="col-sm-12 col-md-${colmd}">
                        <div class="dataTables_filter" style="display: flex; align-items: center; justify-content: center;">
                            <label style="font-weight: normal; white-space: nowrap; display: flex; align-items: center;margin-bottom: .5rem;">
                                Branch:&nbsp;&nbsp;
                                <select class="form-control form-control-sm filter" name="branch_id" id="branch_id">
                                    <option value=''>Select Branch</option>
                                    @foreach ($data['branches'] as $branch)
                                        <option class="{{ $branch['is_main_branch'] ? 'bg-warning' : null }}"
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
                url: '{{ route("asset-innventory.assetInventoryAssetList") }}',
                type: 'GET',
                data: function (d) {
                    d.category_id = $('#category_id').val() || '';
                    d.branch_id = $('#branch_id').val() || '';
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
                { data: 'code', name: 'assets.code' },
                { data: 'title', name: 'assets.title' },
                { data: 'category_title', name: 'categories.title' },
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
                    name: 'assets.is_okay',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="badge badge-${row.is_okay == '1' ? 'success' : 'danger'}">${row.is_okay == '1' ? 'Ok' : 'Not Ok'}</span>`;
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
                },
                { data: 'purchase_date', name: 'assets.purchase_date' },
                { data: 'purchase_value', name: 'assets.purchase_value' },
               
               
                
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
            table.draw();  
        });
    }
    function print() {
        let category_id = $('#category_id').val() || '';
        let branch_id = $('#branch_id').val() || '';
        window.open(`?&print=true&category_id=${category_id}&branch_id=${branch_id}`, '_blank');
    }
</script>
@endsection