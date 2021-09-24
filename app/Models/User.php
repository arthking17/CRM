<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pwd;
    }
    
    /**
     * Indicates if the model should be rememberToken.
     *
     * @var bool
     */
    public $rememberTokenName = false;

    /**
     * Get the account record associated with the user.
     * @return \App\Models\Account
     */
    public function account()
    {
        return $this->hasMany(Account::class, 'id', 'account_id');
    }

    /**
     * Get the logs record associated with the log
     * @return \App\Models\Log
     */
    public function logs()
    {
        return $this->belongsTo(Log::class);
    }
}
