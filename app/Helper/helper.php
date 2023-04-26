<?php

use App\Models\Customers;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductCategories;

function log_event($eventName, $data = [], $table = null, $key = null, $event_id = null) {

    $event = new App\Models\Logs();
    $event->user_id = auth()->id();
    $event->event = $eventName;
    $event->context = json_encode($data);
    $event->table = $table;
    $event->key = $key;
    $event->IP = request()->ip();

    $event->save();

    return $event->id;
}

function log_error_message(\Exception $ex) {
    logger()->error($ex->getFile() . ':' . $ex->getLine() . '-' . $ex->getMessage());
}

/**
 * Return success response
 *
 * @param string $message
 * @param string $url
 * @return \Illuminate\Http\JsonResponse
 */
function json_response($message , $url =''){
      return response()->json(['message' => $message , 'url' => $url]);
}

/**
 * Return error response
 *
 * @param string $message
 * @return \Illuminate\Http\JsonResponse
 */
function json_error($message) {

    return response()->json(['message' => $message], 422);
}

function payment_methods(){
    return array(
        1=>'Credit/Debit Card',
        2=>'Cheque',
        3=>'Bank Transfer',
        4=>'Cash'
    );
}

function error_list(){
    return array(
        'email_nic_unique' => 'Email or NIC already used in system.',
        'customer_already_in_system' => 'Customer already available in system.'
    );
}


function generate_customer_code(){
    $customer = Customers::max('code');
   
    if(empty($customer) || blank($customer)){
        $running_number = 1;
    }
    else{
        $running_invo = $customer;
        preg_match_all('!\d+!', $running_invo, $running_number_array);
        $running_number = $running_number_array[0][0];
    $running_number = (int)trim($running_number)+1;
    }
    $receipt_number = str_pad($running_number,5,"0",STR_PAD_LEFT);
   
    return 'CUS'.$receipt_number;
}

function generate_payment_no($method){
    $receipt_data = Payment::where('method',$method)->orderBy('receipt_no','desc')->first();
   
    if(empty($receipt_data) || blank($receipt_data->receipt_no)){
        $running_number = 1;
    }
    else{
        $running_invo = $receipt_data->receipt_no;
        preg_match_all('!\d+!', $running_invo, $running_number_array);
        $running_number = $running_number_array[0][0];
    $running_number = (int)trim($running_number)+1;
    }
    $receipt_number = str_pad($running_number,8,"0",STR_PAD_LEFT);
    if($method==1){
        $receipt_number = 'CRD'.$receipt_number;
    }
    else if($method==2){
        $receipt_number = 'CHK'.$receipt_number;
    }
    else if($method==3){
        $receipt_number = 'BNT'.$receipt_number;
    }

    else if($method==4){
        $receipt_number = 'CAS'.$receipt_number;
    }

    return $receipt_number;
}

function update_soh_of_product($id, $quantity){

    $product = Product::findOrFail($id);
    $product->soh = $product->soh-$quantity;

    $product->save();

    log_event('SOH updated of '.$product->name, $product->toArray(),'products', $product->id);

    $category = ProductCategories::findOrFail($product->product_category_id);
    $category->soh = Product::whereProductCategoryId($product->product_category_id)->sum('soh');
    $product->category()->save($category);

    log_event('SOH updated of category '.$category->name, $category->toArray(),'product_categories', $category->id);

}

function wom($date) {
    $date = strtotime($date);
    $weeknoofday = date('w', $date);
    $day = date('j', $date);
    $weekofmonth = ceil(($day + (7-($weeknoofday+1))) / 7);
    return $weekofmonth;
  }



?>