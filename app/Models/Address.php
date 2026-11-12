<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $primaryKey = 'id';

    protected $fillable = [
        'userid',
        'addresstype',
        'fullname',
        'phone',
        'country',
        'city',
        'area',
        'street',
        'building',
        'apartment',
        'isdefault',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'isdefault' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
