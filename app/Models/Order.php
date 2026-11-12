<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'userid',
        'addressid',
        'couponid',
        'ordernumber',
        'subtotal',
        'discountamount',
        'shippingfee',
        'totalamount',
        'paymentstatus',
        'orderstatus',
        'shippingaddresssnapshot',
        'notes',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discountamount' => 'decimal:2',
        'shippingfee' => 'decimal:2',
        'totalamount' => 'decimal:2',
        'shippingaddresssnapshot' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'addressid');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'couponid');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'orderid');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'orderid');
    }
}
