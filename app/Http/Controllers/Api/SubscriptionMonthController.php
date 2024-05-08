<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionMonth;

class SubscriptionMonthController extends Controller
{
  public function index()
  {
      $subscriptionMonth = SubscriptionMonth::all();

      $response = [
        'msg' => "",
        'success'=> true,
        'data' => $subscriptionMonth
      ];

      return response($response, 200);
  }
}