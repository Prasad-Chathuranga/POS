<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\Roles;
use DB;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('permissions.index');
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
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }

    public function getModules()
    {
        //  $this->isAllowed('Users','Administration');

        return response()->json(['data' => Module::all()]);

    }

     public function getPermissions($module)
    {
        //  $this->isAllowed('Users','Administration');
        return response()->json(['data' => Permission::where('module_id' , $module)->get()]);

    }

    public function savePermissions(Request $request , $module){

        //  $this->isAllowed('Users','Administration');

        $this->validate($request , [
            'items' => 'required',
            'items.*.name' => 'required|max:30'
        ] , ['items.*.name.required' => 'Name is required' , 'items.required' => 'At lease one permission must be entered.']);

        //Find the module
        $module = Module::findOrFail($module);

        //$user = auth()->user();
        //$rootRoleID = \App\Models\Role::$rootRoleID;

        DB::beginTransaction();

        foreach($request->items as $perm):

            if(empty($perm['id']) && !empty($perm['remove'])):
                continue; //No need to handle this
            endif;

            try{

                if(!empty($perm['remove'])):
                //     //Request to remove the permission

                //     //Check if it is used in the system
                //    if( RolePermission::where('permission_id' , $perm['id']) ->count() > 0
                //            || CustomPermission::where('permission_id' ,$perm['id']) ->count()):
                //        DB::rollBack();
                //        return json_error('Cannot remove `' . $perm['name'] .'` permission. It is in used. Consider deactivating it.');
                //    endif;

                //   $p = Permission::findOrFail($perm['id']);

                //   $p->delete();


                elseif(empty($perm['id'])):

                    //This is a new permission
                    //Check if permission exists with the same name
                    if(Permission::where('name' , $perm['name'])->where('module_id' , $module->id)->count() > 0):
                        DB::rollBack();
                        return json_error('Permission `' . $perm['name'] . '` is already taken.');
                    endif;

                    $permission = new Permission(

                            [
                                'module_id' => $module->id,
                                'name' => $perm['name'],
                                'active' => $perm['active'] ? true : false
                            ]

                            );

                    $permission->save();

                else:

                    //Trying to update existing
                    if(Permission::where('name' , $perm['name'])->where('module_id' , $module) ->
                            where('id', '<>' , $perm['id'] )->count() > 0):
                        DB::rollBack();
                        return json_error('Permission `' . $perm['name'] . '` is already taken.');
                    endif;

                    //Trying to update existing
                    if($perm['module_id'] != $module->id):
                        DB::rollBack();
                        return json_error('Given module information is incorrect.');
                    endif;

                    $permission = Permission::findOrFail($perm['id']);

                    $permission ->fill(

                            [
                                'module_id' => $module->id,
                                'name' => $perm['name'],
                                'active' => $perm['active'] ? true : false
                            ]

                            );

                    $permission->save();

                endif;


            } catch (\Exception $ex) {

                log_error_message($ex);
                DB::rollBack();
                return json_error('An error occured while processing the request.');

            }

        endforeach;

        DB::commit();

        return response()->json(['message' => 'Permissions were saved successfully.']);

    }


    public function rolePermissions(){

        //  $this->isAllowed('Users','Administration');

        $roles = Roles::whereActive(Roles::ROLE_STATUS_ACTIVE)->orderBy('name')->get();

        return view('permissions.role-permissions' , compact('roles'));

    }

    public function getRolePermissions(){

        //  $this->isAllowed('Users','Administration');

        $roles = Roles::whereActive(Roles::ROLE_STATUS_ACTIVE)->orderBy('name')->get();

        return view('permissions.role-permissions' , compact('roles'));

    }

    public function getModuleWisePermission($roleID){

        //  $this->isAllowed('Users','Administration');

         $modules = Module::whereActive(Module::MODULE_STATUS_ACTIVE)->orderBy('name','asc')->get();
        $role = Roles::findOrFail($roleID);

        foreach($modules as $module):

            foreach($module->activePermissions as &$perm ):

                if(RolePermission::where('permission_id' , $perm->id)->where('role_id' , $role->id)->count()):
                    $perm->active = 1;
                else:
                    $perm->active = 0;
                endif;

            endforeach;

        endforeach;

        return response()->json(['data' => $modules]);

    }

public function saveModuleWisePermission(Request $request , $roleID){

    //  $this->isAllowed('Users','Administration');
     $role = Roles::findOrFail($roleID);

     DB::beginTransaction();

     foreach($request->modules as $module):

         foreach($module['active_permissions'] as $permission):

            try{

            if($permission['active']):
                //Permission is activated
               $rolePermission = RolePermission::firstOrNew(['role_id' => $role->id , 'permission_id' => $permission['id']]);
                    //Already there Ignore
                if(!$rolePermission->exists):
                    $rolePermission->save();
                endif;

                else:

                    //Inactive Permission
                    $rolePermission = RolePermission::where(['role_id' => $role->id , 'permission_id' => $permission['id']]);

                if($rolePermission):
                    $rolePermission->delete();
                endif;

            endif;


            }
            catch(\Exception $ex){
                log_error_message($ex);
                DB::rollBack();
                return json_error('Something went wrong while saving permissions.');
            }

         endforeach;


     endforeach;

     log_event('Role permission was set.' ,$request->all());

     DB::commit();

     return response()->json(['message' => 'Permissions were updated.']);


}
}
