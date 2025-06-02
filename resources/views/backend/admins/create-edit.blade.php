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
                            <form action="{{ isset($data['item']) ? route('admins.update',$data['item']->id) : route('admins.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Role</label>
                                            <select class="form-control" name="type" required>
                                                <option value=''>Select Role</option>
                                                @foreach ($data['roles'] as $role)
                                                    <option @selected(isset($data['item']) && $data['item']->type == $role->id) value="{{ $role->id }}">{{ $role->role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6" {{ isset($data['item']) ? 'hidden' : null}}>
                                            <label>Branch</label>
                                            <select class="form-control" name="branch_id" id="branch_id" required {{ isset($data['item']) ? 'disabled' : null}}>
                                                <option disabled selected value=''>Select Branch</option>
                                                @foreach ($data['branches'] as $branch)
                                                    <option @selected(isset($data['item']) && $data['item']->branch_id == $branch->id) value="{{ $branch->id }}">{{ $branch->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6" {{ isset($data['item']) ? 'hidden' : null}}>
                                            <label>Employee *</label>
                                            <select class="form-control" id="employee_id" name="employee_id" {{ isset($data['item']) ? 'disabled' : null}} required>
                                                <option value="">No Employee Found</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Email *</label>
                                            <input value="{{ $data['item']->email ?? null }}" required type="text" class="form-control" name="email" id="email" placeholder="Email">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Password</label>
                                            <input @required(!isset($data['item'])) type="password" class="form-control" id="password" name="password"
                                            placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Confirm Password</label>
                                            <input @required(!isset($data['item'])) type="password" onkeyup="checkPassword()" class="form-control"
                                                id="conpassword" name="conpassword" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option @selected(($data['item']->status ?? null) == 1) value="1">Active</option>
                                                <option @selected(($data['item']->status ?? null) == 0) value="0">Inactive</option>
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
    <script type="text/javascript">
        function checkPassword() {
            var x = document.getElementById("password").value;
            var y = document.getElementById("conpassword").value;
            if (x == y) {

                var input = document.getElementById("conpassword");
                input.style.borderColor = 'green';
            } else {
                var input = document.getElementById("conpassword");
                input.style.borderColor = 'red';
            }
        }
        
        $(document).ready(function(){
            $('#branch_id').change(function(){
                const branch_id = $(this).val();
                const url = `{{ route('admins.employees-list', ":id") }}`.replace(':id', branch_id);
                $('#employee_id').html(`<option value="">Loading...</option>`);
                $('#email').val('');
                $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'JSON',
                        success: function(res){
                            let option = ``;
                            if(res.length){
                                option += `<option value="" disabled selected>Select Employee</option>`;
                                res.forEach(element => {
                                    option += `<option data-email="${element.email}" value="${element.id}">${element.name}</option>`;
                                });
                            }else{
                                option += `<option value="">No Employee Found</option>`;
                            }

                            $('#employee_id').html(option);
                        }
                    });
            });
            $('#employee_id').change(function(){
                $('#email').val($('#employee_id option:selected').data('email'));
            });
        });
    </script>
@endsection
