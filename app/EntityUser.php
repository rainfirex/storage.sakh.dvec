<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityUser extends Model
{
    protected $fillable = [
        'user_id', 'username', 'login', 'email', 'department',
        'title', 'phone', 'othertelephone', 'mobile', 'city',
        'street', 'cabinet'
    ];

    public function computers() {
        return $this->hasMany(EntityUserComputer::class, 'entity_user_id', 'id');
    }

    public function passwords(){
        return $this->hasMany(EntityUserPassword::class, 'entity_user_id', 'id');
    }
}
