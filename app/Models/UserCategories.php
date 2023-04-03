<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCategories
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserCategories extends Model
{
    use HasFactory;
}
