@extends('layouts.app')
@section('css')
    
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a class="btn btn-success" href="{{route('category.index')}}" id="createNewProduct">Back</a></br></br>
            <div class="">
                <form action="{{route('category.store')}}" id="categoryForm" method="post">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $category->id ?? null }}" id="category_id">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" value="{{ $category->name ?? null }}" placeholder="Enter Category">
                    </div>
                    @if($errors->has('name'))  
                        <small id="" class="form-text  text-danger">{{ $errors->first('name') }}</small>
                    @enderror
                    <div class="form-group">
                        <label for="product">Product</label>
                        <select class="js-example-basic-multiple form-control productsSelect" name="products[]"  multiple="multiple">
                        <!-- <option  value="">------------------Place Select Products-------------------</option> -->
                        @foreach($products as $product)
                        <option  value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    @if($errors->has('products'))  
                        <small id="" class="form-text  text-danger">{{ $errors->first('products') }}</small>
                    @enderror
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        @if($category->active == 1)
                            <input type="radio" class="" name="active" id="1" value="1" checked><label class="form-check-label" for="1">Active</label>
                            <input type="radio" class="" name="active" id="0" value="0" ><label class="form-check-label" for="0">Inactive</label>
                        @else
                            <input type="radio" class="" name="active" id="1" value="1"><label class="form-check-label" for="1">Active</label>
                            <input type="radio" class="" name="active" id="0" value="0" checked><label class="form-check-label" for="0">Inactive</label>
                        @endif

                    </div>
                   
                    <button type="submit" id="saveCategory" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // $('.js-example-basic-multiple').select2();
            var products =  @json($category->products->pluck('id'));
            console.log(products);
            $('.productsSelect').select2();
            $('.productsSelect').val(products).trigger('change')
        });

   </script>
@endpush
