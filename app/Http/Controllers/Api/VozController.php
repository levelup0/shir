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
use App\Models\VozCategoryRelation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VozController extends Controller
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

        if($my == 'yes'){
            $data = $data->where("user_id", Auth::user()->id);
        }

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
        $data = $data->with(['user', 'category_voz', 'category_voz.category']);
        

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
    public function store(StoreVozReq $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'created';
        
        $response = Voz::create($data);

        $voz_category_relation = $data['voz_category_relation'];
        Log::info($response->id);

        Log::info(print_r($voz_category_relation, true));

        if(!empty($voz_category_relation) && $voz_category_relation !=null)
        {
            $decodeds = json_decode($voz_category_relation, true);
            foreach ($decodeds as $d) {
                $newData = new VozCategoryRelation();
                $newData->voz_id =  $response->id;
                $newData->category_voz_id = $d['id'];
                $newData->save();
            }
        }

        return Success::execute(['data' => $response]);
    }

    public function update(UpdateVozReq $request, Voz $voz): JsonResponse
    {
        $voz->name = $request->name;
        $voz->description = $voz->description;
        $voz->sector = $voz->sector;
        $voz->publish_date = $request->publish_date;
        $voz->end_date = $request->end_date;
        $voz->category_voz_id = $request->category_voz_id;
        // $voz->user_id = Auth::user()->id;
        // $voz->status = 'created';
        $voz->save();

        return Success::execute(['data' => $voz]);

    }

    public function show($id)
    {
        $data = Voz::where('id', $id)->with(['user','category_voz', 'category_voz.category'])->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(Voz $news): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $news->delete();
        return DeleteRes::execute();
    }
}