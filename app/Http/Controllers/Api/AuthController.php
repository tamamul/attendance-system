<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function login(Request $req) {
        $user = User::where('email',$req->email)->first();
        if($user && Hash::check($req->password, $user->password)){
            return ['success'=>true,'user'=>$user];
        }
        return response(['error'=>'invalid'],401);
    }
    public function users() {
        return User::all();
    }
}
