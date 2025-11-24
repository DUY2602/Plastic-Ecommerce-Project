<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasFactory;

    protected $table = 'volume';
    protected $primaryKey = 'VolumeID';

    protected $fillable = [
        'VolumeValue'
    ];

    public $timestamps = false;

    /**
     * Get variants for the volume
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'VolumeID', 'VolumeID');
    }
}
