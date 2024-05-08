<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryVoz;

class CategoryVozController extends Controller
{
  public function index()
  {
      $data = CategoryVoz::all();

      $response = [
        'msg' => "",
        'success'=> true,
        'data' => $data
      ];
  
      return response($response, 200);
  }

}