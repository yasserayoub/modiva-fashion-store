<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'discounttype',
        'discountvalue',
        'minimumorderamount',
        'maximumdiscount',
        'usagelimit',
        'startsat',
        'expiresat',
        'isactive',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'discountvalue' => 'decimal:2',
        'minimumorderamount' => 'decimal:2',
        'maximumdiscount' => 'decimal:2',
        'usagelimit' => 'integer',
        'startsat' => 'datetime',
        'expiresat' => 'datetime',
        'isactive' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'couponid');
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class, 'couponid');
    }
}
