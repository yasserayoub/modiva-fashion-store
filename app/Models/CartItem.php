<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cartitems';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cartid',
        'productvariantid',
        'quantity',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartid');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'productvariantid');
    }
}
