<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserChats;
use App\Models\UserMessages;
use App\Models\UserRole;
use App\Models\UserRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function getCountries(Request $request)
    {
        $data = Countries::all();

        $response = [
            'msg' => "",
            'success'=> true,
            'data' => $data
        ];

        return response($response, 200);
    }

    public function getUser(Request $request)
    {
        if(Auth::check())
        {
            $response = [
                'msg' => "Пользователь успешно отправлен",
                'success'=> true,
                'user' => User::with('roles')->find(Auth::id())
             ];

             return response($response, 200);
        } 

        $response = [
            'msg' => "Пользователь не найден",
            'success'=> false,
            'user' => []
         ];

         return response($response, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type_user' => 'in:0,1',
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

        $type_user = $request->input("type_user");
        $user_role = null;

        if($type_user == '1'){

            Log::info('1'); // Вызоводатель
            $user_role = UserRole::where('name', 'caller')->first();
        }

        if($type_user == '0'){
            Log::info('0'); // Вызовополучатель
            $user_role = UserRole::where('name', 'recipient')->first();
        }

        if(!is_null($user_role))
        {
            $request['password']= Hash::make($request['password']);
            // $request['remember_token'] = Str::random(10);
            $newUser = new User();
            $newUser->name = $request->input('name');
            $newUser->business_sector = $request->input('business_sector');
            $newUser->action_sector = $request->input('action_sector');
            
            $newUser->email = $request->input('email');
            $newUser->password = $request->input('password');
            $newUser->user_role_id = $user_role->id;
            
            $newUser->save();
            // $user = User::create($request->toArray());
            // $token = $newUser->createToken('appToken')->accessToken;
     
            //  $response = [
            //     'msg' => "Пользователь успешно создан",
            //     'success'=> true,
            //     'token' => $token,
            //     'user' => $newUser
            //  ];

             $user_token['token'] = $newUser->createToken('appToken')->accessToken;
    
             return response()->json([
                 'success' => true,
                 'token' => $user_token,
                 'user' => $newUser,
                 'msg' => 'Успешно'
             ], 200);

            //  return response($response, 200);
        }

        $response = [
            'msg' => "Роль не найдено",
            'success'=> false,
        ];

        return response($response, 200);
    }
     /**
    * Handle an incoming authentication request.
    */
    
    public function store(Request $request)
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
        Log::info("email". request('email'));
        Log::info("password". request('password'));
        
        //get verify response data
      //  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$token_captcha);
       // $responseData = json_decode($verifyResponse);

        if(true)
        {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                // successfull authentication
                
                $user = User::find(Auth::user()->id);
                $user->avatar = '';
               // $user = $user->exclude(['avatar']);

               $token = $user->createToken('appToken');
               // $user_token['token'] = $user->createToken('appToken')->accessToken;
    
                
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => $user,
                    'msg' => 'Успешно'
                ], 200);

                // return response()->json([
                //     'success' => true,
                //     'token' => $user_token,
                //     'user' => $user,
                //     'msg' => 'Успешно'
                // ], 200);
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

    //Login With Google

    public function storeGoogle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'token_captcha' => 'required|string',
            'email' => 'required|string',
            'google_id' => 'required|string',
            // 'given_name' => 'required|string', //Yakubov
            // 'family_name' => 'required|string', //Muhammad
            'name' => 'required|string', //Muhammad
        ]);

        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
             ];

            return response($response, 200);
        }

        Log::info("email". request('email'));
        Log::info("google_id". request('google_id'));

        $email = $request->input('email');
        $google_id = $request->input('google_id');
        $name = $request->input('name');
        // $family_name = $request->input('family_name');

        $currentUser = User::where('email', $email)->first();

        if(is_null($currentUser))
        {
            $userRole = UserRole::where('name', 'operator')->first();
            //Создаем новый пользователь
            $password = Hash::make($email.$google_id);
            
            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->password = $password;
            $newUser->user_role_id = $userRole->id;
            $newUser->google_id = $google_id;
            $newUser->save();
             
            $token = $newUser->createToken('appToken')->accessToken;
     
            $response = [
                'msg' => "Пользователь успешно создан",
                'success'=> true,
                'token' => $token,
                'user' => $newUser
             ];

             return response($response, 200);
        }else{
            //Пытаемя залагинуться
            if (Auth::attempt(['email' => $email, 'password' => $email.$google_id])) {
                // successfull authentication
                
                $user = User::find(Auth::user()->id);
                $user->avatar = '';
               // $user = $user->exclude(['avatar']);

                $user_token['token'] = $user->createToken('appToken')->accessToken;
    
                return response()->json([
                    'success' => true,
                    'token' => $user_token,
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
    }

     /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Request $request)
  {
      if (Auth::user()) {
          $request->user()->token()->revoke();

          return response()->json([
              'success' => true,
              'message' => 'Logged out successfully',
          ], 200);
      }
  }

  /**
   * Данная функция отвечает за сброса пароля с личного кабинета
   */
  public function passwordUpdate(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'password' => 'required|string|min:6',
        'name' => 'string'
    ]);

    if ($validator->fails())
    {
        $response = [
            'msg' => implode(',', $validator->errors()->all()),
            'success'=> false,
        ];

        return response($response, 200);
    }

    $user = Auth::user();

    $currentUser = User::where('id', $user->id)->first();

    if(!is_null($currentUser))
    {
        $currentUser->password = Hash::make($request['password']);
        $currentUser->name = $request['name'];
        $currentUser->business_sector = $request['business_sector'];
        $currentUser->action_sector = $request['action_sector'];

        $currentUser->save();

        return response()->json([
            'success' => true,
            'msg' => 'Профиль успешно изменен',
        ], 200);
    }

    return response()->json([
        'success' => false,
        'msg' => 'Пользователь не найден',
    ], 200);
  }
}
