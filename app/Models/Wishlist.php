<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'userid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'wishlistid');
    }
}
