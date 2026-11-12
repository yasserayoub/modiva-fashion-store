<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'id';

    protected $fillable = [
        'userid',
        'productid',
        'orderitemid',
        'rating',
        'comment',
        'status',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'orderitemid');
    }
}
