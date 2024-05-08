<?php

namespace App\Http\Controllers\Api;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Subscriptions\StoreUpdateImage;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\SubscriptionsStoreReq;
use App\Http\Requests\Subscriptions\SubscriptionsUpdateReq;
use App\Models\Subscriptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $sort_by_queue_show = $request->input('sort_by_queue_show');
        $search = $request->input('search');
        $status = $request->input('status');
        $sort = $request->input('sort');
        $dateFilter = $request->input('date_filter');
        $limit = $request->input('limit');

        $data = Subscriptions::query();

        if (!is_null($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($status !== "-1") {
            $data = $data->where(function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        if (!is_null($dateFilter)) {
            DateFilter::execute($data, json_decode($dateFilter));
        }

        if ($sort !== '-1') {
            SortData::execute($data, $sort, 'title');
        }

        $data = $data->with(['options', 'subscription_price', 'subscription_price.currency']);

        if($sort_by_queue_show == '1'){
            $data->orderBy('queue_show', "asc");
        }else{
            $data->orderBy('id', "desc");
        }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    
    public function show($id)
    {
        $data = Subscriptions::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }
}