<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuthAuthorisations extends Model
{
    protected $table = 'users_to_oauth_authorisations';

    protected $fillable = ['network', 'network_user_id', 'user_id'];

    public function user() {
        $this->belongsTo('App\User');
    }
}
