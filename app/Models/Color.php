<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'hexcode',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'colorid');
    }
}
