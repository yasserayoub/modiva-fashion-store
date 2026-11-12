<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'productvariants';

    protected $primaryKey = 'id';

    protected $fillable = [
        'productid',
        'sizeid',
        'colorid',
        'sku',
        'priceoverride',
        'isactive',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'priceoverride' => 'decimal:2',
        'isactive' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'sizeid');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'colorid');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'productvariantid');
    }
}
