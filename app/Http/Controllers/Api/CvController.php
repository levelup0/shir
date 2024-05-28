<?php

namespace App\Http\Controllers\Api;

use App\Actions\Common\DateFilter;
use App\Actions\Common\LanguageFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Voz\StoreUpdateImage;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cv\StoreCvReq;
use App\Http\Requests\Cv\UpdateCvReq;
use App\Models\CV;
use App\Models\VozFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show','contactAssets','contactAssetsVozFiles');
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

        $data = CV::query();
        
        $data = $data->where("user_id", Auth::user()->id);

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
        // $data = $data->with(['category']);
        

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
    public function store(StoreCvReq $request): JsonResponse
    {
        // $data = $request->validated();
        // $response = CV::create($data);

        $_files = json_decode($request->input('files'));

        $user_id = Auth::user()->id;

        if (!empty($_files)) {
            foreach ($_files as $file) {
                if (!is_dir(storage_path('app/files/'.$user_id))) {
                    mkdir(storage_path('app/files/'.$user_id), 0777, true);
                }
    
                $random_name = md5(rand(11111, 99999));
                $file_name = $file->file_name;
                $file_format = $file->file_format;
                $file_size = $file->file_size;
                $content= base64_decode($file->base64);
                $file = fopen(storage_path('app/files/'.$user_id.'/'.$random_name.'.'.$file_format), 'w');
                fwrite($file, $content);
                fclose($file);
    
                $new_assets = new CV();
                $new_assets->user_id = $user_id;
                $new_assets->format = $file_format;
                $new_assets->src = $random_name.'.'.$file_format;
                $new_assets->size = $file_size;
                $new_assets->name = $file_name;
                $new_assets->save();
            }
        }
        // if ($request->hasFile('image'))
        //     StoreUpdateImage::execute($response, $request->file('image'));

        return Success::execute(['data' => 'успех']);
    }

    public function update(UpdateCvReq $request, CV $cv): JsonResponse
    {
        $cv->name = $request->name;
        $cv->description = $cv->description;
        $cv->sector = $cv->sector;
        $cv->publish_date = $request->publish_date;
        $cv->end_date = $request->end_date;
        $cv->category_voz_id = $request->category_voz_id;
        // $voz->user_id = Auth::user()->id;
        // $voz->status = 'created';
        $cv->save();

        return Success::execute(['data' => $cv]);

    }

    public function show($id)
    {
        $data = CV::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(CV $news): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $news->delete();
        return DeleteRes::execute();
    }

    public function contactAssets($file)
    {
        $data = CV::where('src', $file)->first();
        // dd($data);

        return response()->file(storage_path('app/files/'.$data->user_id.'/'.$data->src));
    }

    public function contactAssetsVozFiles($file)
    {
        $data = VozFiles::where('src', $file)->first();

        return response()->file(storage_path('app/voz_files/'.$data->voz_id.'/'.$data->src));
    }


    
}