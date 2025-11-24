<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    use HasFactory;

    protected $table = 'colour';
    protected $primaryKey = 'ColourID';

    protected $fillable = [
        'ColourName'
    ];

    public $timestamps = false;

    /**
     * Get variants for the color
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'ColourID', 'ColourID');
    }
}
