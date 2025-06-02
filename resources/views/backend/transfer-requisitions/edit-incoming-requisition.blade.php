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
                            <form action="{{ route('transfer-requisitions.update-incomming',$data['item']->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Transfer From *</label>
                                            <select disabled class="form-control" id="from_branch_id" name="from_branch_id" required>
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
                                                                    <td><input disabled style="text-align: right;" type="number" value="{{ $details->stock }}" class="form-control form-control-sm" name="current_stock[]" placeholder="0.00"></td>
                                                                    <td><input disabled min="1" step="1" style="text-align: right;" type="number" value="{{ $details->quantity }}" class="form-control form-control-sm" name="quantity[]" placeholder="0.00" required></td>
                                                                    <td><button disabled class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>
                                                                </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-8 col-md-8 col-lg-8">
                                            <label>Remarks</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->receiver_branch_remarks : old('receiver_branch_remarks') }}" 
                                                type="text" class="form-control" name="receiver_branch_remarks" placeholder="Remarks">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Status *</label>
                                            <select name="status" id="status" class="form-control">
                                                <option @selected(isset($data['item']->status) && $data['item']->status == 1) value="1">Approve</option>
                                                <option @selected(isset($data['item']->status) && $data['item']->status == 2) value="2">Cancel</option>
                                                <option @selected(isset($data['item']->status) && $data['item']->status == 3) value="3">Back To Correction</option>
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