<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'productvariant';
    protected $primaryKey = 'VariantID';

    protected $fillable = [
        'ProductID',
        'ColourID',
        'VolumeID',
        'Price',
        'StockQuantity',
        'MainImage',
        'Status'
    ];

    public $timestamps = false;

    /**
     * Get the product that owns the variant
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    /**
     * Get the colour of the variant
     */
    public function colour()
    {
        return $this->belongsTo(Colour::class, 'ColourID', 'ColourID');
    }

    /**
     * Get the volume of the variant
     */
    public function volume()
    {
        return $this->belongsTo(Volume::class, 'VolumeID', 'VolumeID');
    }

    /**
     * Scope active variants
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 1);
    }

    /**
     * Scope variants in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('StockQuantity', '>', 0);
    }
}
