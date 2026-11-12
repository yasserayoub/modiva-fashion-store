<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $table = 'couponusages';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'couponid',
        'userid',
        'orderid',
        'discountamount',
    ];

    protected $casts = [
        'discountamount' => 'decimal:2',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'couponid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid');
    }
}
