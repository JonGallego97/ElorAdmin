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
        return $this->belongsToMany(User::class);
    }
}
