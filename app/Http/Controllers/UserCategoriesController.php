<?php

namespace App\Http\Controllers;

use App\Models\UserCategories;
use Illuminate\Http\Request;

class UserCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserCategories $userCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserCategories $userCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserCategories $userCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCategories $userCategories)
    {
        //
    }

    public function getAllUserCategories(){
        $categories = UserCategories::whereActive(1)->get();
        return response()->json(['data' => $categories]);
    }
}
