<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use Notifiable;

    protected $table = 'account';
    protected $primaryKey = 'AccountID';

    protected $fillable = [
        'Username',
        'Email',
        'Password',
        'Role',
        'Status'
    ];

    protected $hidden = [
        'Password',
    ];

    public $timestamps = false;

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'AccountID';
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->AccountID;
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return null; // Không dùng remember token
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->Role == 1;
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->Status == 1;
    }
}
