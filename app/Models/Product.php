<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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

    public $timestamps = false;

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    /**
     * Get variants for the product
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'ProductID', 'ProductID');
    }

    /**
     * Get feedback for the product
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'ProductID', 'ProductID');
    }

    /**
     * Get documents for the product
     */
    public function documents()
    {
        return $this->hasMany(ProductDocument::class, 'ProductID', 'ProductID');
    }

    /**
     * Scope active products
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 1);
    }

    /**
     * Scope products by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('CategoryID', $categoryId);
    }
}
