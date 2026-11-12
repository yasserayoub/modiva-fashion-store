<?php
namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'roleid',
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'isactive',
    ];

    protected $hidden = [
        'password',
        'remembertoken',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    public function getEmailVerifiedAtColumn()
    {
        return 'emailverifiedat';
    }

    protected $casts = [
        'emailverifiedat' => 'datetime',
        'password' => 'hashed',
        'isactive' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleid');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'userid');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'userid');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'userid');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'userid');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'userid');
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'userid');
    }
}
