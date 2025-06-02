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
                                    <a href="{{ route('branches.create') }}"class="btn btn-light shadow rounded m-0"><i
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
                                                    <th>Branch Name</th>
                                                    <th>Branch Code</th>
                                                    <th>Phone</th>
                                                    {{-- <th>Address</th> --}}
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Branch Name</th>
                                                    <th>Branch Code</th>
                                                    <th>Phone</th>
                                                    {{-- <th>Address</th> --}}
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
        $(document).ready(function(){
            const options = {};
            options.url = '{{ route("branches.all-branches") }}';
            options.type = 'GET';
            options.columns = 
                    [
                        { data: null, orderable: false, searchable: false },
                        {
                            data: 'title',
                            name: 'branches.title',
                            render: function(data, type, row, meta){
                                if(row.is_main_branch == '1'){
                                    row.title = row.title + ` <span class="badge badge-warning" >main</span>`;
                                }
                                return row.title;
                            }
                        },
                        { 
                            data: 'code',
                            name: 'branches.code',
                            render: function(data, type, row, meta){
                                return `<b>${row.code}</b>`; 
                            }
                        },

                        { data: 'phone', name: 'branches.phone'},
                        // { data: 'address', name: 'branches.address'},
                        { 
                            data: null, 
                            name: 'branches.status', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                               return `<span class="badge badge-${row.status == '1' ? 'success' : 'warning'}">${row.status == '1' ? 'Active' : 'Inactive'}</span>`;
                            }
                        },
                        { 
                            data: null,
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let edit = `{{ route('branches.edit', ":id") }}`.replace(':id', row.id);
                                let destroy = `{{ route('branches.destroy', ":id") }}`.replace(':id', row.id);

                                return (` <div class="d-flex justify-content-center">
                                                <a href="${edit}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form class="delete" action="${destroy}" method="post" hidden>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" ${row.is_main_branch == '1' ? 'disabled' : null}>
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
    </script>
@endsection