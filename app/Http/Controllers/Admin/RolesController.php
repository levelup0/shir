<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\LanguageFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\FastResources\StoreUpdateImage;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\RolesStoreReq;
use App\Http\Requests\Roles\RolesUpdateReq;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends Controller
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
         
        $data = UserRole::whereIn('name', ['storekeeper', 'employee']);

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

        // $data = $data->with(['roles']);
        
        if ($sort !== '-1') {
            SortData::execute($data, $sort, 'name');
        }

        if($sort_by_queue_show == '1'){
            $data->orderBy('queue_show', "asc");
        }else{
            $data->orderBy('id', "desc");
        }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(RolesStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        $response = UserRole::create($data);
       /* if ($request->hasFile('image'))
            StoreUpdateImage::execute($response, $request->file('image'));*/

        return Success::execute(['data' => $response]);
    }

    public function update(RolesUpdateReq $request, UserRole $userRole): JsonResponse
    {
        $userRole->name = $request->name;
        $userRole->save();

        return Success::execute(['data' => $userRole]);

    }

    public function show($id)
    {
        $data = UserRole::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(UserRole $userRole): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $userRole->delete();
        return DeleteRes::execute();
    }
}