<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;

use Exception;
class LoginService{


    public function login($data){
        $username = $data->username;
        $password = $data->password;

        if(!$username || !$password){
            throw new Exception("Missing credentials", 500);
        }

        $canLogin = false;

        $userInfo = self::checkIfExist('email',$username);
        if(!$userInfo){
            return response()->json([
                'status' => 0,
                'message' => 'Email does not exist.'
            ]);
        }
        if(!Hash::check($password,$userInfo->password)){
            return response()->json([
                'status' => 0,
                'message' => 'Invalid Credentials'
            ]);
        }
        $token = $userInfo->createToken('userlogin-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'status' => 1,
            'message' => 'Successfully Login'
        ]);
    }
    protected function checkIfExist($column , $value)
    {
        return User::where($column,$value)->first();
    }
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Successfully deleted'
        ]);
    }
}
