@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-dark">
                            <div class="card-header">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button tab-index="0" class="nav-link emp-nav active" id="with_req_tab" data-toggle="pill"
                                            data-target="#tab_with_requisition" type="button" role="tab"
                                            aria-controls="tab_with_requisition" aria-selected="true">With Requisition</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button tab-index="1" class="nav-link emp-nav" id="without_req_tab" data-toggle="pill"
                                            data-target="#tab_without_requisition" type="button" role="tab"
                                            aria-controls="tab_without_requisition" aria-selected="false">Without Requisition</button>
                                    </li>
                                </ul>
                            </div>
                            <form id="form" action="#" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="card-body">
                                    <div class="row">
                                        <div class="tab-content" id="pills-tabContent" style="width: 100%">
                                            <div id="tab_with_requisition" tab-cont="0" class="tab-pane fade show active" role="tabpanel" aria-labelledby="with_req_tab">
                                            </div>
                                            <div id="tab_without_requisition" tab-cont="1" class="tab-pane fade" role="tabpanel" aria-labelledby="without_req_tab">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button id="btn_submit" type="submit" class="btn btn-primary">Submit</button>
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
        //Common Start****************
        $(document).ready(function() {
            loadComponentsWithReq();
            setRoute(`{{ route('assets-transfers.storeTransferFromRequisition') }}`);
            $('#with_req_tab').click(function() {
                clearComponentsWithoutReq();
                loadComponentsWithReq();
                setRoute(`{{ route('assets-transfers.storeTransferFromRequisition') }}`);
            });
            $('#without_req_tab').click(function() {
                clearComponentsWithReq();
                loadComponentsWithoutReq();
                setRoute(`{{ route('assets-transfers.storeTransferWithoutRequisition') }}`);
            });
        });
        function warning(message) {
            Swal.fire({
                icon: "warning",
                title: "Warning!",
                text: message,
            });
        }
        function setRoute(route) {
            $('#form').attr('action', route);
        }
        //Common End__________________


        //Transfer Requistion Start****************
        $(document).ready(function() {
            $(document).on('change','#transfer_requistion_id', function(e) {
                let transfer_requistion_id = $('#transfer_requistion_id').val();
                const url = `{{ route('assets-transfers.requisition-details', [":req_id"]) }}`.replace(':req_id', transfer_requistion_id);
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let tbody = ``;
                        res.trd.forEach(function(requisition_details, index) {
                            tbody += `<tr>
                                        <td class="serial"></td>
                                        <td class="text-left">${requisition_details.category_title}</td>
                                        <td>${makeAssetSelector(requisition_details.assets)}</td>
                                    </tr>`.repeat(requisition_details.quantity);
                        });
                        $('#to_branch_title').val(res.branch.title);
                        $('#tbody').html(tbody);
                        setSerial();
                        
                    }
                });
            });
        });
        function setSerial() {
            $(".serial").each(function(index) { $(this).html(index + 1);});
        }
        function makeAssetSelector(assetList) {
            let option = `<select class="form-control form-control-sm" name="asset_ids[]" required>`;
                if(assetList.length){
                    option += `<option disabled selected value="">Select Asset</option>`;
                    assetList.forEach(element => {
                        option += `<option asset-title="${element.title}" asset-code="${element.code}" is_okay="${element.is_okay}" value="${element.id}">${element.title}(${element.code})</option>`;
                    });
                }else{
                    option += `<option value="">No Asset Found</option>`;
                }
                option += `</select>`;
            return option;
        }
        $(document).on('change','select[name="asset_ids[]"]', function (e) {
            let current_asset_id = $(this).val();
            let asset_list = $('select[name="asset_ids[]"]');
            let repeat_time = 0;
            asset_list.each(function() {
                let asset_id = $(this).val();
                if(asset_id != null){
                    if (current_asset_id == asset_id) {
                        repeat_time++;
                    }
                }
            });
            if(repeat_time>1){
                warning("This asset is already selected!");
                $(this).val(null);
            }
        });
        function loadComponentsWithReq() {
            const components = ()=>{
                return(`
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                <label>Transaction No</label>
                                <select class="form-control" id="transfer_requistion_id" name="transfer_requistion_id" required>
                                    <option disabled selected value="">Select TR No</option>
                                    @foreach ($data['transfer_requistions'] as $tr)
                                        <option value="{{ $tr['id'] }}">{{ $tr['tr_no'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                <label>Transfer To</label>
                                <input class="form-control" id="to_branch_title" name="to_branch_title" readonly>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <div class="table-responsive">
                                    <table id="table" class="table table-sm table-striped table-bordered table-centre p-0 m-0">
                                        <thead>
                                            <tr>
                                                <th width="5%">SN</th>
                                                <th width="40%">Category Name</th>
                                                <th width="40%">Asset Name</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                `);
            }
            $('#tab_with_requisition').html(components);
        }
        function clearComponentsWithReq() {
            $('#tab_with_requisition').html('');
        }
        //Transfer Requistion End__________________


        

      

      //Transfer WithoutRequistion Start****************
        $(document).ready(function(){
            $(document).on('change','#category_id',function(){
                const category_id = $(this).val();
                const url = `{{ route('assets-transfers.asset-list-worq', ":id") }}`.replace(':id', category_id);
                $('#asset_id').html(`<option value="">Loading...</option>`);
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let option = ``;
                        if(res.length){
                            option += `<option value="">Select Asset</option>`;
                            res.forEach(element => {
                                option += `<option value="${element.id}">${element.title}(${element.code})</option>`;
                            });
                        }else{
                            option += `<option value="">No Asset Found</option>`;
                        }

                        $('#asset_id').html(option);
                    }
                });
            });
        });
        function loadComponentsWithoutReq() {
            const components = ()=>{
                return(`
                        <div class="row">
                            <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                <label>Category</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option disabled selected value="">Select Category</option>
                                    @foreach ($data['categories'] as $category)
                                        <option 
                                            @selected(old('category_id', isset($data['item']) ? $data['item']['category_id'] : '') == $category['id']) 
                                            value="{{ $category['id'] }}"
                                        >
                                            {{ $category['title'] }}
                                        </option>
                                        @foreach ($category['subcategories'] as $subcategory)
                                            <option 
                                                @selected(old('category_id', isset($data['item']) ? $data['item']['category_id'] : '') == $subcategory['id']) 
                                                value="{{ $subcategory['id'] }}"
                                            >
                                                &nbsp;&nbsp;&rightarrow;{{ $subcategory['title'] }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                <label>Asset *</label>
                                <select class="form-control" id="asset_id" name="asset_id" required>
                                    <option value="">No Asset Found</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                <label>Assign to Branch *</label>
                                <select class="form-control" name="branch_id" required>
                                    <option value=''>Select Branch</option>
                                    @foreach ($data['branches'] as $branch)
                                        <option class="{{ $branch->is_main_branch ? 'bg-warning' : null }}"  @selected(isset($data['item']) && $data['item']->branch_id == $branch->id) value="{{ $branch->id }}">
                                            {{ $branch->title }} {{ $branch->is_main_branch? '(Main)' : null }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                `);
            }
            $('#tab_without_requisition').html(components);
        }

   
        function clearComponentsWithoutReq() {
            $('#tab_without_requisition').html('');
        }
        //Transfer WithoutRequistion End__________________
    </script>
@endsection