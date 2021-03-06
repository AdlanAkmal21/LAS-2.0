<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function leavedetail()
    {
        return $this->belongsTo('App\Models\LeaveDetail', 'leave_id', 'id');
    }

    public function refAppStatus()
    {
        return $this->belongsTo('App\Models\RefApplicationStatus', 'application_status_id', 'id');
    }

    public function refLeaveType()
    {
        return $this->belongsTo('App\Models\RefLeaveType', 'leave_type_id', 'id');
    }

    public function file()
    {
        return $this->hasOne('App\Models\File', 'application_id', 'id');
    }
}
