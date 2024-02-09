<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Module extends Model
{
    use HasFactory;
    use HasApiTokens;


    public function cycles()
    {
        return $this->belongsToMany(Cycle::class,'cycle_module');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'module_user_cycle','module_id','user_id')->withPivot('cycle_id');
    }
     //relacion con modulos y ciclos para users no admin, no alumnos
     public function users1() {
        return $this->belongsToMany(User::class, 'user_id', 'module_id', 'user_id');
    }
}
