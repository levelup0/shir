<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\MassAction;
use App\Actions\SuccessMsg;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminPassword\UpdateAdminPasswordReq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MassActionController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
    }
    
    public function index(Request $request): JsonResponse
    {
        $ids = json_decode($request->input("ids"));
        $actionType = $request->input("action_type");
        $requestModel = $request->input("model");

        if (!is_null($ids) && !is_null($requestModel) && !is_null($actionType)) {
            MassAction::execute($ids, $actionType, $requestModel);
        }

        return SuccessMsg::execute('Success');
    }
}
