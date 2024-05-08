<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionMonth\SubscriptionMonthStoreReq;
use App\Http\Requests\SubscriptionMonth\SubscriptionMonthUpdateReq;
use App\Models\SubscriptionMonth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionMonthController extends Controller
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

        $data = SubscriptionMonth::query();

        if (!is_null($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', $search);
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


        // if($sort_by_queue_show == '1'){
        //     $data->orderBy('queue_show', "asc");
        // }else{
        //     $data->orderBy('id', "desc");
        // }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(SubscriptionMonthStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = SubscriptionMonth::create($data);

        return Success::execute(['data' => $response]);
    }

    public function update(SubscriptionMonthUpdateReq $request, SubscriptionMonth $subscriptionMonthAdmin): JsonResponse
    {
        $subscriptionMonthAdmin->name = $request->name;
        $subscriptionMonthAdmin->discount = $request->discount;
        $subscriptionMonthAdmin->count_month = $request->count_month;
        $subscriptionMonthAdmin->save();

        return Success::execute(['data' => $subscriptionMonthAdmin]);

    }

    public function show($id)
    {
        $data = SubscriptionMonth::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(SubscriptionMonth $subscriptionMonthAdmin): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $subscriptionMonthAdmin->delete();
        return DeleteRes::execute();
    }
}