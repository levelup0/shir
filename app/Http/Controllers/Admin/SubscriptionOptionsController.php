<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\SubscriptionOptions\StoreUpdateImage;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionOptions\SubscriptionOptionsStoreReq;
use App\Http\Requests\SubscriptionOptions\SubscriptionOptionsUpdateReq;
use App\Models\SubscriptionOptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionOptionsController extends Controller
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

        $data = SubscriptionOptions::query();

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

        $data = $data->with(['subcription']);

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
    public function store(SubscriptionOptionsStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = SubscriptionOptions::create($data);
        if ($request->hasFile('image'))
            StoreUpdateImage::execute($response, $request->file('image'));

        return Success::execute(['data' => $response]);
    }

    public function update(SubscriptionOptionsUpdateReq $request, SubscriptionOptions $subscriptionOptions): JsonResponse
    {
        $subscriptionOptions->name = $request->name;
        $subscriptionOptions->description = $request->description;
        // $subscriptionOptions->price = $request->price;
        if ($request->hasFile('image'))
        StoreUpdateImage::execute($subscriptionOptions, $request->file('image'));

        if($request->remove_image == "1"){
            $subscriptionOptions->image = null;
        }

        $subscriptionOptions->queue_show = $request->queue_show;
        $subscriptionOptions->status = $request->status;
     
        $subscriptionOptions->save();

        return Success::execute(['data' => $subscriptionOptions]);

    }

    public function show($id)
    {
        $data = SubscriptionOptions::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(SubscriptionOptions $subscriptionOptions): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $subscriptionOptions->delete();
        return DeleteRes::execute();
    }
}