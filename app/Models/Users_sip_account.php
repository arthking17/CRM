<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_sip_account extends Model
{
    use HasFactory;

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
   protected $guarded = [];

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
