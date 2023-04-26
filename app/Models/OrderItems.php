<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderItems
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $price_system
 * @property float $price_user
 * @property string $quantity
 * @property int $discount_type
 * @property float $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems wherePriceSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems wherePriceUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereUpdatedAt($value)
 * @property-read \App\Models\Product|null $item
 * @mixin \Eloquent
 */
class OrderItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function item(){
        return $this->hasOne(Product::class , 'id' , 'product_id');
    }
}
