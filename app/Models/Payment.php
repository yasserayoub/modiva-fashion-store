<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'orderid',
        'paymentmethod',
        'transactionreference',
        'amount',
        'status',
        'paidat',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'amount' => 'decimal:2',
        'paidat' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid');
    }
}
