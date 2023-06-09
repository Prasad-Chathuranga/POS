<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Exception;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = new Roles();
        $role->name = $request->name;
        $role->active = $request->active ? true : false ;

        try {
            $role->save();
            log_event('Role Created' , $role->toArray()  , 'roles', $role->id);
            return response()->json(
                    ['url' => route('roles.edit' , $role->id) , 'message' => 'Role Created']
                    );
        } catch (Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Roles::findOrFail($id);
        return response()->json(['data' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('roles.create' , ['model' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Roles::findOrFail($id);
        $role->name = $request->name;
        $role->active = $request->active ? true : false ;


        try {

            $role->save();
            log_event('Role Updated' , $role->toArray()  , 'roles', $role->id);
            return response()->json(
                    ['url' => route('roles.edit' , $role->id) , 'message' => 'Role Updated']
                    );

        } catch (Exception $ex) {

            log_error_message($ex);
            return json_error('Unable to save the information.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Roles::findOrFail($id);

        try {
            $role->delete();
            log_event('Role Deleted' , $role->toArray()  , 'product_categories', $role->id);
            return response()->json(
                    ['url' => route('roles.index') , 'message' => 'Role Deleted']
                    );

        } catch (Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    public function getAllUserRoles(){
        $roles = Roles::whereActive(1)->get();
        return response()->json(['data' => $roles]);
    }
}
