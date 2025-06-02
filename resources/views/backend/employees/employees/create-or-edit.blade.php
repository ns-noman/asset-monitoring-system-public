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
                            <form id="form" action="{{ isset($data['item']) ? route('employees.update', $data['item']->id) : route('employees.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if (isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        {{-- $data['departments']
                                        $data['branches']
                                        $data['designations'] --}}
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Department *</label>
                                            <select class="form-control" name="department_id" required>
                                                <option value=''>Select Department</option>
                                                @foreach ($data['departments'] as $department)
                                                    <option @selected(isset($data['item']) && $data['item']->department_id == $department->id) value="{{ $department->id }}">
                                                        {{ $department->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Branch *</label>
                                            <select class="form-control" name="branch_id" required>
                                                <option value=''>Select Branch</option>
                                                @foreach ($data['branches'] as $branch)
                                                    <option class="{{ $branch->is_main_branch ? 'bg-warning' : null }}"  @selected(isset($data['item']) && $data['item']->branch_id == $branch->id) value="{{ $branch->id }}">
                                                        {{ $branch->title }} {{ $branch->is_main_branch? '(Main)' : null }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Designation *</label>
                                            <select class="form-control" name="designation_id" required>
                                                <option value=''>Select Designation</option>
                                                @foreach ($data['designations'] as $designation)
                                                    <option @selected(isset($data['item']) && $data['item']->designation_id == $designation->id) value="{{ $designation->id }}">
                                                        {{ $designation->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Full Name *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->name : null }}" type="text" class="form-control" name="name" id="name" placeholder="Full Name" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Contact *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->contact : null }}" type="number" class="form-control" name="contact" id="contact" placeholder="+8801*********" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Email *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->email : null }}" type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Date Of Birth</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->date_of_birth : null }}" type="date" class="form-control" name="date_of_birth">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Date Of Joining</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->date_of_joining : null }}" type="date" class="form-control" name="date_of_joining">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
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