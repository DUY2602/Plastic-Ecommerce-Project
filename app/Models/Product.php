<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'ProductID';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null;

    protected $fillable = [
        'CategoryID',
        'ProductName',
        'Description',
        'Photo',
        'Status',
        'CreatedAt',
        'DocumentURL'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'ProductID');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'ProductID');
    }

    public function isFavorite()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->favorites()->where('AccountID', Auth::id())->exists();
    }

    public function feedback()
    {
        // 1 Sản phẩm có nhiều Feedback (1-nhiều)
        return $this->hasMany(Feedback::class, 'ProductID', 'ProductID');
    }

    // ...
}
