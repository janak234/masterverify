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
        'firstname','lastname',
        'email','role_id',
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

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function hasAccess($module,$modType)
    {
        $userRole = $this->role;
        if($module == 'permission' && $userRole->id == 1){return true;}

        if(strpos($module,',')){$accessModule = explode(',',$module);}
        else{$accessModule = array($module);}

        $userPermission = json_decode($userRole->permission,true);
        $userPermission = $userPermission[$modType];
        $userAcccess = explode(',',$userPermission);

        if(array_intersect($accessModule,$userAcccess)){return true;}
        return false;
    }
}
