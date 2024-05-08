<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserChats;
use App\Models\UserMessages;
use App\Models\UserProfile;
use App\Models\UserRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Traits\GenerateHash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    use GenerateHash;

    public function createMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_hash' => 'required|string',
            'msg' => 'required|string',
            'uuid' => 'required|string',
            'sender' => 'required|string',
        ]);
    
        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        $userHash = $request->input('user_hash');

        $userChats = UserChats::where('user_hash', $userHash)->first();
        if(is_null($userChats))
        {
            $response = [
                'msg' => "UserChat not found",
                'success'=> false,
            ];
    
            return response()->json($response);
        }

        $userRoom = UserRooms::where('user_chat_id', $userChats->id)->first();

        if(is_null($userRoom))
        {
            $response = [
                'msg' => "userRoom not found",
                'success'=> false,
            ];
    
            return response()->json($response);
        }

        $uuid = $request->input('uuid');

        $timeMessage = \Carbon\Carbon::now()->format('H:i');

        $newMessage = new UserMessages();
        $newMessage->msg = $request->input('msg');
        $newMessage->msg_type = 'message';
        $newMessage->msg_time = $timeMessage;
        $newMessage->sender = $request->input('sender');
        $newMessage->status = 'deliver'; //Тут статус мы сразу меняем на deliver
        $newMessage->user_room_id =  $userRoom->id;
        $newMessage->uuid =  $uuid;
        $newMessage->save();

        $response = [
            'msg' => "Done",
            'success'=> true,
            'data' => $newMessage
        ];

        return response()->json($response);

    }

    public function create(Request $request)
    {
        $dateMessage = \Carbon\Carbon::now();
        $timeMessage = \Carbon\Carbon::now()->format('H:i');
        $userhash = $request->input('userhash');
        $socketid = $request->input('socketid');

        $userChats = UserChats::where('user_hash', $userhash)->first();

        if(is_null($userChats))
        {
            return response()->json(['success' => false, 'msg' => 'User hash not found']);
        }

        $userChats->tmp_socketid = $socketid;
        $userChats->save();

        if($userChats->name == null)
        {
            $userProfile = UserProfile::where('id', $userChats->profile_id)->first();
        
            if(is_null($userProfile))
            {
                Log::error("UserProfile is not found 01");
                return;
            }

            //Удаление старых сообщение об регистрации клиента
            $currentUserMessages = UserMessages::where('user_chat_id', $userChats->id)
            ->where('msg_type', 'credential')
            ->get();

            if($currentUserMessages->count() > 0)
            {
                foreach($currentUserMessages as $msg){
                    UserMessages::destroy($msg->id);
                }
            }

            $newMessage = new UserMessages();
            $newMessage->msg = $request->message;
            $newMessage->msg_type = 'credential';
            $newMessage->msg_time = $timeMessage;
            $newMessage->sender = 'client';
            $newMessage->status = 'in_progress';
            $newMessage->user_chat_id = $userChats->id;
            
            $newMessage->save();

            $userChats = UserChats::with('profile', 'messages')
            ->where('user_hash', $userhash)
            ->first();

            $eventData = [
                'user_chats' => $userChats,
            ];
    
            Redis::publish('credentials', json_encode($eventData));

            return response()->json(['success' => false, 'msg' => 'Please fill credentials']);
        }

        $newMessage = new UserMessages();
        $newMessage->msg = $request->message;
        $newMessage->msg_type = 'message';
        $newMessage->msg_time = $timeMessage;
        $newMessage->sender = 'client';
        $newMessage->status = 'in_progress';
        $newMessage->user_chat_id = $userChats->id;

        $userProfile = UserProfile::where('id', $userChats->profile_id)->first();
        
        if(is_null($userProfile))
        {
            Log::error("UserProfile is not found");
            return;
        }

        if($newMessage->save())
        {
            $userChats = UserChats::with('profile', 'messages')
            ->where('user_hash', $userhash)
            ->first();

            $eventData = [
                'user_chats' => $userChats,
            ];
    
            Redis::publish('chat', json_encode($eventData));
        }
        
    }

    //Вот это скорее не нужно будет
    /**
     * @TODO 
     */
    public function createHash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel' => 'required|string',
        ]);
    
        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }
     
        Log::info('[IndexController][createHash]');
        $channel = $request->input('channel');

        Log::info('[IndexController][createHash][hash]: '.$channel );
        $userProfile = UserProfile::where('channel_hash', $channel)->first();

        if(is_null($userProfile))
        {
            Log::info('[IndexController][createHash][channel has not found]: ' . $channel);
            return;
        }


        //Создаем временный hash
        $newTmpUser = new UserChats();
        $newTmpUser->profile_id = $userProfile->id;
        
        if($newTmpUser->save())
        {  
            $concateData = $userProfile->channel_hash.$newTmpUser->id;
            $generateHash = $this->createUserHash($concateData);
            
            $newTmpUser->user_hash = $generateHash;

            $newTmpUser->save();

            Log::info('[IndexController][createHash][generated hash]: '. $generateHash );

            $response = [
                'msg' => "",
                'success'=> true,
                'data' => $generateHash
            ];

            return response()->json($response);
        }
    }

    /**
     * Это нужная функция
     */

    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    private function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
    
    public function createCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hash_channel' => 'required|string',
        ]);
    
        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        
        $hash = $request->input('hash');
        $hash_channel = $request->input('hash_channel');

        $userProfile = UserProfile::where('channel_hash', $hash_channel)->first();

        if(is_null($userProfile))
        {
            Log::info('[IndexController][createHash][channel has not found]: ' . $hash_channel);
            return;
        }

        $userChat = UserChats::where('user_hash', $hash)->first();

        if(is_null($userChat))
        {
            //Если это новый пользователь
            //Создаем новый хещ
            $userChats = new UserChats();
            $userChats->profile_id = $userProfile->id;
            
            if($userChats->save())
            {  
                $concateData = $userProfile->channel_hash.$userChats->id;
                $generateHash = $this->createUserHash($concateData);
                
                $userChats->user_hash = $generateHash;

                $userChats->bg_color = $this->random_color();

                $userChats->save();
            }

            //C начало создаем новую комнату
            $newUserRoom = new UserRooms();
            $newUserRoom->status_message = 'in_progress';
            $newUserRoom->user_chat_id = $userChats->id;
            $newUserRoom->save();

            //Теперь создаем welcome сообщение
            $timeMessage = \Carbon\Carbon::now()->format('H:i');

            $newMessage = new UserMessages();
            $newMessage->msg = $userProfile->welcome_text;
            $newMessage->msg_type = 'message';
            $newMessage->msg_time = $timeMessage;
            $newMessage->sender = 'operator';
            $newMessage->status = 'in_progress';
            $newMessage->user_room_id = $newUserRoom->id;
            $newMessage->save();

            //Теперь создаем Credentials

            $newCredentials = new UserMessages();
            $newCredentials->msg = '';
            $newCredentials->msg_type = 'credential';
            $newCredentials->msg_time = $timeMessage;
            $newCredentials->sender = 'operator';
            $newCredentials->status = 'in_progress';
            $newCredentials->user_room_id = $newUserRoom->id;
            $newCredentials->save();

            //Теперь получаем все сообщения
            $messages = UserMessages::where('user_room_id', $newUserRoom->id)->get();
            
            $response = [
                'type' => 'newhash',
                'msg' => "Created new hash",
                'user_chats' => $userChats,
                'user_rooms' => $newUserRoom,
                'user_profile' => $userProfile,
                'user_messages' => $messages,
                'user' => null, //Потому что это новый хаш
                'success'=> true,
            ];

            return response()->json($response);
        }

        //Если есть хаш то просто вернем историю
        $userRooms = UserRooms::where('user_chat_id', $userChat->id)->first();
        if(is_null($userRooms))
        {
            $response = [
                'type' => 'currenthash',
                'msg' => "",
                'user_chats' => $userChat,
                'user_rooms' => $userRooms,
                'user_profile' => $userProfile,
                'success'=> false,
            ];
    
            return response()->json($response); 
        }

        $userMessages = UserMessages::where('user_room_id', $userRooms->id)->get();
        
        $userData = null;
        if(!is_null($userRooms->user_id))
        {
            $userData = User::where('id', $userRooms->user_id)->first();
        }

        $response = [
            'type' => 'currenthash',
            'msg' => "",
            'user_chats' => $userChat,
            'user_rooms' => $userRooms,
            'user_profile' => $userProfile,
            'user_messages' => $userMessages,
            'user' => $userData,
            'success'=> true,
        ];

        return response()->json($response);
    }

    public function createCredentials(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'userhash' => 'required|string',
        ]);
    
        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        $userhash = $request->input('userhash');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $userChats = UserChats::where('user_hash', $userhash)->first();

        if(is_null($userChats))
        {
            $response = [
                'msg' => "The hash is not found",
                'success'=> false,
            ];

            return response()->json($response);
        }

        
        if(!empty($userChats->name) &&  !empty($userChats->phone) && !empty($userChats->email))
        {
            $userChats->name = $name;
            $userChats->phone = $phone;
            $userChats->email = $email;

            $userChats->save();
            $userRoom = UserRooms::with(['user_chats', 'messages'])
                        ->where('user_chat_id', $userChats->id)->first();
            
            //Меняем статус рума
            $userRoom->status_message = 'accepted';
            $userRoom->save();

            $currentMessages = UserMessages::where('user_room_id', $userRoom->id)
            ->whereIn('msg_type', ['credential','credential_saved'])
            ->first();

            if(!is_null($currentMessages))
            {
                $currentMessages->msg_type = 'credential_saved';
                $currentMessages->status = 'viewed';
                $currentMessages->save();

                $response = [
                    'msg' => "Credentials saved",
                    'success'=> true,
                    'user_room' => $userRoom,
                ];
    
                return response()->json($response);
            }
        }

        $userChats->name = $name;
        $userChats->phone = $phone;
        $userChats->email = $email;

        if($userChats->save())
        {
            //Изменение статус сообщение
            $userRoom = UserRooms::with(['user_chats', 'messages'])
                        ->where('user_chat_id', $userChats->id)->first();
            if(is_null($userRoom))
            {
                Log::error("[createCredentials][room is empty] user chat id: ". $userChats->id);
                return;
            }

            //Меняем статус рума
            $userRoom->status_message = 'pending';
            $userRoom->save();

            $currentMessages = UserMessages::where('user_room_id', $userRoom->id)
                ->whereIn('msg_type', ['credential','credential_saved'])
                ->first();

            if(!is_null($currentMessages))
            {
                $currentMessages->msg_type = 'credential_saved';
                $currentMessages->status = 'viewed';
                $currentMessages->save();

                $response = [
                    'msg' => "Credentials saved",
                    'success'=> true,
                    'user_room' => $userRoom,
                ];
    
                return response()->json($response);
            }
        }
    }

    public function getHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userhash' => 'required|string',
        ]);

        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        $userhash = $request->input('userhash');
        $userChats = UserChats:: with(['messages','profile'])
        ->where('user_hash', $userhash)
        ->first();

        if(is_null($userChats))
        {
            $response = [
                'msg' => "The hash is not found",
                'success'=> false,
            ];

            return response()->json($response);
        }

        
       // $messages = UserMessages::where('user_chat_id', $userChats->id)->orderBy('id', 'asc')->limit(100)->get();

        $response = [
            'msg' => "Message found",
            'success'=> true,
            'data' => $userChats
        ];

        return response()->json($response);
    }

    public function getOperatorProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userhash' => 'required|string',
        ]);

        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        $userhash = $request->input('userhash');
        $userChats = UserChats::where('user_hash', $userhash)->first();

        if(is_null($userChats))
        {
            $response = [
                'msg' => "The hash is not found",
                'success'=> false,
            ];

            return response()->json($response);
        }
        
        $userProfile = UserProfile::where('id', $userChats->profile_id)->first();

        if(is_null($userProfile))
        {
            $response = [
                'msg' => "Operator not found",
                'success'=> false,
            ];

            return response()->json($response);
        }

        $response = [
            'msg' => "Message found",
            'success'=> true,
            'data' => $userProfile
        ];

        return response()->json($response);
    }

    public function messageLookedClient(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'user_room_id' => 'required|string',
    ]);

    if ($validator->fails())
    {
        $response = [
            'msg' => implode(',', $validator->errors()->all()),
            'success'=> false,
        ];

        return response($response, 200);
    }

    $userRoomId = $request->input('user_room_id');
    $userRooms = UserRooms::where('id', $userRoomId)->first();

    //Start update Client Messages
    $userMessages = UserMessages::where('user_room_id', $userRoomId)
    ->whereIn('status', ['deliver'])
    ->where('sender', 'operator')
    ->get();

    if($userMessages->count() > 0)
    {
        foreach ($userMessages as $message)
        {
            $message->status = 'viewed';
            $message->save();
        }

        return response()->json([
            'success' => true,
            'msg' => 'All message clients view',
            'user_rooms' => $userRooms,
            'user_message' => $userMessages
        ], 200);
    }
  }
}
