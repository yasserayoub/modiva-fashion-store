<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'parentid',
        'name',
        'slug',
        'description',
        'imagepath',
        'isactive',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    protected $casts = [
        'isactive' => 'boolean',
    ];

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parentid');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parentid');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryid');
    }
}
