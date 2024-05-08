<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyStoreReq;
use App\Http\Requests\Currency\CurrencyUpdateReq;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
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

        $data = Currency::query();

        // if (!is_null($search)) {
        //     $data = $data->where(function ($query) use ($search) {
        //         $query->where('subscription_id', $search);
        //     });
        // }

        // if ($status !== "-1") {
        //     $data = $data->where(function ($query) use ($status) {
        //         $query->where('status', $status);
        //     });
        // }

        // if (!is_null($dateFilter)) {
        //     DateFilter::execute($data, json_decode($dateFilter));
        // }

        // if ($sort !== '-1') {
        //     SortData::execute($data, $sort, 'title');
        // }

        // if($sort_by_queue_show == '1'){
        //     $data->orderBy('queue_show', "asc");
        // }else{
        //     $data->orderBy('id', "desc");
        // }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(CurrencyStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = Currency::create($data);

        return Success::execute(['data' => $response]);
    }

    public function update(CurrencyUpdateReq $request, Currency $currencyAdmin): JsonResponse
    {
        $currencyAdmin->subscription_id = $request->subscription_id;
        $currencyAdmin->currency_id = $request->currency_id;
        $currencyAdmin->summ = $request->summ;
        $currencyAdmin->save();

        return Success::execute(['data' => $currencyAdmin]);

    }

    public function show($id)
    {
        $data = Currency::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(Currency $currencyAdmin): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $currencyAdmin->delete();
        return DeleteRes::execute();
    }
}