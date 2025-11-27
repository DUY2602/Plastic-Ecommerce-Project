<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorCount extends Model
{
    use HasFactory;

    protected $table = 'visitor_count';

    protected $fillable = [
        'date',
        'count'
    ];

    public $timestamps = false;

    // THÊM CAST để đảm bảo kiểu dữ liệu
    protected $casts = [
        'date' => 'date',
        'count' => 'integer'
    ];
}
