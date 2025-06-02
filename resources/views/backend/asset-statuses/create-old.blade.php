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
                                    <div class="row"  id="all_asset_entry_section">
                                        <div class="col-lg-12">
                                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
                                                <input value="" checked id="all_entry" name="all_entry" type="checkbox" class="custom-control-input menu-checkbox">
                                                <label class="custom-control-label" for="all_entry">All Asset Status Remains same?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="select_asset_entry_section" hidden>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Category</label>
                                            <select class="form-control" id="category_id" name="category_id">
                                                <option disabled selected value="">Select Category</option>
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
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Asset</label>
                                            <select class="form-control" id="asset_id" name="asset_id">
                                                <option value="">No Asset Found</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Code</label>
                                            <input class="form-control" id="asset_code" name="asset_code" placeholder="Asset Code">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <div class="bootstrap-data-table-panel">
                                                <div class="table-responsive">
                                                    <table id="dataTable" class="table table-sm table-striped table-bordered table-centre">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">SN</th>
                                                            <th width="30%">Asset Name</th>
                                                            <th width="30%">Status</th>
                                                            <th width="30%">Remarks</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                    </tbody>
                                                </table>
                                                </div>
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
            $('#category_id').change(function(){
                const category_id = $(this).val();
                const url = `{{ route('assets-statuses.asset-list', ":id") }}`.replace(':id', category_id);
                $('#asset_id').html(`<option value="">Loading...</option>`);
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'JSON',   
                    success: function(res){
                        let option = ``;
                        if(res.length){
                            option += `<option disabled selected value="">Select Asset</option>`;
                            res.forEach(element => {
                                option += `<option asset-title="${element.title}" asset-code="${element.code}" is_okay="${element.is_okay}" value="${element.id}">${element.title}(${element.code})</option>`;
                            });
                        }else{
                            option += `<option value="">No Asset Found</option>`;
                        }
                        $('#asset_id').html(option);
                    }
                });
            });

            $('#asset_code').on('input', function(e) {
                let asset_code = $(this).val().trim();
                    if (asset_code) {
                        const url = `{{ route('assets-statuses.get-asset-by-code', ":asset_code") }}`.replace(':asset_code', asset_code);
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'JSON',
                        success: function(res){
                            if (res.status == '1') {
                                const data = {
                                    asset_id: res.asset.asset_id,
                                    asset_title: res.asset.title,
                                    is_okay: res.asset.is_okay,
                                    asset_code: res.asset.code,
                                };

                                const is_rendered = appendAsset(data);
                                if(is_rendered){
                                    $('#asset_code').removeClass('border-danger');
                                    $('#asset_code').addClass('border-success');
                                }else{
                                    $('#asset_code').val('');
                                }

                            }else{
                                $('#asset_code').addClass('border-danger');
                            }
                        }
                    });
                }else{
                    $('#asset_code').removeClass('border-danger');
                    $('#asset_code').removeClass('border-success');
                }
            });

            $('#asset_id').on('change', function(e) {
                let asset_id = $('#asset_id').val();
                let asset_title = $('#asset_id option:selected').attr('asset-title');
                let asset_code = $('#asset_id option:selected').attr('asset-code');
                let is_okay = $('#asset_id option:selected').attr('is_okay');
                const data = {
                    asset_id: asset_id,
                    asset_title: asset_title,
                    is_okay: is_okay,
                    asset_code: asset_code,
                };
                appendAsset(data);
            });
            $('#tbody').bind('click', function(e) {
                $(e.target).is('.btn-del') && e.target.closest('tr').remove();
                $(".serial").each(function(index) {
                    $(this).html(index + 1);
                });
            });
            
            $('#all_entry').on('change', function(e) { 
                let checked = $(this).prop('checked');
                $('#select_asset_entry_section').prop('hidden',checked);
                $('#all_asset_entry_section').prop('hidden',!checked);
            });
        });
        function is_repeated(asset_id) {
            let repeated = false;
            $('input[name="asset_ids[]"]').each((index, element) => {
                let already_inserted_asset_id = $(element).val();
                if(already_inserted_asset_id==asset_id){
                    repeated = true;
                    return false;
                }
            });
            return repeated;
        }
        function warning() {
            Swal.fire({
                icon: "warning",
                title: "Warning!",
                text: "This Asset is already inserted!",
            });
        }
        function appendAsset(data) {
            if(is_repeated(data.asset_id)){
                warning();
                return false;
            }
            let tbody = `<tr>
                            <td class="serial"></td>
                            <td class="text-left"><input type="hidden" value="${data.asset_id}" name="asset_ids[]">${data.asset_title} (${data.asset_code})</td>
                            <td>
                                <div class="clearfix">
                                    <div class="icheck-success d-inline">
                                        <input ${data.is_okay != '1' ? 'disabled' : null} value="1" type="radio" id="asset_ok_${data.asset_id}" name="asset_${data.asset_id}">
                                        <label class="text-success" for="asset_ok_${data.asset_id}">Ok</label>
                                    </div>
                                    <div class="icheck-danger d-inline ml-3">
                                        <input value="0" type="radio" id="asset_not_ok_${data.asset_id}" name="asset_${data.asset_id}" checked>
                                        <label class="text-danger" for="asset_not_ok_${data.asset_id}">Not Ok</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" placeholder="Remarks" name="remarks[]">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-del" type="button">
                                    <i class="fa-solid fa-trash btn-del"></i>
                                </button>
                            </td>
                        </tr>`;
            $('#tbody').append(tbody);
            $(".serial").each(function(index) { $(this).html(index + 1);});
            $('#asset_id').val('');
            return true;
        }
    </script>
@endsection