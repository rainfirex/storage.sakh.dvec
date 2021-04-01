<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityUserPassword extends Model
{
    protected $fillable = [
        'entity_user_id', 'title', 'password', 'description'
    ];
}
