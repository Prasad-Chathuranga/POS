<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customers = Customers::with('category','role')->where('active',1)->get();
        return view('customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
     
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $customer = new Customers();
        $customer->role_id = 2;
        $customer->user_category_id = 2;
        $customer->username = $request->username;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->phone = $request->phone;
        $customer->nic = $request->nic;
        $customer->email = $request->email;
        $customer->active = $request->active ? true : false;

        $user = new User();
        $user->role_id = 2;
        $user->user_category_id = 2;
        $user->username = $customer->username;
        $user->email = $customer->email;
        $user->mobile = $customer->mobile;
        $user->password = bcrypt('test');

        $user->save();

        $customer->user_id = $user->id;


        try {
            $customer->save();
            log_event('New Customer Created' , $customer->toArray()  , 'customers', $customer->id);

            return response()->json(
                    ['url' => route('customers.edit' , $customer->id) , 'message' => 'New Customer Created']
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
        $customer = Customers::with('category','role')->findOrFail($id);
        return response()->json(['data' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('customers.create' , ['model' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $customer = Customers::findOrFail($id);
        $customer->role_id = 2;
        $customer->user_category_id = 2;
        $customer->username = $request->username;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->phone = $request->phone;
        $customer->nic = $request->nic;
        $customer->email = $request->email;
        $customer->active = $request->active ? true : false;
        


        try {

            
            $customer->save();
            log_event('Customer Updated' , $customer->toArray()  , 'customers', $customer->id);

            return response()->json(
                    ['url' => route('customers.edit' , $customer->id) , 'message' => 'Customer Updated']
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
        $customer = Customers::findOrFail($id);

        try {
            $customer->delete();
            log_event('Customer Deleted.' , $customer->toArray()  , 'customers', $customer->id);

            return response()->json(
                    ['url' => route('customers.index') , 'message' => 'Customer Deleted']
                    );

        } catch (\Exception $ex) {
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }
    }

    public function getAllCustomers(){

        $term = request()->term;

        $data = Customers::when(!empty($term), function ($q) use ($term) {
            $q->where('name', 'LIKE', $term . '%')
            ->orWhere('nic', 'LIKE', $term . '%')
            ->orWhere('email', 'LIKE', $term . '%');
        })
        ->get();
        $result = [];
        foreach ($data as $val) {
            $result[] = ['id' => $val->id, 'text' => $val->code . " - " . $val->username ];
        }
        return response()->json(['results' => $result]);
    }

    public function getCustomerById($id){
        $data = Customers::findOrFail($id);
        return response()->json(['data'=>$data]);
    }
}
