@extends('layouts.admin.master')
@section('content')
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
                            <form action="{{ route('assets-transfers.store') }}" method="POST" enctype="multipart/form-data" @disabled(true)>
                                @csrf()
                                <div class="card-body">
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
         $(document).ready(function() {
            $('#transfer_requistion_id').on('change', function(e) {
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
                        console.log(res);
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
        $('#table').on('change','select[name="asset_ids[]"]', function (e) {
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

        function warning(message) {
            Swal.fire({
                icon: "warning",
                title: "Warning!",
                text: message,
            });
        }


    </script>
@endsection