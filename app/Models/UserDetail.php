<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo('App\Models\User', 'approver_id', 'id');
    }

    public function refGender()
    {
        return $this->belongsTo('App\Models\RefGender', 'gender_id', 'id');
    }


}
