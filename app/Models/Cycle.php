<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class,'cycle_module');
    }
    public function sortedModules()
    {
        return $this->belongsToMany(Module::class)->orderBy('name', 'asc');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'cycle_users', 'user_id', 'cycle_id');
    }
    //relacion con modulos y ciclos para users no admin, no alumnos
    public function users1() {
        return $this->belongsToMany(User::class, 'user_id', 'module_id', 'user_id');
    }

}
