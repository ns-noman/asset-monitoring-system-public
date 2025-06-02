@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a href="{{ route('transfer-requisitions.create') }}"class="btn btn-light shadow rounded m-0"><i
                                            class="fas fa-plus"></i>
                                        <span>Add New</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-sm table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>TR No</th>
                                                    <th>From Branch</th>
                                                    <th>To Branch</th>
                                                    <th>Date</th>
                                                    <th>Sent Remarks</th>
                                                    <th>Received Remarks</th>
                                                    <th>Responsed By</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>TR No</th>
                                                    <th>From Branch</th>
                                                    <th>To Branch</th>
                                                    <th>Date</th>
                                                    <th>Sent Remarks</th>
                                                    <th>Received Remarks</th>
                                                    <th>Responsed By</th>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Requisition Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="expense_id" id="expense_id">
                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                            <table id="expanse-table" class="table table-striped table-bordered table-centre p-0 m-0">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th width="5%">SN</th>
                                        <th>Category Name</th>
                                        <th>Quantity</th>
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            const options = {};
            options.url = '{{ route("transfer-requisitions.transfer-requisitions") }}';
            options.type = 'GET';
            options.columns = 
                    [
                        { data: null, orderable: false, searchable: false },
                        { data: 'tr_no', name: 'transfer_requisitions.tr_no'},
                        { data: 'from_branch_title', name: 'from_branch.title'},
                        { data: 'to_branch_title', name: 'to_branch.title'},
                        { data: 'date', name: 'transfer_requisitions.date'},
                        { data: 'creator_branch_remarks', name: 'transfer_requisitions.creator_branch_remarks'},
                        { data: 'receiver_branch_remarks', name: 'transfer_requisitions.receiver_branch_remarks'},
                        { data: 'from_branch_updated_by_name', name: 'from_branch_admin.name'},
                        { 
                            data: null, 
                            name: 'transfer_requisitions.status', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let bg;
                                let status;
                                if(row.status == '0'){
                                    bg = 'danger';
                                    status = 'Pending';
                                }else if(row.status == '1'){
                                    bg = 'info';
                                    status = 'Approved';
                                }else if(row.status == '2'){
                                    bg = 'secondary';
                                    status = 'cancelled';
                                }else if(row.status == '3'){
                                    bg = 'warning';
                                    status = 'Back to Correction';
                                }else if(row.status == '4'){
                                    bg = 'success';
                                    status = 'completed';
                                }
                               return `<span class="badge badge-${bg}">${status}</span>`;
                            }
                        },
                        { 
                            data: null,
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let edit = `{{ route('transfer-requisitions.edit', ":id") }}`.replace(':id', row.id);
                                let destroy = `{{ route('transfer-requisitions.destroy', ":id") }}`.replace(':id', row.id);

                                return (` <div class="d-flex justify-content-center align-items-center">
                                                <button transfer_requisition_id="${row.id}" type="button" class="btn btn-sm btn-warning tansfer-requisition" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <a href="${edit}" class="btn btn-sm btn-info ${row.status == '1' || row.status == '4' ? 'disabled' : null}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form class="delete" action="${destroy}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" ${row.status == '1' || row.status == '4' ? 'disabled' : null}>
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        `);
                            }
                        }
                        
                    ];
            options.processing = true;
            dataTable(options);



        });

        $(document).on('click', '.tansfer-requisition', function () {
            const transfer_requisition_id = $(this).attr('transfer_requisition_id');
            const url = `{{ route('transfer-requisitions.details', ":id") }}`.replace(':id', transfer_requisition_id);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                success: function(res){
                    let tbody = ``;
                    res.forEach((element,index)=>{
                        tbody +=`<tr>
                                    <td>${index+1}</td>
                                    <td>${element.title}</td>
                                    <td align="center">${element.quantity}</td>
                                </tr>`;
                    });
                    $('#tbody').html(tbody);
                }
            });

        });

       
    </script>
@endsection