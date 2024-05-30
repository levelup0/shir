<?php

namespace App\Http\Controllers\Api;

use App\Actions\Common\DateFilter;
use App\Actions\Common\LanguageFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;

use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Aprove\StoreAproveReq;
use App\Http\Requests\Aprove\UpdateAproveReq;
use App\Models\Aprove;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AproveController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
    }
    
    public function index(Request $request): JsonResponse
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $limit = $request->input('limit');
        $user_id = $request->input('user_id');
        $voz_id = $request->input('voz_id');

        $data = Aprove::query();

        if($user_id != 'none'){
            $data = $data->where("user_id", $user_id);
        }

        if($voz_id != 'none'){
            $data = $data->where("voz_id", $voz_id);
        }

        if (!is_null($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($status !== "none") {
            $data = $data->where(function ($query) use ($status) {
                $query->where('status', $status);
            });
        }
       
        $data = $data->with(['voz', 'user', 'voz.category_voz', 'voz.category_voz.category']);

        $data->orderBy('id', "desc");

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(StoreAproveReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = Aprove::create($data);

        return Success::execute(['data' => $response]);
    }

    public function update(UpdateAproveReq $request, Aprove $aprove): JsonResponse
    {
      
        $aprove->user_id = Auth::user()->id;
        $aprove->voz_id = $request->name;
        $aprove->status = 'in_progress';
        $aprove->save();

        return Success::execute(['data' => $aprove]);

    }

    public function show($id)
    {
        $data = Aprove::where('id', $id)->with(['voz', 'user'])->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(Aprove $news): JsonResponse
    {
        $news->delete();
        return DeleteRes::execute();
    }

    public function updateStatus(UpdateAproveReq $request)
    {
        $data = Aprove::where('id', $request->input('aprove_id'))->first();
        if(!is_null($data))
        {
            $data->status = $request->input('status');
            $data->save();

            $msg = '';
            if($request->input('status') == 'approved')
            {
                $msg = 'Заявка успешно принято!';
            }

            if($request->input('status') == 'in_progress')
            {
                $msg = 'Принятие заявки отозвано!';
            }

            return response()->json([
                'success' => true,
                'msg' => $msg
            ]);
        }
      
        return response()->json([
            'success' => false,
            'msg' => 'Произошла ошибка при добавления данных'
        ]);
    }
}