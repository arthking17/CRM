<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
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
     * Get the account record associated with the contact.
     * @return \App\Models\Account
     */
    public function account()
    {
        return $this->hasMany(Account::class, 'id', 'account_id');
    }
    
    /**
     * Get the Contact_data record associated with the contact.
     * @return \App\Models\Contact_data
     */
    public function contact_datas()
    {
        return $this->belongsToMany('\App\Contact_data');
    }
}
