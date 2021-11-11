<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;


class LoginController extends Controller
{

    public function Register(Type $var = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }
    
    public function Login(Request $request)
    { 
        $creds = [
            'email' => $request->email, 
            'password' => $request->password
        ];

        // dd($credentials);

        if(Auth::attempt($creds))
        { 
            $user = Auth::user();   
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            return BaseController::sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return BaseController::sendError('Unauthorised.', ['error'=>'Unauthorised']);

        } 
    }
}