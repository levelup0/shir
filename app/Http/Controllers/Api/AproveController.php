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

        // if (!is_null($type)) {
        //     $data = $data->where(function ($query) use ($type) {
        //         $query->where('type', 'like', '%' . $type . '%');
        //     });
        // }

       
        
        // if (!is_null($languageFilter)) {
        //     LanguageFilter::execute($data, json_decode($languageFilter, true));
        // }

        // if (!is_null($languageFilterNew)) {
        //     LanguageFilter::executeNew($data, $languageFilterNew);
        // }
        $data = $data->with(['voz', 'user']);
        

        $data->orderBy('id', "desc");

        // if ($sort !== '-1') {
        //     SortData::execute($data, $sort, 'name');
        // } else {
        //     if($publish_date == "1"){
        //         $data->orderBy('publish_date', "desc");
        //     }else{
        //         $data->orderBy('id', "desc");
        //     }
        // }

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
        // return Error::execute("News delete is disabled");
        $news->delete();
        return DeleteRes::execute();
    }
}