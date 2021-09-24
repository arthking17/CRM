<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Email_account extends Model
{

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
   protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the account record associated with the Email Account.
     * @return \App\Models\Account
     */
    public function account()
    {
        return $this->hasMany(Account::class, 'id', 'account_id');
    }
}
