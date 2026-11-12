<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'productimages';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'productid',
        'imagepath',
        'isprimary',
        'sortorder',
    ];

    protected $casts = [
        'isprimary' => 'boolean',
        'sortorder' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }
}
