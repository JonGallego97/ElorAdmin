<?php
namespace App\Http\Controllers;


use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

class ControllerFunctions {
    
    public function checkAdminRole(){
        $roleAdmin = Role::where('name','ADMINISTRADOR')->first();
        $logedUserRoles = Auth::user()->roles->pluck('name')->toArray();
        if(in_array($roleAdmin->name,$logedUserRoles)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkAdminRoute(){
        $route = Route::getCurrentRoute()->uri;
        if(Str::contains($route,'admin/')){
            return true;
        } else {
            return false;
        }
    }

    function createImageFromBase64(String $imageString)
    {
        $image = imagecreatefromstring(base64_decode($imageString));
        header('Content-type: image/png');
        return imagejpeg($image);
    }

}


?>


