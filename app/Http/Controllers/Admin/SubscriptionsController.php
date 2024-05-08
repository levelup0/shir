<?php

namespace App\Http\Controllers\Admin;

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

        $data = Subscriptions::query();

        if (!is_null($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
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

        if($sort_by_queue_show == '1'){
            $data->orderBy('queue_show', "asc");
        }else{
            $data->orderBy('id', "desc");
        }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(SubscriptionsStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = Subscriptions::create($data);
        if ($request->hasFile('image'))
            StoreUpdateImage::execute($response, $request->file('image'));

        return Success::execute(['data' => $response]);
    }

    public function update(SubscriptionsUpdateReq $request, Subscriptions $subscription): JsonResponse
    {
        $subscription->name = $request->name;
        $subscription->description = $request->description;
        $subscription->price = $request->price;
        if ($request->hasFile('image'))
        StoreUpdateImage::execute($subscription, $request->file('image'));

        if($request->remove_image == "1"){
            $subscription->image = null;
        }

        $subscription->queue_show = $request->queue_show;
        $subscription->status = $request->status;
     
        $subscription->save();

        return Success::execute(['data' => $subscription]);

    }

    public function show($id)
    {
        $data = Subscriptions::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(Subscriptions $subscriptions): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $subscriptions->delete();
        return DeleteRes::execute();
    }
}