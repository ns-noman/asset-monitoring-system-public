@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a href="{{ route('assets.create') }}"class="btn btn-light shadow rounded m-0"><i
                                            class="fas fa-plus"></i>
                                        <span>Add New</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-sm table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Asset Name</th>
                                                    <th>Code</th>
                                                    <th>Purchase Date</th>
                                                    <th>Purchase Price</th>
                                                    <th>Warranty Time</th>
                                                    <th>Asset Life</th>
                                                    <th>Depreciation Rate</th>
                                                    <th>Category Name</th>
                                                    <th>Is Assignable?</th>
                                                    <th>Condition</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Asset Name</th>
                                                    <th>Code</th>
                                                    <th>Purchase Date</th>
                                                    <th>Purchase Price</th>
                                                    <th>Warranty Time</th>
                                                    <th>Asset Life</th>
                                                    <th>Depreciation Rate</th>
                                                    <th>Category Name</th>
                                                    <th>Is Assignable?</th>
                                                    <th>Condition</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
        $(document).ready(function(){
            const options = {};
            options.url = '{{ route("assets.assets") }}';
            options.type = 'GET';
            options.columns = 
                    [
                        { data: null, orderable: false, searchable: false },
                        { data: 'title', name: 'assets.title'},
                        { data: 'code', name: 'assets.code'},
                        { data: 'purchase_date', name: 'assets.purchase_date'},
                        { data: 'purchase_value', name: 'assets.purchase_value'},
                        { data: 'warranty_time', name: 'assets.warranty_time'},
                        { data: 'asset_life', name: 'assets.asset_life'},
                        { data: 'depreciation_rate', name: 'assets.depreciation_rate'},
                        { data: 'category_title', name: 'categories.title'},
                        { 
                            data: null, 
                            name: 'assets.is_assigned', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                               return `<span class="badge badge-${row.is_assigned == '0' ? 'success' : 'danger'}">${row.is_assigned == '0' ? 'Yes' : 'No'}</span>`;
                            }
                        },
                        { 
                            data: null, 
                            name: 'assets.is_okay', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                               return `<span class="badge badge-${row.is_okay == '1' ? 'success' : 'danger'}">${row.is_okay == '1' ? 'Ok' : 'Not Ok'}</span>`;
                            }
                        },
                        { 
                            data: null, 
                            name: 'assets.location',
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let location;
                                let color;
                                if(row.location=='0'){
                                    location = 'In Store';
                                    color = 'info';
                                } else if(row.location=='1'){
                                    location = `In ${row.branch_code}`;
                                    color = 'success';
                                } else if(row.location=='2'){
                                    location = 'In Transit';
                                    color = 'warning';
                                } else if(row.location=='3'){
                                    location = 'In Garage';
                                    color = 'danger';
                                } else{
                                    location = 'Not Mentioned';
                                    color = 'secondery';
                                }
                               return `<span class="badge badge-${color}">${location}</span>`;
                            }
                        },
                        { 
                            data: null, 
                            name: 'assets.status', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                               return `<span class="badge badge-${row.status == '1' ? 'success' : 'danger'}">${row.status == '1' ? 'Active' : 'Inactive'}</span>`;
                            }
                        },
                        { 
                            data: null,
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let edit = `{{ route('assets.edit', ":id") }}`.replace(':id', row.id);
                                return (` <div class="d-flex justify-content-center">
                                                <a href="${edit}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            </div>
                                        `);
                            }
                        }
                    ];
            options.processing = true;
            dataTable(options);
        });
    </script>
@endsection