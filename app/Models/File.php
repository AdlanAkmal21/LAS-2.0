<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function application()
    {
        return $this->belongsTo('App\Models\LeaveApplication', 'application_id', 'id');
    }

}
