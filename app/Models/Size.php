<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sortorder',
    ];

    protected $casts = [
        'sortorder' => 'integer',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'sizeid');
    }
}
