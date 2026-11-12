<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'orderitems';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'orderid',
        'productvariantid',
        'productname',
        'sku',
        'sizename',
        'colorname',
        'unitprice',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'unitprice' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'productvariantid');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'orderitemid');
    }
}
