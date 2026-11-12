<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'userid',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cartid');
    }
}
