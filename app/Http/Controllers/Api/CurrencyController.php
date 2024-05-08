<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

class CurrencyController extends Controller
{
  public function index()
  {
      $currencies = Currency::all();

      $response = [
        'msg' => "",
        'success'=> true,
        'data' => $currencies
      ];
  
      return response($response, 200);
  }

}