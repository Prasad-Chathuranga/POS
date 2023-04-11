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
            log_event('New Prouct Created' , $product->toArray()  , 'products', $product->id);

            $category = ProductCategories::findOrFail($product->product_category_id);
            $category->soh = Product::whereProductCategoryId($product->product_category_id)->sum('soh');
            $product->category()->save($category);

            return response()->json(
                    ['url' => route('products.edit' , $product->id) , 'message' => 'New Prouct Created']
                    );
        } catch (\Exception $ex) {
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
            log_event('Product Updated' , $product->toArray()  , 'products', $product->id);

            $category = ProductCategories::findOrFail($product->product_category_id);
            $category->soh = Product::whereProductCategoryId($product->product_category_id)->sum('soh');
            $product->category()->save($category);

            log_event('Product Category SOH Updated' , $product->category->toArray()  , 'products', $product->category->id);

            return response()->json(
                    ['url' => route('products.edit' , $product->id) , 'message' => 'Product Updated']
                    );

        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        try {
            $product->delete();
            log_event('Product Deleted.' , $product->toArray()  , 'product_categories', $product->id);

            $category = ProductCategories::findOrFail($product->product_category_id);
            $category->soh = Product::whereProductCategoryId($product->product_category_id)->sum('soh');
            $product->category()->save($category);
            return response()->json(
                    ['url' => route('products.index') , 'message' => 'Product Deleted']
                    );

        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    public function getAllProductByCategory(Request $request){

        $id = $request->id;
        $term = $request->term;

        $data = Product::when(!empty($term), function ($q) use ($term) {
            $q->where('name', 'LIKE', $term . '%');
        })
        ->where('product_category_id', $id)
        ->get();
        $result = [];
        foreach ($data as $val) {
            $result[] = ['id' => $val->id, 'text' => $val->name . " - SOH (" . $val->soh . ")"];
        }
        return response()->json(['results' => $result]);
    }

    public function getProductById(Request $request){
        
        $id = $request->id;

        $data = Product::findOrFail($id);
        return response()->json(['data' => $data]);
    }
}
