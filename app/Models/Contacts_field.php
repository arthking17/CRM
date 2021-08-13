<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts_field extends Model
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
     * Get the custom_fields record associated with the contacts_fields.
     * @return \App\Models\Custom_field
     */
    public function custom_field()
    {
        return $this->hasMany(Custom_field::class, 'id', 'field_id');
    }

    /**
     * Get the option record associated with the contacts_fields.
     * @return \App\Models\Custom_select_field
     */
    public function option()
    {
        return $this->hasMany(Custom_select_field::class, 'id', 'field_value');
    }
}
