<?php
namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

/* class ControllerFunctions {

        
    protected $adminName = "ADMINISTRADOR";
    protected $studentName = "ALUMNO";
    protected $teacherName = "PROFESOR";

    public function checkAdminRole(){
        $roleAdmin = Role::where('name',$this->adminName)->first();
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

    public function getStudentRoleId(){
        $studentRoleId = Role::where('name',$this->studentName)->pluck('id')->first();
        return $studentRoleId;
    }

    public function getTeacherRoleId(){
        $teacherRoleId = Role::where('name',$this->teacherName)->pluck('id')->first();
        return $teacherRoleId;
    }

    public function getAdminRoleId(){
        $adminRoleId = Role::where('name',$this->adminName)->pluck('id')->first();
        return $adminRoleId;
    }

    public function replaceAccents($string) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        return str_replace($a, $b, $string);
    }
    

    public function createImageFromBase64(User $user)
    {
        $defaultImagePath = 'users/default.png';
        $defaultRoute = 'users/';

        if ($user->image !== null) {
            $imageData = base64_decode($user->image);
            $fileName = $user->dni . '.png';
            $filePath = public_path('images/users/' . $fileName);
            file_put_contents($filePath, $imageData);
            $fileName = $defaultRoute . $fileName;
        } else {
            $fileName = $defaultImagePath;
        }
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

    public function checkIfDeleteForbiddenRole(Role $role){
        $studentRoleId = $this->getStudentRoleId();
        $teacherRoleId = $this->getTeacherRoleId();
        $adminRoleId = $this->getAdminRoleId();
        $forbiddenRoles = [$studentRoleId,$teacherRoleId,$adminRoleId];
        if (!in_array($role->id,$forbiddenRoles)) {
            return true;
        } else {
            return false;
        }
    }

} */


?>


