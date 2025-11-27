<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'ProductID';

    protected $fillable = [
        'CategoryID',
        'ProductName',
        'Description',
        'Photo',
        'Status',
        'CreatedAt'
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
    // Product.php

    // ... bên trong class Product extends Model

    // THÊM DÒNG NÀY:
    public function feedback()
    {
        // 1 Sản phẩm có nhiều Feedback (1-nhiều)
        return $this->hasMany(Feedback::class, 'ProductID', 'ProductID');
    }

    // ...
}
