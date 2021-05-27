<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
                           $btn = '<a href="#" id="status/1/'.$row->id.'" class="edit btn btn-primary btn-sm active">Active</a>';
                            return $btn;
                        }else{
                            $activeBtn = '<a href="#" id="status/0/'.$row->id.'" class="edit btn btn-danger btn-sm active" >Deactive</a>';
                            return $activeBtn;
                        }
                    })
                    ->escapeColumns('active')
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>
                                <a href="javascript:void(0)" data-id="'.$row->id.'"  class="edit btn btn-danger btn-sm deleteProduct">Delete</a>';
                        return $btn;
                    })
                    ->make(true);
        } 
         return view('product.product');
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
                    'active' => $request->active,
                    'user_id'=> Auth::id(),
                ]
            );       
        
        $product_id = $product->id;
        
        if($request->hasFile('images'))
        {   
            $images =  $product->productImages->pluck('image');
            foreach($images as $image)
            {
                Storage::delete('public/'.$image);
            }
            $files = $request->file('images');
            foreach ($files as $file) 
            {
                $image = time().'.'.$file->getClientOriginalName();
                $file->move(storage_path('app/public'), $image);
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
        
        return response()->json(['success'=>'Product saved successfully.']);
    }

    

    public function edit(product $product)
    {
        return response()->json(
            [
                'product' =>$product,
                'productImage' => ProductImage::where('product_id',$product->id)->get(),
            ]
        );
    }

    

    public function destroy(product $product)
    {   $images =  $product->productImages->pluck('image');
        foreach($images as $image)
        {
            Storage::delete('public/'.$image);
        }
        $product->delete($product);
        return response()->json(['success'=>'Product Deleted successfully.']);
    }

}