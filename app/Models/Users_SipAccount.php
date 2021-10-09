<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_SipAccount extends Model
{

    protected $table = 'users_sip_accounts';

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
    * Get the sip_account record associated with the Users_sip_account.
    * @return \App\Models\Sip_account
    */
   public function sipaccount()
   {
       return $this->hasMany(Sip_account::class, 'id', 'sipaccount_id');
   }

   /**
    * Get the user record associated with the Users_sip_account.
    * @return \App\Models\User
    */
   public function user()
   {
       return $this->hasMany(User::class, 'id', 'user_id');
   }
}
