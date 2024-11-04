<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;//use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->hasMany('App\Models\User','role_id');
    }

    public function permission(){
        return $this->hasOne('App\Models\Permission','role_id');
    }
}
