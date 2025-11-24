<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $primaryKey = 'FeedBackID';

    protected $fillable = [
        'ProductID',
        'AccountID',
        'Rating',
        'CommentText',
        'SubmissionDate'
    ];

    public $timestamps = false;

    /**
     * Get the product that owns the feedback
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    /**
     * Get the user that owns the feedback
     */
    public function user()
    {
        return $this->belongsTo(Account::class, 'AccountID', 'AccountID');
    }
}
