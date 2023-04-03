<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductCategories
 *
 * @property int $id
 * @property string $name
 * @property string $soh
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereSoh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCategories extends Model
{
    use HasFactory;

    protected $guarded = [];
}
