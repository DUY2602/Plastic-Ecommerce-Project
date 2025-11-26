<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

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
     * Tự động mã hóa mật khẩu khi gán giá trị
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = Hash::make($value);
    }

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
        return null;
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

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'AccountID');
    }
}
