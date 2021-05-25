<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $products = Product::all();
        if($products->isEmpty())
        {   
          echo "First Add Product...";
          return '<a href="'.route('product.index').'">Go To Product Pge</a>';
        } 
        else 
        {
            if($request->ajax()){
                $category = Category::where('user_id', Auth::id())->get();
                
                return DataTables::of($category)
                     ->addIndexColumn()
                    ->editColumn('active',function($row){
                        if($row->active == 1){
                            $btn = '<a href="#" class="edit btn btn-primary btn-sm active" >Active</a>';
                            return $btn;
                        }else{
                            $btn='<a href="#" class="edit btn btn-danger btn-sm active">Deactive</a>';
                            return $btn;
                        }
                    })
                    ->escapeColumns('active')
                    ->addColumn('action',function($row){
                        $btn='<a href="'.route('category.edit',$row->id).'"  id="'.$row->id.'"  class="btn btn btn-primary btn-sm editCategory">Edit</a>
                                <a href="javascript:void(0)"  id="'.$row->id.'"  class="btn btn-danger btn-sm deleteCategory">Delete</a>';
                        return $btn; 
                    })
                    ->make(true);
                }
            return view('category.category')->with('success','Category Add Successfully...');
        }
    }

    public function create(Category $category)
    {
        return view('category.addCategory',[
            'products' => Product::select('id','name')->get(),
            'category' => $category
        ]);
    }

    public function store(CategoryStoreRequest $request)
    {  
       $category =  Category::updateOrCreate(
            ['id' => $request->category_id],
            [   
                'user_id' => Auth::id(), 
                'name' => $request->categoryName,
                'active' => $request->active,
            ]
        );    
        $category->products()->detach(request('category-id'));    
        $category->products()->attach(request('products'));    
        return redirect(route('category.index'))->with('success','Category Add Successfully...');
    }

    public function edit(Category $category)
    {   
        $products = Product::select('id','name')->get();
        return view('category.addCategory',compact('products','category'));
    }

    public function destroy(category $category)
    {
        $category->delete($category);
        return response()->json(['success'=>'Category Deleted Successfully...']);
    }
}
