@extends('layouts.app')
@section('css')
    
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a class="btn btn-success" href="{{route('product.index')}}">Back</a></br></br>
            <form action="{{route('product.store')}}"  method="post"  class="" id="productImage" enctype="multipart/form-data">
                @csrf
                   
                    <input type="hidden" name="product_id" value="{{ $product->id ?? null }}" id="product_id">
                    
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $product->name ?? null  }}" maxlength="50">
                    </div>
                    @if($errors->has('name'))  
                        <small id="" class="form-text text-danger">{{ $errors->first('name') }}</small>
                    @enderror
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ $product->price ?? null }}" placeholder="Enter a Price">
                    </div>
                    @if($errors->has('price'))  
                        <small id="" class="form-text text-danger">{{ $errors->first('price') }}</small>
                    @enderror

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock ?? null }}" placeholder="Enter a Stock">
                    </div>
                    @if($errors->has('stock'))  
                        <small id="" class="form-text text-danger">{{ $errors->first('stock') }}</small>
                    @enderror
                    
                    <div class="forom-group">
                        <label for="status">Status</label>
                        <input type="hidden" name="is_active" value="0">
                        @php 
                            $checked = $product->active ? 'checked' : '';
                        @endphp
                        <input type="checkbox" name="is_active" value="1" data-toggle="toggle" data-size="sm" {{ $checked }}>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <input type="file" class = "form-control" accept="image/*" name="images[]" value="" id="images" placeholder="Choose images" multiple>
                    </div>
                    @if($errors->has('images'))  
                        <small id="" class="form-text text-danger">{{ $errors->first('images') }}</small>
                    @enderror
                    
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" id="submitProductImage" class="btn btn-primary">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
@endpush

