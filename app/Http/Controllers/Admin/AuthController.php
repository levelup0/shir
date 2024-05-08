<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Success;
use App\Actions\Error;
use App\Actions\SuccessMsg;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserChats;
use App\Models\UserMessages;
use App\Models\UserRole;
use App\Traits\UserRoleTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateAdminPassword\UpdateAdminPasswordReq;
use Illuminate\Http\JsonResponse;
class AuthController extends Controller
{
  use UserRoleTrait;

  public function login(Request $request)
  {
      $validator = Validator::make($request->all(), [
          //'token_captcha' => 'required|string',
          'email' => 'required|string',
          'password' => 'required|string',
      ]);

      if ($validator->fails())
      {
          $response = [
              'msg' => implode(',', $validator->errors()->all()),
              'success'=> false,
            ];

          return response($response, 200);
      }


      $token_captcha = $request->input('token_captcha');
      $secret = env('GOOGLE_RECAPTCHA_SECRET');
      
      //get verify response data
    //  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$token_captcha);
      // $responseData = json_decode($verifyResponse);

      if(true)
      {
          if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
              $user = User::find(Auth::user()->id);
  
              $token = $user->createToken('appToken');
  
              return response()->json([
                  'success' => true,
                  'token' => $token,
                  'user' => $user,
                  'msg' => 'Успешно'
              ], 200);
          } else {
              return response()->json([
                  'success' => false,
                  'msg' => 'Пользователь не найден',

              ], 200);
          }
      }
      else
      {
          return response()->json([
              'success' => false,
              'msg' => 'reCaptcha is not verified'
          ], 200);
      }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
             ];

            return response($response, 200);
        }

        $user_role = UserRole::where('name', 'admin')->first();

        if(!is_null($user_role))
        {
            $request['password']= Hash::make($request['password']);
            // $request['remember_token'] = Str::random(10);
            $newUser = new User();
            $newUser->name = $request->input('name');
            $newUser->email = $request->input('email');
            $newUser->password = $request->input('password');
            $newUser->user_role_id = $user_role->id;
            
            $newUser->save();
            // $user = User::create($request->toArray());
             $token = $newUser->createToken('appToken')->accessToken;
     
             $response = [
                'msg' => "Пользователь успешно создан",
                'success'=> true,
                'token' => $token,
                'user' => $newUser
             ];

             return response($response, 200);
        }

        $response = [
            'msg' => "Роль не найдено",
            'success'=> false,
        ];

        return response($response, 200);
    }

    /**
     * Get User
     */
    public function user()
    {
        /**
         * Checks if user valid in session;
        */
        if (Auth::guard('api')->check())
        {
            
            // $user = Auth::guard('api')->user();

            // if(!$this->isAdmin($user))
            // {
            //   return Error::execute("The user is not admin");
            // }
            $user = User::with('roles')->where('id', Auth::guard('api')->user()->id)->first();
            
            return Success::execute([
                'user' => $user
            ]);
    
        }else{
            logger("User not authorized");
        }
    }

    /**
     * Update password admin
     */
     
    public function updatePassword(UpdateAdminPasswordReq $request): JsonResponse
    {
        $user = Auth::user();
        if(!$this->isAdmin($user))
        {
          return Error::execute("The user is not admin");
        }
        
        if ($request->new_password) $user->password = Hash::make($request->new_password);
        $user->save();

        return SuccessMsg::execute('Пароль успешно изменен');
    }
  }