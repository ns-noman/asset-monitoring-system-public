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
                            <form action="{{ isset($data['item']) ? route('assign-assets.update',$data['item']->id) : route('assign-assets.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
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
                const url = `{{ route('assign-assets.asset-list', ":id") }}`.replace(':id', category_id);
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
    </script>
@endsection