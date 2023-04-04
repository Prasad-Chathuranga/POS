<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategories::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->soh = $request->soh;
        $product->price = $request->price;
        $product->allow_price_change = $request->allow_price_change ? true : false;
        $product->can_delete = $request->can_delete ? true : false;
        $product->discountable = $request->discountable ? true : false;

        try {
            $product->save();
            log_event('Prouct created.' , $product->toArray()  , 'productss', $product->id);

            $category = ProductCategories::findOrFail($product->product_category_id);
            $category->soh = Product::whereProductCategoryId($product->product_category_id)->sum('soh');
            $product->category()->save($category);

            return response()->json(
                    ['url' => route('products.edit' , $product->id) , 'message' => 'Product created.']
                    );
        } catch (\Exception $ex) {
            dd($ex);
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json(['data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('products.create' , ['model' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $product = Product::findOrFail($id);
        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->soh = $request->soh;
        $product->price = $request->price;
        $product->allow_price_change = $request->allow_price_change ? true : false;
        $product->can_delete = $request->can_delete ? true : false;
        $product->discountable = $request->discountable ? true : false;
        


        try {

            
            $product->save();
            log_event('product updated.' , $product->toArray()  , 'products', $product->id);

            $category = ProductCategories::findOrFail($product->product_category_id);
            $category->soh = Product::whereProductCategoryId($product->product_category_id)->sum('soh');
            $product->category()->save($category);

            log_event('product category soh updated.' , $product->category->toArray()  , 'products', $product->category->id);

            return response()->json(
                    ['url' => route('products.edit' , $product->id) , 'message' => 'Product updated.']
                    );

        } catch (\Exception $ex) {
            dd($ex);
            log_error_message($ex);
            return json_error('Unable to save the information.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
