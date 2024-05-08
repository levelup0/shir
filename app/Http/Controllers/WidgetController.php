<?php

namespace App\Http\Controllers;

use App\Models\UserChats;
use App\Models\UserProfile;
use App\Traits\GenerateHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WidgetController extends Controller
{
    use GenerateHash;
    public function index(Request $request)
    {
      $hash = $request->route('hash');

      $userProfile = UserProfile::where('channel_hash', $hash)->where('status', 'enabled')->first();
      
      if(is_null($userProfile))
      {
            return response()->json(['success' => false, 'msg' => 'The widget is expired or incorrect']);
      }

     // Log::info(print_r($request->cookie(), true));

    /*  $algb_user_hash_cookie = $request->cookie('algb_user_hash_cookie');
      
      if($algb_user_hash_cookie != null && $algb_user_hash_cookie != "")
      {
            //Проверяем хаша на существования в БД. потому, что позже мы будем удалять старые хаши
            $userChats = UserChats::where('user_hash', $algb_user_hash_cookie)->first();
            //Если null значит мы его удалили, создаем новую
            Log::info("[WidgetController][algb_user_hash_cookie][Есть в куки или нет]".is_null($userChats));
            if(is_null($userChats))
            {
                  $algb_user_hash_cookie = $this->createHash($hash, $userProfile);
            }
      }else{
            //Если вообще нет то попытаемся создать нового userхеша
            Log::info("[WidgetController][algb_user_hash_cookie][Вообще нет, поэтому создаем новую user hash]");
            $algb_user_hash_cookie = $this->createHash($hash, $userProfile);
      }*/

      $data = [
            'channel_hash' => $hash,
          //  'user_hash' => $algb_user_hash_cookie
      ];

      $view = view()->make('embed', [
            'hash_data' => json_encode($data),
          
      ])
      ->withHeaders([
            'Content-Type' => 'application/javascript'
      ]);
      
      return $view->render();
    }
}
