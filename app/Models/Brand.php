<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logopath',
        'isactive',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'isactive' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brandid');
    }
}
