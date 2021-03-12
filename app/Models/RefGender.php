<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefGender extends Model
{
    use HasFactory;

    public function userdetail()
    {
        return $this->hasOne('App\Models\UserDetail', 'gender_id', 'id');
    }
}
