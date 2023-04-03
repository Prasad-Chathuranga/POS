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
        $products = Product::all();
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
        $product->product_category_id = $request->product_category;
        $product->name = $request->name;
        $product->soh = $request->soh;
        $product->price = number_format($request->price, 2);
        $product->allow_price_change = $request->allow_price_change ? true : false;
        $product->can_delete = $request->can_delete ? true : false;
        $product->discountable = $request->discountable ? true : false;

        try {
            $product->save();
            log_event('Prouct created.' , $product->toArray()  , 'productss', $product->id);

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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
