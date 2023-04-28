<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::with('customer.order_count','payments','items','order_item_details')->orderByDesc('id')->get();
        return view('receipts.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('receipts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
        $order = new Orders();
        $order->status = $order::ORDER_STATUS_OK;
        $error_list = error_list();
        DB::beginTransaction();

        try {
            
           if(isset($request->customer_id_) && !empty($request->customer_id_))
           {
                $customer = Customers::findOrFail($request->customer_id_);
           }
           else
           {
            $rc = Customers::where(function ($q) use($request){
                $q->when(!empty($request->email),function($q1) use($request){
                    $q1->orWhere('email',$request->email);
                });
                $q->when(!empty($request->NIC),function($q1) use($request){
                    $q1->orWhere('nic',$request->nic);
                });
            })
            ->first();

            if(isset($rc->id)){
                return json_error($error_list['email_nic_unique']);
            }

            $user = new User();
            $user->role_id = 2;
            $user->user_category_id = 2;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->password = bcrypt('password');
            $user->active = $user::USER_ACTIVE;

            $user->save();

            $customer = new Customers();
            $customer->user_id = $user->id;
            $customer->role_id = 2;
            $customer->code = generate_customer_code();
            $customer->user_category_id = 2;
            $customer->username = $request->username;
            $customer->address = $request->address;
            $customer->mobile = $request->mobile;
            $customer->phone = $request->phone;
            $customer->nic = $request->nic;
            $customer->email = $request->email;
            $customer->active = $request->active ? true : false;

            $customer->save();

            log_event('New Customer Created from POS' , $customer->toArray()  , 'customers', $customer->id);

           }

           $order->customer_id = $customer->id;
           $order->user_id = Auth::user()->id;
           $order->amount = $request->sub_total;
           $order->paid = 0;
           $order->active = $order::ORDER_STATUS_ACTIVE;

           $order->save();

           log_event('Order Placed' , $order->toArray()  , 'orders', $order->id);

           foreach ($request->products as $key => $product) {

            $op =  Product::findOrFail($product['id']);

                $ot = new OrderItems();
                $ot->order_id = $order->id;
                $ot->product_id = $product['id'];
                $ot->price_system = $op->price;
                $ot->price_user = $product['price'];
                $ot->quantity = $product['quantity'];
                $ot->discount_type = $product['discountType'] ?? 0;
                $ot->discount = $product['discount'] ?? 0;

                $ot->save();

           log_event('Order Item Created' , $ot->toArray()  , 'order_items', $ot->id);

           update_soh_of_product($ot->product_id, $ot->quantity);

           }

           foreach ($request->payments as $key => $payment) {
                $rc = new Payment();
                $rc->order_id = $order->id;
                $rc->method = $payment['payment_method'];
                $rc->amount = $payment['amount'];
                $rc->receipt_no = generate_payment_no($payment['payment_method']);
                $rc->date = date('Y-m-d h:i:s');
                $rc->partial = $payment['amount'] < $order->amount ? 1 : 0;
                $rc->data = json_encode([
                    "accountNumber" => $payment['accountNumber'] ?? null,
                    "chequeDate" => $payment['chequeDate'] ?? null,
                    "referenceNumber" => $payment['referenceNumber'] ?? null,
                    "notes" => $payment['notes'] ?? null
                ]);
                $rc->status = $rc::STATUS_OK;
                $rc->active = $rc::STATUS_OK;

                $rc->save();

           log_event('New Payment Created' , $rc->toArray()  , 'payments', $rc->id);

           $order->paid += $payment['amount'];
           $order->save();

            }

           DB::commit();
           return response()->json(['url' => route('orders.index') , 'message' => 'New Order Placed']);



        } catch (\Exception $ex) {
            DB::rollBack();
            log_error_message($ex);
            return json_error('Unable to save the information.');
        }

      
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }

    public function getOrderDetails($id){
        $order = Orders::with('customer','payments','items','order_item_details')->findOrFail($id);
        return view('receipts.view', compact('order'));
    }
}
