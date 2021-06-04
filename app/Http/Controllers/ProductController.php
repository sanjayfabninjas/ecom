<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) { 
            $product = Product::where('user_id', Auth::id())->get();
            return DataTables::of($product)
                    ->addIndexColumn()
                    ->editColumn('active', function($row){
                        if($row->active == 1){
                            $statusIcon = '<i class="fas fa-check"></i>';
                            return $statusIcon;
                        }
                    })
                    ->escapeColumns('active')
                    ->addColumn('action', function($row){
                        $btn='<a href="'.route('product.edit',$row->id).'"  class="btn btn btn-primary btn-sm "><i class="fas fa-edit"></i></a>
                                <a href="javascript:void(0)"  id="'.$row->id.'"  class="btn btn-danger btn-sm deleteProduct"><i class="fas fa-trash-alt"></i></a>';
                        return $btn; 
                    })
                    ->make(true);
        } 
         return view('product.product');
    }

    public function create(Product $product)
    {
        return view('product.manageProduct',compact('product'));
    }

   public function store(ProductStoreRequest $request, Product $product)
    { 
        $input = $request->all();
        $product = Product::updateOrCreate(
                ['id' => $request->product_id],
                [   
                    'name' => $request->name, 
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'active' => $request->is_active,
                    'user_id'=> Auth::id(),
                ]
            );       
        
        $product_id = $product->id;
        
        if($request->hasFile('images'))
        {   
            $images =  $product->productImages->pluck('image');
            foreach($images as $image)
            {
                Storage::delete('public/products'.$image);
            }
            $files = $request->file('images');
            foreach ($files as $file) 
            {
                $image = time().'.'.$file->getClientOriginalName();
                $file->move(storage_path('app/public/products'), $image);
                $input['images'] = "$image";

                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product_id,
                        'image'      => $image
                    ]
                );
            }
            
           
        }else{
            unset($input['images']);
        }  
        
        return redirect(route('product.index'))->with('success','Category Add Successfully...');
    }

    public function edit(Product $product)
    {
        return view('product.manageProduct',compact('product'));
    }

    public function destroy(product $product)
    {   
        $images =  $product->productImages->pluck('image');
        foreach($images as $image)
        {
            Storage::delete('public/products'.$image);
        }
        $product->delete($product);
        return response()->json(['success'=>'Product Deleted successfully.']);
    }

}