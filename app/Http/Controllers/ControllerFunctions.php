<?php
namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
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
    

    public function createImageFromBase64(User $user)
    {
        $imageData = base64_decode($user->image);
        $fileName = $user->dni . '.png';
        $filePath = public_path('images/' . $fileName);
        file_put_contents($filePath,$imageData);
        return $fileName;
    }

    public function checkDNI(String $dni)
    {
        $DNILetterArray = array('T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E');

        $numbers = substr($dni,0,-1);
        $letter = round((float)$numbers /23,2);
        $letter = round(($letter - (int)$letter)*23,0);
        $userID = $numbers . $DNILetterArray[$letter];
        if($userID == $dni) {
            return true;
        } else {
            return false;
        }
    }

}


?>


