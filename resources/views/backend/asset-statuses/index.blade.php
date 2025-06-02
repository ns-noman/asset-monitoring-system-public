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
                                    <a href="{{ route('assets-statuses.create') }}"class="btn btn-light shadow rounded m-0"><i
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
                                                    <th>Category Name</th>
                                                    <th>Asset Name</th>
                                                    <th>Asset Code</th>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th>Created By</th>
                                                    <th>Condition</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Category Name</th>
                                                    <th>Asset Name</th>
                                                    <th>Asset Code</th>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th>Created By</th>
                                                    <th>Condition</th>
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
            var table = $('#dataTable').DataTable({
                initComplete: function () {
                const filterContainer = $('.dataTables_filter').parent();
                const colmd = 3;
                const dataTable_length = $('#dataTable_length').parent().removeClass('col-md-6').addClass(`col-md-${colmd}`);
                const dataTable_filter = $('#dataTable_filter').parent().removeClass('col-md-6').addClass(`col-md-${colmd}`);
                filterContainer.before(`
                    <div id="category_div" class="col-sm-12 col-md-${colmd}">
                        <div class="dataTables_filter" style="display: flex; align-items: center; justify-content: center;">
                            <label style="font-weight: normal; white-space: nowrap; display: flex; align-items: center;margin-bottom: .5rem;">
                                Category:
                                <select data-column="1" class="form-control form-control-sm filter" id="category_id" name="category_id" style="margin-left: 10px;">
                                    <option selected value="">All Categories</option>
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
                        <div class="col-sm-12 col-md-6">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <label>
                                    Date:
                                    <input id="date" value="{{ date('Y-m-d') }}" type="date" class="form-control form-control-sm filter">
                                </label>
                            </div>
                        </div>
                    </div>
                `);
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("assets-statuses.list") }}',
                type: 'GET',
                data: function(d) {
                    d.category_id = $('#category_id').val();
                    d.date = $('#date').val();  
                    console.log($('#date').val());
                    
                },
                dataSrc: function(res) {
                    console.log("Response data:", res);
                    return res.data;
                }
            },
            columns: [
                        { data: null, orderable: false, searchable: false },
                        { data: 'category_title', name: 'categories.title'},
                        { data: 'asset_title', name: 'assets.title'},
                        { data: 'asset_code', name: 'assets.code'},
                        { data: 'date', name: 'asset_statuses.date'},
                        { data: 'remarks', name: 'asset_statuses.remarks'},
                        { data: 'created_by', name: 'admins_creator.name'},
                        { 
                            data: null, 
                            name: 'asset_statuses.is_okay', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                               return `<span style="width: 50px;" class="badge badge-${row.is_okay == '1' ? 'success' :'danger'}">${row.is_okay == '1' ? 'Ok' : 'Not Ok'}</span>`;
                            }
                        }
                    ],
                rowCallback: function(row, data, index) {
                    var pageInfo = table.page.info();
                    var serialNumber = pageInfo.start + index + 1;
                    $('td:eq(0)', row).html(serialNumber);
                },
                order: [],
                search: {return: false}
            });
            $(document).on('change','.filter',function() {
                table.draw();
            });
        });
    </script>
@endsection