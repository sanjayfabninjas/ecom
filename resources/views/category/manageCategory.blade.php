@extends('layouts.app')
@section('css')
    
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a class="btn btn-success" href="{{route('category.index')}}">Back</a></br></br>
            
                <form action="{{route('category.store')}}"  method="post">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $category->id ?? null }}" id="category_id">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" value="{{ $category->name ?? null }}" placeholder="Enter Category">
                    </div>
                    @if($errors->has('categoryName'))  
                        <small id="" class="form-text  text-danger">{{ $errors->first('categoryName') }}</small>
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
                        <input type="hidden" name="is_active" value="0"/>
                        @php 
                            $checked = $category->active ? 'checked' : '';
                        @endphp
                        <input type="checkbox" name="is_active" value="1" data-toggle="toggle" data-size="sm" {{ $checked }}>
                    </div>
                   
                    <button type="submit"  class="btn btn-primary">Submit</button>
                </form>
            
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            var products = @json($category->products->pluck('id'));console.log(products);
            $('.productsSelect').select2();
            $('.productsSelect').val(products).trigger('change')
        });
    </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endpush
