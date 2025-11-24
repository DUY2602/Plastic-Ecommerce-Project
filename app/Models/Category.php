<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'CategoryID';

    protected $fillable = [
        'CategoryName',
        'Description',
        'Status'
    ];

    public $timestamps = false;

    /**
     * Get products for the category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CategoryID');
    }

    /**
     * Scope active categories
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 1);
    }
}
