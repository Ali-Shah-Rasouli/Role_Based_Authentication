<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\View\View; 
use Illuminate\Http\RedirectResponse; 


class ProductController extends Controller { 

    function __construct() { 
    $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['create', 'store']]); 
    $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]); 
    $this->middleware('permission:product-delete', ['only' => ['destroy']]); }


    /**
     * Display a listing of the resource.
     */
 public function index(): view 
 { 
    $products = Product::latest()->paginate(10);  
    return view('products.index', compact('products'))->with('i', (request()->input('page', 1) -1)*5); 
} 
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request): RedirectResponse{ 
    request()-> validate([ 'name' => 'required', 'detail' => 'required',]);  
    Product::create($request->all()); 
    return redirect()->route('products.index')->with ('success', ' product created successfully');
} 

    /**
     * Display the specified resource.
     */
    public function show(Product $product): view{ 
        return view('products.show', compact('product'));
    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): view 
    { return view('products.edit' , compact('product'));}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Product $product): RedirectResponse { 
        $request-> validate( [ 'name'=>'required', 'detail' => 'required']); 
        $product ->update( $request ->all()); 
        return redirect()->route('products.index')->with('success', 'product updated successfully');}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse{ 
        $product->delete();  
        return redirect()->route('products.index')->with('success', 'product deleted successfully');}
    }

