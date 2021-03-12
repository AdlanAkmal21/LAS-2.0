<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userdetail()
    {
        return $this->hasOne('App\Models\UserDetail', 'user_id', 'id');
    }

    public function leavedetail()
    {
        return $this->hasOne('App\Models\LeaveDetail', 'user_id', 'id');
    }

    public function application()
    {
        return $this->hasMany('App\Models\LeaveApplication', 'user_id', 'id');
    }

    public function refRole()
    {
        return $this->belongsTo('App\Models\RefRole', 'role_id', 'id');
    }

    public function refEmpStatus()
    {
        return $this->belongsTo('App\Models\RefEmpStatus', 'emp_status_id', 'id');
    }

    public function user_log()
    {
        return $this->hasMany('App\Models\UserLog', 'user_id', 'id');
    }
}
