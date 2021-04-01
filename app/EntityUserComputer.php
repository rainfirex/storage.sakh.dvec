<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityUserComputer extends Model
{
    protected $fillable = [
        'entity_user_id', 'operatingsystem', 'servicepack', 'ipAddress', 'hostname'
    ];
}
