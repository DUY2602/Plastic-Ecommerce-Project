<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDocument extends Model
{
    use HasFactory;

    protected $table = 'productdocument';
    protected $primaryKey = 'DocumentID';

    protected $fillable = [
        'ProductID',
        'DocumentName',
        'DocumentURL',
        'UploadDate'
    ];

    public $timestamps = false;

    /**
     * Get the product that owns the document
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}
