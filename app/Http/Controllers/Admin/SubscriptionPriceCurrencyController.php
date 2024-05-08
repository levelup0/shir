<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPriceCurrency\SubscriptionPriceCurrencyStoreReq;
use App\Http\Requests\SubscriptionPriceCurrency\SubscriptionPriceCurrencyUpdateReq;
use App\Models\SubscriptionPriceCurrency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionPriceCurrencyController extends Controller
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

        $data = SubscriptionPriceCurrency::query();

        if (!is_null($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('subscription_id', $search);
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

        if ($sort !== '-1') {
            SortData::execute($data, $sort, 'title');
        }

        $data= $data->with(['subcription', 'currency']);

        // if($sort_by_queue_show == '1'){
        //     $data->orderBy('queue_show', "asc");
        // }else{
        //     $data->orderBy('id', "desc");
        // }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(SubscriptionPriceCurrencyStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = SubscriptionPriceCurrency::create($data);

        return Success::execute(['data' => $response]);
    }

    public function update(SubscriptionPriceCurrencyUpdateReq $request, SubscriptionPriceCurrency $subscriptionPriceAdmin): JsonResponse
    {
        $subscriptionPriceAdmin->subscription_id = $request->subscription_id;
        $subscriptionPriceAdmin->currency_id = $request->currency_id;
        $subscriptionPriceAdmin->summ = $request->summ;
        $subscriptionPriceAdmin->save();

        return Success::execute(['data' => $subscriptionPriceAdmin]);

    }

    public function show($id)
    {
        $data = SubscriptionPriceCurrency::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(SubscriptionPriceCurrency $subscriptionPriceCurrencyAdmin): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $subscriptionPriceCurrencyAdmin->delete();
        return DeleteRes::execute();
    }
}