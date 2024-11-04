<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;use SoftDeletes;
    protected $fillable = ['role_id','access','list','view','add','edit','delete','search','status','export',];
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
}
