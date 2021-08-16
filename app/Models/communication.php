<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

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
     * Get the contact record associated with the communication.
     * @return \App\Models\Contact
     */
    public function contact()
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id');
    }

    /**
     * Get the User record associated with the communication.
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
