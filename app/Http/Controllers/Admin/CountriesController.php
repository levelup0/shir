<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Countries\CountriesStoreReq;
use App\Http\Requests\Countries\CountriesUpdateReq;
use App\Models\Countries;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
    }
    
    public function index(Request $request): JsonResponse
    {
        $sort_by_queue_show = $request->input('sort_by_queue_show');
        $search = $request->input('search');
        $status = $request->input('status');
        $sort = $request->input('sort');
        $dateFilter = $request->input('date_filter');
        $limit = $request->input('limit');

        $data = Countries::query();

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

        if (!is_null($dateFilter)) {
            DateFilter::execute($data, json_decode($dateFilter));
        }

        // if ($sort !== '-1') {
        //     SortData::execute($data, $sort, 'title');
        // }

        if($sort_by_queue_show == '1'){
            $data->orderBy('queue_show', "asc");
        }else{
            $data->orderBy('id', "desc");
        }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(CountriesStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = Countries::create($data);
    
        return Success::execute(['data' => $response]);
    }

    public function update(CountriesUpdateReq $request, Countries $countriesAdmin): JsonResponse
    {
        $countriesAdmin->name = $request->name;
        $countriesAdmin->save();

        return Success::execute(['data' => $countriesAdmin]);

    }

    public function show($id)
    {
        $data = Countries::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(Countries $countries): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $countries->delete();
        return DeleteRes::execute();
    }
}