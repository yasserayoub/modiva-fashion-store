<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $table = 'wishlistitems';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'wishlistid',
        'productid',
    ];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class, 'wishlistid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }
}
