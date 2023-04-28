<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customers
 *
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 * @property int $user_category_id
 * @property string $username
 * @property string $address
 * @property string $mobile
 * @property string $phone
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Customers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customers query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereUserCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereUsername($value)
 * @property string $code
 * @property string $nic
 * @property string $email
 * @property-read \App\Models\UserCategories|null $category
 * @property-read \App\Models\Roles|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customers whereNic($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Orders> $order_count
 * @property-read int|null $order_count_count
 * @mixin \Eloquent
 */
class Customers extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        return $this->hasOne(UserCategories::class, 'id', 'user_category_id');
    }

    public function role(){
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

    public function order_count(){
        return $this->hasMany(Orders::class, 'customer_id', 'id');
    }
}
