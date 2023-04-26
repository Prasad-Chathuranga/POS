<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Orders
 *
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property float $amount
 * @property float $discount
 * @property float $paid
 * @property int $status
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Orders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders query()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereUserId($value)
 * @property-read \App\Models\Customers|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItems> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $order_item_details
 * @property-read int|null $order_item_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @mixin \Eloquent
 */
class Orders extends Model
{
    use HasFactory;

    const ORDER_STATUS_OK = 1;
    const ORDER_STATUS_ACTIVE = 1;
    protected $guarded = [];

    public function items(){
        return $this->hasMany(OrderItems::class , 'order_id' , 'id');
    }


    public function payments(){
        return $this->hasMany(Payment::class , 'order_id' , 'id');
    }

    public function customer(){
        return $this->hasOne(Customers::class , 'id' , 'customer_id');
    }

    public function order_item_details()
    {
        return $this->hasManyThrough(Product::class, OrderItems::class,'order_id','id' ,'id' , 'product_id');
    }
}
