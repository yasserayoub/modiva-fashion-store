<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'categoryid',
        'brandid',
        'name',
        'slug',
        'description',
        'baseprice',
        'saleprice',
        'gender',
        'isfeatured',
        'isactive',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'baseprice' => 'decimal:2',
        'saleprice' => 'decimal:2',
        'isfeatured' => 'boolean',
        'isactive' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryid');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'productid')
            ->orderBy('sortorder');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'productid')
            ->where('isprimary', true);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'productid');
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'productid');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'productid');
    }
}
