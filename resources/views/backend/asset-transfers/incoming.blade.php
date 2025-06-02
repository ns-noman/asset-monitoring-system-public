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
                                    <a href="{{ route('assets-transfers.create') }}"class="btn btn-light shadow rounded m-0"><i
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
                                                    <th>Asset Name</th>
                                                    <th>Asset Code</th>
                                                    <th>Receiver Branch</th>
                                                    <th>Date</th>
                                                    <th>Created By</th>
                                                    <th>Received By</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Asset Name</th>
                                                    <th>Asset Code</th>
                                                    <th>Receiver Branch</th>
                                                    <th>Date</th>
                                                    <th>Created By</th>
                                                    <th>Received By</th>
                                                    <th>Status</th>
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
        $(document).ready(function(){
            const options = {};
            options.url = '{{ route("assets-transfers.incoming-list") }}';
            options.type = 'GET';
            options.columns = 
                    [
                        { data: null, orderable: false, searchable: false },
                        { data: 'asset_title', name: 'assets.title'},
                        { data: 'code_title', name: 'assets.code'},
                        { data: 'to_branch_title', name: 'branches.title'},
                        { data: 'date', name: 'asset_transfers.date'},
                        { data: 'created_by', name: 'admins_creator.name'},
                        { data: 'received_by', name: 'admins_receiver.name'},
                        { 
                            data: null, 
                            name: 'asset_transfers.status', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let status = '<span class="badge badge-success">Received</span>';
                                if(row.status == '0'){
                                    status = `<button asset-tranfer-id=${row.id} type="button" class="btn btn-sm btn-danger receive">Receive</button>`;
                                }
                               return status;
                            }
                        },
                    ];
            options.processing = true;
            dataTable(options);

            $(document).on('click', '.receive', function(e) {
                e.preventDefault();
                let assetTranferId = $(this).attr('asset-tranfer-id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Receive it!"
                }).then((result) => {
                    if (result.isConfirmed){
                        const url = `{{ route('assets-transfers.receive', ":id") }}`.replace(':id', assetTranferId);
                        $.ajax({
                                url: url,
                                method: 'GET',
                                dataType: 'JSON',
                                success: function(status){
                                    if(status) window.location.reload();
                                }
                            });
                    }
                });
            });
        });
    </script>
@endsection