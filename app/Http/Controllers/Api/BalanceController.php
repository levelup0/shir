<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Countries;
use App\Models\Currency;
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

class BalanceController extends Controller
{
  public function index()
  {
      $user = Auth::user();

      $balances = Balance::where('user_id', $user->id)->get();

      if($balances->count() == 0)
      {
          $currencies = Currency::get();
          
          foreach($currencies as $currency)
          {
            $newBalance = new Balance();
            $newBalance->currency_id = $currency->id;
            $newBalance->user_id = $user->id;
            $newBalance->summ = 0;
            $newBalance->save();
          }

          $balances = Balance::where('user_id', $user->id)->get();

          $response = [
            'msg' => "",
            'success'=> true,
            'data' => $balances
          ];

          return response($response, 200);
      }
     
      $response = [
        'msg' => "",
        'success'=> true,
        'data' => $balances
      ];
  
      return response($response, 200);
  }

}