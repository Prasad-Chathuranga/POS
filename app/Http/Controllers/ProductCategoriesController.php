<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = ProductCategories::all();
        return view('product_category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('product_category.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productCategory = new ProductCategories();
        $productCategory->name = $request->name;
        $productCategory->soh = 0;
        $productCategory->active = $request->active;

        try {

            $productCategory->save();

            log_event('Prouct Category Created' , $productCategory->toArray()  , 'product_categories', $productCategory->id);

            return response()->json(
                    ['url' => route('product-categories.edit' , $productCategory->id) , 'message' => 'Category Created']
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
        //
        $category = ProductCategories::findOrFail($id);
        return response()->json(['data' => $category]);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        return view('product_category.create' , ['model' => $id]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $productCategory = ProductCategories::findOrFail($id);
        $productCategory->name = $request->name;
        $productCategory->active = $request->active ? true : false ;


        try {

            $productCategory->save();
            log_event('Product Category Updated' , $productCategory->toArray()  , 'product_categories', $productCategory->id);
            return response()->json(
                    ['url' => route('product-categories.edit' , $productCategory->id) , 'message' => 'Category Updated']
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
        $productCategory = ProductCategories::findOrFail($id);

        try {
            $productCategory->delete();
            log_event('Product Category Deleted' , $productCategory->toArray()  , 'product_categories', $productCategory->id);
            return response()->json(
                    ['url' => route('product-categories.index') , 'message' => 'Category Deleted']
                    );

        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    public function getAllProductCategories(Request $request){

        $category = $request->category;

        $data = ProductCategories::when(!empty($category), function ($q) use ($category) {
            $q->where('name', 'LIKE', $category . '%');
        })->get();
        $result = [];
        foreach ($data as $val) {
            $result[] = ['id' => $val->id, 'text' => $val->name . " - SOH (" . $val->soh . ")"];
        }
        return response()->json(['results' => $result]);
    }
}
