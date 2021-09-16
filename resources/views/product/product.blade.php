@extends('layouts.app')
<<<<<<< HEAD

@section('css')
    
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />  
    
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a class="btn btn-success" href="{{route('product.create')}}"> Create New Product</a></br></br>
            <div class="card">
                <table id="productList" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Price</th> 
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
=======
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table id="producList" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
        </tbody>
>>>>>>> master
                </table>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD

@endsection
@push('scripts')
    
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <script  type="text/javascript">
        
        $(document).ready( function () {

            $('#productList').DataTable({
                serverSide: true,
                ajax: "{{ route('product.index') }}",
                columns: [
                    {data: 'DT_RowIndex' },
                    {data: 'name' },
                    {data: 'price' },
                    {data: 'stock' },
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
                    {"className": "dt-center", "targets": [0,2,3,4,5]}
                ]
            });
           
            $('body').on('click','.deleteProduct', function(){
                var product_id = $(this).attr('id');
                console.log(product_id);
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
                            url:"{{ url('product')}}"+"/"+ product_id ,
                            data:{"_token": "{{ csrf_token() }}"},
                            type:"DELETE",
                            success: function (results) {
                                $('#productList').DataTable().ajax.reload();
                                Swal.fire({
                                            title: 'Success!',
                                            text: results.success,
                                            icon: 'success',
                                            confirmButtonText: 'Okay'
                                        })
                                    
                                } 

                        });
                    }
                })
            });
        });

    </script>
@endpush
=======
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script  type="text/javascript">
        $(document).ready( function () {
            $.noConflict();
            $('#producList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.list') }}",
                columns: [
                    {data: 'name' },
                ]
            });
        } );
        
    </script>
@endsection
>>>>>>> master
