<?php


namespace App\Actions\Common;

 
use App\Models\Countries;
 
use App\Models\SubscriptionMonth;
use App\Models\SubscriptionOptions;
use App\Models\SubscriptionPriceCurrency;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\Voz;
 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

/**
 * Mass action by action type on elements;
 * Class MassAction
 * @package App\Actions\Common
 */
class MassAction
{
    /**
     * @param $ids
     * @param $actionType
     * @param $requestModel
     */
    public static function execute($ids, $actionType, $requestModel)
    {
        /**
         * Get laravel model by request model name
         */
        switch ($requestModel) {
            case 'users':
                $model = app(User::class);
            break; 
            case 'subscriptions':
                $model = app(Subscriptions::class);
            break; 
            case 'subscription-options':
                $model = app(SubscriptionOptions::class);
            break; 
            case 'countries-admin':
                $model = app(Countries::class);
            break; 
         
            case 'subscription-price-admin':
                $model = app(SubscriptionPriceCurrency::class);
            break; 
            case 'subscription-month':
                $model = app(SubscriptionMonth::class);
            break; 

            case 'voz':
                $model = app(Voz::class);
            break; 
        }

        /**
         * Change values by action type in selected model
         */
        switch ($actionType) {
            case 'act_status_1':
                $model::whereIn('id', $ids)->update(['status' => '1']);
                break;
            case 'act_status_0':
                $model::whereIn('id', $ids)->update(['status' => '0']);
                break;
            case 'act_delete':
                switch($requestModel){
                    case  'users':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/users/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;

                    case  'subscriptions':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/subscriptions/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;

                    case  'subscription-options':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/subscription-options/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;

                    case  'tmc':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;
                    case  'tmc-types':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc-types/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;
                    case  'tmc-names':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc-names/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;

                    case  'tmc-brand':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc-brand/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;

                    
                    case  'tmc-model':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc-model/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;
                    case  'tmc-location':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc-location/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;
                    case  'tmc-object':
                        try{
                            $datas = $model::whereIn('id', $ids)->get();
                            foreach($datas as $data)
                            {
                                File::delete(public_path('images/tmc-object/').$data->image);
                            }
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                        }
                    break;
                }
                $model::whereIn('id', $ids)->delete();
                break;
        }
    }
}