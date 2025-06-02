@extends('layouts.admin.master')
@section('content')
    <style>
        table tr th:nth-child(5){
            width: 150px;
        }
        table tr th:nth-child(6){
            width: 150px;
        }
    </style>
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a href="{{ route('employees.create') }}"class="btn btn-light shadow rounded m-0"><i
                                            class="fas fa-plus"></i>
                                        <span>Add New</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="employee_table" class="table table-sm table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>                                
                                                    <th>DOB</th>                                
                                                    <th>DOJ</th>                                
                                                    <th>Department</th>
                                                    <th>Branch</th>
                                                    <th>Designation</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['employees'] as $employee)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td> {{ $employee->name }} </td>
                                                        <td> {{ $employee->email }} </td>
                                                        <td> {{ $employee->contact }} </td>
                                                        <td> {{ $employee->date_of_birth }} </td>
                                                        <td> {{ $employee->date_of_joining }} </td>
                                                        <td> {{ $employee->department->title }} </td>
                                                        <td> {{ $employee->branch->title }} </td>
                                                        <td> {{ $employee->designation->title }} </td>
                                                        <td> {{ $employee->status==1? 'Active' : 'Inactive' }} </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('employees.edit', $employee->id) }}"
                                                                    class="btn btn-sm btn-info">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>   
                                                    <th>DOB</th>                                
                                                    <th>DOJ</th>                               
                                                    <th>Department</th>
                                                    <th>Branch</th>
                                                    <th>Designation</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script> 
    $('#employee_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": false,
    });
    function del()
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            result.isConfirmed && $('#form').submit();
        });
    }
</script>
@endsection
