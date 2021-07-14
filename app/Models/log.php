<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
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
    * Get the user record associated with the log.
    * @return \App\Models\User
    */
   public function user()
   {
       return $this->hasMany(User::class, 'id', 'user_id');
   }
}
