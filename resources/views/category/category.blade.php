@extends('layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />   
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <a class="btn btn-success" href="{{route('category.create')}}" id="createNewProduct"> Create New Category</a></br></br>
                <div class="card">
                    <table id="categoryList" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <script type="text/javascript">
    
        $(document).ready( function () {
            
            $('#categoryList').DataTable({
                serverSide: true,
                ajax: "{{ route('category.index') }}",
                columns: [
                    {data: 'DT_RowIndex' },
                    {data: 'name' },
                    {
                        data: 'active',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data:'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                
                "columnDefs": [
                    {"className": "dt-center", "targets": [0,2,3]}
                ]
                
            });

            $('body').on('click', '.deleteCategory', function(){
                var category_id = $(this).attr('id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"{{ url('category')}}"+"/"+ category_id ,
                            data:{"_token": "{{ csrf_token() }}"},
                            type:"DELETE",
                            datatype:"Json",
                            success: function (results) {
                                $('#categoryList').DataTable().ajax.reload();
                                Swal.fire(
                                    {
                                        title: 'Success!',
                                        text: results.success,
                                        icon: 'success',
                                        confirmButtonText: 'Okay'
                                    }
                                )
                            } 
                        });
                    }
                })
            });
        });
    
    </script>
    
@endpush
