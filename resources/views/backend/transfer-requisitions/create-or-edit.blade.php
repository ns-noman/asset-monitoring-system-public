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
                            <form action="{{ isset($data['item']) ? route('transfer-requisitions.update',$data['item']->id) : route('transfer-requisitions.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Transfer From *</label>
                                            <select class="form-control" id="from_branch_id" name="from_branch_id" required>
                                                <option value=''>Select Branch</option>
                                                @foreach ($data['branches'] as $branch)
                                                    <option @selected(isset($data['item']) && $data['item']->from_branch_id == $branch->id) value="{{ $branch->id }}">{{ $branch->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Transfer To *</label>
                                            <select disabled class="form-control" id="to_branch_id" name="to_branch_id" required>
                                                <option value=''>Select Branch</option>
                                                @foreach ($data['branches'] as $branch)
                                                    <option @selected(isset($data['item']) && $data['item']->to_branch_id == $branch->id) value="{{ $branch->id }}">{{ $branch->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Category</label>
                                            <select disabled class="form-control" id="category_id" name="category_id">
                                                <option disabled selected value="">Select Category</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <div class="table-responsive">
                                                <table id="table"
                                                    class="table table-striped table-bordered table-centre p-0 m-0">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">SN</th>
                                                            <th width="40%">Category Name</th>
                                                            <th width="25%">Current Stock</th>
                                                            <th width="25%">Quantity</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                        @isset($data['item'])
                                                            @foreach ($data['item']->trdetails as $key=>$details)
                                                                <tr>
                                                                    <td class="serial">{{ $loop->iteration }}</td>
                                                                    <td class="text-left"><input type="hidden" value="{{ $details->id }}" name="category_id[]">{{ $details->title }}</td>
                                                                    <td><input readonly style="text-align: right;" type="number" value="{{ $details->stock }}" class="form-control form-control-sm" name="current_stock[]" placeholder="0.00"></td>
                                                                    <td><input min="1" step="1" style="text-align: right;" type="number" value="{{ $details->quantity }}" class="form-control form-control-sm" name="quantity[]" placeholder="0.00" required></td>
                                                                    <td><button class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>
                                                                </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-8 col-md-8 col-lg-8">
                                            <label>Remarks</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->creator_branch_remarks : old('creator_branch_remarks') }}" 
                                                type="text" class="form-control" name="creator_branch_remarks" placeholder="Remarks">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Status *</label>
                                            <select name="status" id="status" class="form-control">
                                                <option @selected(isset($data['item']->status) && $data['item']->status == 0) value="0">Pending</option>
                                                <option @selected(isset($data['item']->status) && $data['item']->status == 2) value="2">Cancel</option>
                                            </select>
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
            $('#category_id').on('change', function(e) {
                let category_id = $('#category_id').val();
                let category_title = $('#category_id option:selected').attr('category-title');
                let stock = parseInt($('#category_id option:selected').attr('stock'));
                let quantity_temp = 1;
                if(!stock){warning(`No Asset found in ${category_title}!`);return false;}
                if(is_repeated(category_id)){warning("This Category is already inserted!");return false;}
                let tbody = `<tr>
                                <td class="serial"></td>
                                <td class="text-left"><input type="hidden" value="${category_id}" name="category_id[]">${category_title}</td>
                                <td><input readonly style="text-align: right;" type="number" value="${stock}" class="form-control form-control-sm" name="current_stock[]" placeholder="0.00"></td>
                                <td><input min="1" step="1" style="text-align: right;" type="number" value="${quantity_temp}" class="form-control form-control-sm" name="quantity[]" placeholder="0.00" required></td>
                                <td><button class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>
                            </tr>`;

                $('#tbody').append(tbody);
                $(".serial").each(function(index) { $(this).html(index + 1);});
                $('#category_id').val('');
            });
            $('#tbody').bind('click', function(e) {
                $(e.target).is('.btn-del') && e.target.closest('tr').remove();
                $(".serial").each(function(index) {
                    $(this).html(index + 1);
                });
            });
        });
        $('#from_branch_id').on('change', function (e) {
            const from_branch_id = $(this).val();
            if (from_branch_id) {
                $('#to_branch_id').prop('disabled', false);
                $('#category_id').prop('disabled', false);
                $('#to_branch_id option').prop('hidden', false);
                $(`#to_branch_id option[value="${from_branch_id}"]`).prop('hidden', true);
                setCategoryList(from_branch_id);
            } else {
                $('#to_branch_id').prop('disabled', true);
                $('#category_id').prop('disabled', true);
            }
            $('#to_branch_id').val('');
            $('#category_id').val('');
            $('#tbody').html('');
        });
        $('#table').on('input','input[name="quantity[]"]', function (e) {
            let quantitities = $('input[name="quantity[]"]');
            let stocks = $('input[name="current_stock[]"]');
            for (let i = 0; i < quantitities.length; i++) {
                let quanity = parseInt($(quantitities[i]).val());
                let stock = parseInt($(stocks[i]).val());
                if(quanity>stock){
                    warning("Stock quantity exceed!");
                    $(quantitities[i]).val(stock);
                }
            }
        });

        function warning(message) {
            Swal.fire({
                icon: "warning",
                title: "Warning!",
                text: message,
            });
        }
        function is_repeated(category_id) {
            let repeated = false;
            $('input[name="category_id[]"]').each((index, element) => {
                let already_inserted_category_id = $(element).val();
                if(already_inserted_category_id==category_id){
                    repeated = true;
                    return false;
                }
            });
            return repeated;
        }

        function setCategoryList(branch_id) {
            const url = `{{ route('transfer-requisitions.get-cat-list', [":branch_id"]) }}`.replace(':branch_id', branch_id);
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'JSON',
                success: function(res){
                    let options = `<option disabled selected value="">Select Category</option>`;
                    res.forEach(function(category) {
                        options += `<option ${category.subcategories.length ? 'disabled' : null} stock="${category.stock}" category-title="${category.title}" value="${category.id}">${category.title} (${category.stock})</option>`;
                        category.subcategories.forEach(function(subcategory) {
                            options += `<option stock="${subcategory.stock}" category-title="${subcategory.title}" value="${subcategory.id}">&nbsp;&nbsp;&rightarrow;${subcategory.title} (${subcategory.stock})</option>`;
                        });
                    });
                    $('#category_id').html(options);
                }
            });
        }
    </script>
@endsection
