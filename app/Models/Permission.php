<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable=[
        'permission_group_id',
        'name',
        'key',
        'sort_order'
    ];

    public function roles(){
        
        return $this->belongsToMany(Role::class);

    }
    public function permissionGroup(){
        return $this->belongsTo(permissionGroup::class);
    }
}
