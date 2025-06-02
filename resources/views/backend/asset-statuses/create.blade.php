@extends('layouts.admin.master')
@section('content')
    <style>
        .table td, .table th{
            padding: 2px;
            text-align: center;
        }
        .table td, .table th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $data['title'] }} Form</h3>
                            </div>
                            <form action="{{ route('assets-statuses.store') }}" method="POST">
                                @csrf()
                                <div class="card-body">
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                        <div class="bootstrap-data-table-panel">
                                            <div class="table-responsive">
                                                <table id="dataTable" class="table table-sm table-striped table-bordered table-centre">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Category Name</th>
                                                            <th>Asset Name</th>
                                                            <th>Asset Code</th>
                                                            <th>Remarks</th>
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
                                                            <th>Remarks</th>
                                                            <th>Condition</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
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
                                <select data-column="1" class="form-control form-control-sm filter-select" id="category_id" name="category_id" style="margin-left: 10px;">
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
                    <div id="date" class="col-sm-12 col-md-${colmd}">
                        <div class="col-sm-12 col-md-6">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <label>
                                    Date:
                                    <input id="date" name="date" value="{{ date('Y-m-d') }}" type="date" class="form-control form-control-sm">
                                </label>
                            </div>
                        </div>
                    </div>
                `);
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("assets-statuses.list-temp") }}',
                type: 'GET',
                data: function(d) {
                    d.category_id = $('#category_id').val();
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
                        { 
                            data: 'remarks',
                            name: 'asset_status_temps.remarks',
                            render: function(data, type, row, meta) {
                                return (`<input value="${row.remarks != null ? row.remarks : ''}" type="text" data-asset_status_temp_id=${row.id} class="form-control form-control-sm asset-update" placeholder="Remarks" id="remarks_${row.id}">`);
                            }
                        },
                        { 
                            data: null, 
                            name: 'asset_status_temps.is_okay', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return (`
                                    <div class="clearfix">
                                        <div class="icheck-success d-inline">
                                            <input class="asset-update" data-asset_status_temp_id=${row.id} data-condition='1' ${row.is_okay == 1 ? 'checked' : null} value="1" type="radio" id="asset_ok_${row.id}" name="asset_${row.id}">
                                            <label class="text-success" for="asset_ok_${row.id}">Ok</label>
                                        </div>
                                        <div class="icheck-danger d-inline ml-3">
                                            <input class="asset-update" data-asset_status_temp_id=${row.id} data-condition='0' ${row.is_okay == 0 ? 'checked' : null} value="0" type="radio" id="asset_not_ok_${row.id}" name="asset_${row.id}">
                                            <label class="text-danger" for="asset_not_ok_${row.id}">Not Ok</label>
                                        </div>
                                    </div>
                                `);
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
            $(document).on('change','.filter-select',function() {
                table.draw();
            });
            let typingTimer; // Timer identifier
            const typingDelay = 300; // 1 second delay

            $(document).on('input', '.asset-update', function () {
                const $this = $(this); // Cache `this` to avoid re-querying DOM
                clearTimeout(typingTimer); // Clear the timer if the user is still typing

                // Start a new timer
                typingTimer = setTimeout(() => {
                    const data = {};
                    data.asset_status_temp_id = $this.data('asset_status_temp_id');
                    data.asset_condition = $(`input[name="asset_${data.asset_status_temp_id}"]:checked`).val();
                    data.remarks = $(`#remarks_${data.asset_status_temp_id}`).val();

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: `{{ route('assets-statuses.update-temp') }}`,
                        method: 'POST',
                        dataType: 'JSON',
                        data: data,
                        success: function (res) {
                            console.log(res);
                        },
                    });
                }, typingDelay);
            });

        });
    </script>
@endsection