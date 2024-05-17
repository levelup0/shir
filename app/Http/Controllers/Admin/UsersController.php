<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Common\DateFilter;
use App\Actions\Common\LanguageFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\FastResources\StoreUpdateImage;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersStoreReq;
use App\Http\Requests\Users\UsersUpdateReq;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
        $user_role = $request->input('user_role');

        //Текущий пользователь кто
        //$data = UserRole::whereIn('name', ['admin', 'storekeeper', 'employee']);
        
      //  $data = User::query();
        if($user_role == 'all'){
            $data = User::with('roles')->whereHas('roles', function ($query) use ($search){
                $query->whereIn('name', ['admin', 'caller', 'employee']);
            });
        }else if($user_role == 'caller'){
            $data = User::with('roles')->whereHas('roles', function ($query) use ($search){
                $query->whereIn('name', ['caller']);
            }); 
        }else if($user_role == 'recipient'){
            $data = User::with('roles')->whereHas('roles', function ($query) use ($search){
                $query->whereIn('name', ['recipient']);
            }); 
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

        if (!is_null($dateFilter)) {
            DateFilter::execute($data, json_decode($dateFilter));
        }

        $data = $data->with(['roles','cv', 'category_voz', 'category_voz.category']);
        
        // if ($sort !== '-1') {
        //     SortData::execute($data, $sort, 'title');
        // }
        
        //$data = $data->exclude(['avatar']);
        
        $data->orderBy('id', "desc");
        // if($sort_by_queue_show == '1'){
        //     $data->orderBy('queue_show', "asc");
        // }else{
          
        // }

        return Success::execute(['data' => $data->paginate($limit)]);

    }
    public function store(UsersStoreReq $request): JsonResponse
    {
        $data = $request->validated();
        
        /**Тут проверяем кто кого создал */
        if(!empty($data['user_role_id']) && $data['user_role_id'] != null)
        {
            //Кто есть я
            $currentAuthUser = User::where('id', Auth::user()->id)->first();
            $roleName = UserRole::where('id', $currentAuthUser->user_role_id)->first();
            
            //Значит текущий пользователь либо супер админ ли бо админ
            if($roleName->name == 'superadmin' || $roleName->name == 'admin')
            {
                //Тут мы должны проверить что он хочеть создать Кладовщика или же Сотрудника
                $currentCreateUserRole = UserRole::where('id', $data['user_role_id'])->first();
                
                if($currentCreateUserRole->name == 'storekeeper' || $currentCreateUserRole->name == 'employee')
                {
                    //Теперь можем создать кладовщика или же сотрудника
                    $data['user_id_created'] = Auth::user()->id;
                    $response = User::create($data);
                    return Success::execute(['data' => $response]);
                }
            }

            //Если я Кладовщик то тогда могу создать только сотрудника
            if($roleName->name == 'storekeeper')
            {
                //Тут мы должны проверить что он хочеть создать Кладовщика или же Сотрудника
                $currentCreateUserRole = UserRole::where('id', $data['user_role_id'])->first();
                
                if($currentCreateUserRole->name == 'employee')
                {
                    //Теперь можем создать кладовщика или же сотрудника
                    $data['user_id_created'] = Auth::user()->id;
                    $response = User::create($data);
                    return Success::execute(['data' => $response]);
                }
            }
        }
    }

    public function update(UsersUpdateReq $request, User $user): JsonResponse
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_role_id = $request->user_role_id;
       /* if ($request->hasFile('image'))
        StoreUpdateImage::execute($user, $request->file('image'));*/

        // if($request->remove_image == "1"){
        //     $user->image = null;
        // }

       // $user->status = $request->status;
     
        $user->save();

        return Success::execute(['data' => $user]);

    }

    public function show($id)
    {
        $data = User::where('id', $id)->first();
        return Success::execute(['data' => $data]);
    }

    public function destroy(User $user): JsonResponse
    {
        // return Error::execute("News delete is disabled");
        $user->delete();
        return DeleteRes::execute();
    }
}