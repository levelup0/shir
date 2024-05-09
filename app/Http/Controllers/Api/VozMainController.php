<?php

namespace App\Http\Controllers\Api;

use App\Actions\Common\DateFilter;
use App\Actions\Common\LanguageFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Voz\StoreUpdateImage;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Voz\StoreVozReq;
use App\Http\Requests\Voz\UpdateVozReq;
use App\Models\Voz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VozMainController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
    }
    
    public function index(Request $request): JsonResponse
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $sort = $request->input('sort');
        $dateFilter = $request->input('date_filter');
        $languageFilter = $request->input('language_filter');
        $languageFilterNew = $request->input('language_filter_new');
        $limit = $request->input('limit');
        $publish_date = $request->input('publish_date');
        $type = $request->input('type');
        $my = $request->input('my');

        $data = Voz::query();

        // if($my == 'yes'){
        //     $data = $data->where("user_id", Auth::user()->id);
        // }

        if (!is_null($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        // if ($status !== "-1") {
        //     $data = $data->where(function ($query) use ($status) {
        //         $query->where('status', $status);
        //     });
        // }

        // if (!is_null($type)) {
        //     $data = $data->where(function ($query) use ($type) {
        //         $query->where('type', 'like', '%' . $type . '%');
        //     });
        // }

        if (!is_null($dateFilter)) {
            DateFilter::execute($data, json_decode($dateFilter));
        }
        
        // if (!is_null($languageFilter)) {
        //     LanguageFilter::execute($data, json_decode($languageFilter, true));
        // }

        // if (!is_null($languageFilterNew)) {
        //     LanguageFilter::executeNew($data, $languageFilterNew);
        // }
        $data = $data->with(['category', 'user']);
        

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

    public function show($id)
    {
        $data = Voz::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(Voz $news): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $news->delete();
        return DeleteRes::execute();
    }
}