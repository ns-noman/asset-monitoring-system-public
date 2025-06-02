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
                            <form action="{{ isset($data['item']) ? route('assets.update',$data['item']->id) : route('assets.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Category *</label>
                                            <select class="form-control" name="category_id" required>
                                                <option value="">Select Category</option>
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
                                        
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Asset Name *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->title : old('title') }}" type="text" class="form-control" name="title" placeholder="Asset Name" required>
                                        </div>
                                        <div class="form-group col-sm-2 col-md-2 col-lg-2">
                                            <label>Asset Code *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->code : old('code') }}" type="text" class="form-control" name="code" placeholder="A-1212" required>
                                            @error('code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col">
                                                    <label>Purchase Date *</label>
                                                    <input value="{{ isset($data['item']) ? $data['item']->purchase_date : old('purchase_date') }}" type="date" class="form-control" name="purchase_date" required>
                                                </div>
                                                <div class="col">
                                                    <label>Purchase Price *</label>
                                                    <input value="{{ isset($data['item']) ? $data['item']->purchase_value : old('purchase_value') }}" type="number" class="form-control" name="purchase_value" placeholder="0.00" min="1" required>
                                                </div>
                                                <div class="col">
                                                    <label>Warranty(Month) *</label>
                                                    <input value="{{ isset($data['item']) ? $data['item']->warranty_time : old('warranty_time') }}" type="number" class="form-control" name="warranty_time" placeholder="0.00" min="1" required>
                                                </div>
                                                <div class="col">
                                                    <label>Asset Life(Years) *</label>
                                                    <input value="{{ isset($data['item']) ? $data['item']->asset_life : old('asset_life') }}" type="number" class="form-control" name="asset_life" placeholder="0.00" min="1" required>
                                                </div>
                                                <div class="col">
                                                    <label>Depreciation Rate(%)*</label>
                                                    <input value="{{ isset($data['item']) ? $data['item']->depreciation_rate : old('depreciation_rate') }}" type="number" class="form-control" name="depreciation_rate" placeholder="0.00" min="1" max="100" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" placeholder="Description" required cols="30" rows="1">{{ isset($data['item']) ? $data['item']->description : old('description') }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Is Okay? *</label>
                                            <select name="is_okay" id="is_okay" class="form-control">
                                                <option @selected(($data['item']->is_okay ?? null) === 1) value="1">Yes</option>
                                                <option @selected(($data['item']->is_okay ?? null) === 0) value="0">No</option>
                                            </select>
                                        </div> 
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Status *</label>
                                            <select name="status" id="status" class="form-control">
                                                <option @selected(($data['item']->status ?? null) === 1) value="1">Active</option>
                                                <option @selected(($data['item']->status ?? null) === 0) value="0">Inactive</option>
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