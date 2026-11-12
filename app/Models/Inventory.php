<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $primaryKey = 'id';

    protected $fillable = [
        'productvariantid',
        'quantity',
        'reservedquantity',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'quantity' => 'integer',
        'reservedquantity' => 'integer',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'productvariantid');
    }
}
