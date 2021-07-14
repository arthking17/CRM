<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
