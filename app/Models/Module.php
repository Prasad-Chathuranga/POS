<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Module
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    const MODULE_STATUS_ACTIVE = 1;

    public function permissions(){
        
        return $this->hasMany(Permission::class , 'module_id' , 'id');
        
    }
    
    public function activePermissions(){
        
        return $this->hasMany(Permission::class , 'module_id' , 'id')->where('active',true);
        
    }
}
