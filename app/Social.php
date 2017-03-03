<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider_name', 'provider_token', 'provider_user_id'
    ];

    public function user()
    {
        $this->belongsTo('App\User');
    }
}
