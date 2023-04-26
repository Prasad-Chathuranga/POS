<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $method
 * @property int $order_id
 * @property float $amount
 * @property string $receipt_no
 * @property string $date
 * @property int $partial
 * @property string $data
 * @property int $status
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePartial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_OK = 1;

    const STATUS_INACTIVE = 2;

    const STATUS_ACTIVE = 1;


    const STATUS_REJECTED = 3;


    
}
