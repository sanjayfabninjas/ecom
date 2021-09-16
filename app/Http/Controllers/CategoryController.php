<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
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
                                $statusIcon = '<i class="fas fa-check"></i>';
                                return $statusIcon;
                            }
                        })
                        ->escapeColumns('active')
                        ->addColumn('action',function($row){
                            $btn='<a href="'.route('category.edit',$row->id).'"  class="btn btn btn-primary btn-sm editCategory"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0)"  id="'.$row->id.'"  class="btn btn-danger btn-sm deleteCategory"><i class="fas fa-trash-alt"></i></a>';
                            return $btn; 
                        })
                        ->make(true);
                }
                
            return view('category.category')->with('success','Category Add Successfully...');
        }
    }

    public function create(Category $category)
    {
        return view('category.manageCategory',[
            'products' => Product::select('id','name')->where('active', 1)->get(),
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
                'active' => $request->is_active,
            ]
        );  

        $category->products()->detach(request('category-id'));    
        $category->products()->attach(request('products'));

        return redirect(route('category.index'))->with('success','Category Add Successfully...');
    }

    public function edit(Category $category)
    {   
        $products = Product::select('id', 'name')->where('active', 1)->get();

        return view('category.manageCategory',compact('products', 'category'));
    }

    public function destroy(category $category)
    {   
        $category->delete($category);

        return response()->json(['success'=>'Category Deleted Successfully...']);
    }

=======
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }
>>>>>>> master
}
