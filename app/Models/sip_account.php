<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sip_account extends Model
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
    * Get the account record associated with the Sip_account.
    * @return \App\Models\Account
    */
   public function account()
   {
       return $this->hasMany(Account::class, 'id', 'account_id');
   }

   /**
    * Get the channel record associated with the Sip_account.
    * @return \App\Models\Channel
    */
   public function channel()
   {
       return $this->hasMany(Channel::class, 'id', 'channel_id');
   }

   /**
    * Get the users sip accounts record associated with the users sip accounts
    * @return \App\Models\Users_SipAccount
    */
   public function users_sipaccount()
   {
       return $this->belongsTo(Users_SipAccount::class);
   }
}
