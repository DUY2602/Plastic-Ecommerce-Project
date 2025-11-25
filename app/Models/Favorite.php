<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';
    protected $primaryKey = 'id';

    protected $fillable = ['AccountID', 'ProductID'];

    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(Account::class, 'AccountID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}
