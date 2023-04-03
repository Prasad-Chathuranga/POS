<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Logs
 *
 * @property int $id
 * @property int $customer_id
 * @property int $user_id
 * @property string|null $table
 * @property string $event
 * @property string $context
 * @property string $IP
 * @property string|null $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Logs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereIP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereUserId($value)
 * @mixin \Eloquent
 */
class Logs extends Model
{
    use HasFactory;

    protected $guarded = [];
}
