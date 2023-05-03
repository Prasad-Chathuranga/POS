<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserCategories;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::where('active',1)->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::where('active',1)->get();
        $categories = UserCategories::where('active',1)->get();
        return view('users.create', compact('roles','categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = new User();
        $user->role_id = $request->role_id;
        $user->user_category_id = $request->user_category_id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);

        $user->save();

        try {
            $user->save();
            log_event('New User Created' , $user->toArray()  , 'users', $user->id);

            return response()->json(
                    ['url' => route('users.edit' , $user->id) , 'message' => 'New User Created']
                    );
        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('category','role')->findOrFail($id);
        return response()->json(['data' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $roles = Roles::where('active',1)->get();
        $categories = UserCategories::where('active',1)->get();
        return view('users.create' , ['model' => $id, 'roles'=>$roles,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->user_category_id = $request->user_category_id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);

        $user->save();

        try {
            $user->save();
            log_event('User Updated' , $user->toArray()  , 'users', $user->id);

            return response()->json(
                    ['url' => route('users.edit' , $user->id) , 'message' => 'User Updated']
                    );
        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            log_event('User Deleted.' , $user->toArray()  , 'users', $user->id);

            return response()->json(
                    ['url' => route('users.index') , 'message' => 'User Deleted']
                    );

        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }
}
