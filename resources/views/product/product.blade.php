@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a></br></br>
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
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    @if($errors->has('name'))  
                        <small id="" class="form-text text-muted text-danger">{{ $errors->first('name') }}</small>
                    @enderror
                    <div class="productNameError"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter a Price" value="" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Stock</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter a Stock" value="" required/>
                        </div>
                    </div>
      
                    <div class="forom-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="radio" class="active" name="active" id="1" value="1" checked><label class="form-check-label" for="1">Active</label>
                                <input type="radio" class="inactive" name="active" id="0" value="0" ><label class="form-check-label" for="0">Inactive</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-8 " id="">
                            <input type="file" class = "form-control" accept="image/*" name="images[]" value="" id="images" placeholder="Choose images" multiple>
                        </div>
                    </div>
                    
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    

    <script  type="text/javascript">
        $(document).ready( function () {


            $('#productList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.index') }}",
                columns: [
                    {data: 'DT_RowIndex' },
                    {data: 'name' },
                    {data: 'price' },
                    {data: 'stock' },
                    {data: 'active',
                     orderable: false,
                     searchable: false
                    },
                    {data:'action',
                     orderable: false,
                     searchable: false
                    },
                ]
            });
           
            $('#createNewProduct').click(function () {
                $('#saveBtn').val("create-product");
                $('#product_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });
            
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
                let myForm = document.getElementById('productForm');
                let formData = new FormData(myForm);

                $.ajax({
                    url: "{{ route('product.store') }}",
                    data: formData,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    success: function (results) {
                        $("#saveBtn").prop('disabled', false);
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        $('#saveBtn').html('Save Changes');
                        $('#productList').DataTable().ajax.reload();
                        Swal.fire({
                                    title: 'Success!',
                                    text: results.success,
                                    icon: 'success',
                                    confirmButtonText: 'Okay'
                                  })
                    },
                    error: function (response) {
                        console.log(response    );
                        if(response.responseJSON.errors.length > 0) {
                            var errorsHtml = '<ul class="kt-font-danger kt-align-left">';
                            response.responseJSON.errors.forEach(function(msg) {
                                errorsHtml += '<li> ' + msg + ' </li>';
                            });
                            errorsHtml += '</ul>';
                        }
                        swal.fire("{{ trans('common.message.alert_error_title') }}", errorsHtml, "error");
                        myUnblockPage();
                    
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click','.editProduct',function(){
                var product_id = $(this).data('id');
                $.get("{{ route('product.index')}}"+'/'+ product_id +'/edit',function(data){
                    console.log(data);
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#product_id').val(data.product.id);
                    $('#name').val(data.product.name);
                    $('#price').val(data.product.price);
                    $('#stock').val(data.product.stock);
                    $('#user_id').val(data.product.user_id);
                    if(data.product.active === 1){
                        $('.active').attr('checked', 'checked');
                    }else{
                        $('.inactive').attr('checked', 'checked');
                    }
                    $('#images').val(data.productImage.image);
                })
            });

            $('body').on('click','.deleteProduct', function(){
                var product_id = $(this).data('id');
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
                            data:$("#productForm").serialize(),
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

            $('#addProductImage').click(function(){
                var append= '<div class="removeImage"><input type="file" class = "form-control" name="images[]" id="image" placeholder="Choose images"><a href="#" id="minusProductImage" class="edit btn btn-danger btn-sm active">-</a></div>'
                $('#addImageDiv').append(append);
            });

            

        });
        
        
    </script>
@endpush