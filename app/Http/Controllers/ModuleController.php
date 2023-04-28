<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::all();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $module = new Module();
        $module->name = $request->name;
        $module->active = $request->active ? true : false ;

        try {
            $module->save();
            log_event('Module Created' , $module->toArray()  , 'modules', $module->id);
            return response()->json(
                    ['url' => route('modules.edit' , $module->id) , 'message' => 'Module Created']
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
        $module = Module::findOrFail($id);
        return response()->json(['data' => $module]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('modules.create' , ['model' => $id]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->name = $request->name;
        $module->active = $request->active ? true : false ;


        try {

            $module->save();
            log_event('Module Updated' , $module->toArray()  , 'modules', $module->id);
            return response()->json(
                    ['url' => route('modules.edit' , $module->id) , 'message' => 'Module Updated']
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
        $module = Module::findOrFail($id);

        try {
            $module->delete();
            log_event('Module Deleted' , $module->toArray()  , 'modules', $module->id);
            return response()->json(
                    ['url' => route('modules.index') , 'message' => 'Module Deleted']
                    );

        } catch (Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }
}
