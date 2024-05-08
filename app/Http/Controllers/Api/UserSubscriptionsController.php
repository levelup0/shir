<?php

namespace App\Http\Controllers\Api;

use App\Actions\Common\DateFilter;
use App\Actions\Common\SortData;
use App\Actions\DeleteRes;
use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSubscriptions\UserSubscriptionsStoreReq;
use App\Http\Requests\UserSubscriptions\UserSubscriptionsUpdateReq;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\SubscriptionMonth;
use App\Models\Subscriptions;
use App\Models\UserSubscriptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserSubscriptionsController extends Controller
{
    public function getSubscriptions()
    {
        $user = Auth::user();

        $userSubscriptions = UserSubscriptions::with(['currency','subscription'])->where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'msg' => '',
            'data' => $userSubscriptions
        ], 200);
    }

    public function buy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'count_operator' => 'required|string',
            'subscription_month_id' => 'required|string',
            'subscription_id' => 'required|string',
            'currency_id' => 'required|string',
        ]);
    
        if ($validator->fails())
        {
            $response = [
                'msg' => implode(',', $validator->errors()->all()),
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        $count_operator = $request->input('count_operator');
        $subscription_month_id = $request->input('subscription_month_id');
        $subscription_id = $request->input('subscription_id');
        $currency_id = $request->input('currency_id');

        // Проверка количества оператора
        if($count_operator < 0)
        {
            $response = [
                'msg' => "Количество операторов не должно быть меньше 0",
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        // Проверка на существования месяца
        $subscriptionMonth = SubscriptionMonth::where('id', $subscription_month_id)->first();

        if(is_null($subscriptionMonth))
        {
            $response = [
                'msg' => "Месяцы не найдены",
                'success'=> false,
            ];
    
            return response($response, 200);
        }

        // Проверка на существования абонеента
        $subscriptions = Subscriptions::with(['subscription_price', 'subscription_price.currency'])
            ->where('id', $subscription_id)->first();

        if(is_null($subscriptions))
        {
            $response = [
                'msg' => "Абонемент не найден",
                'success'=> false,
            ];
    
            return response($response, 200);
        }

         // Проверка на существования абонеента
         $currencies = Currency::where('id', $currency_id)->first();

         if(is_null($currencies))
         {
             $response = [
                 'msg' => "Валюта не найдена",
                 'success'=> false,
             ];
     
             return response($response, 200);
         }

         //Теперь подсчитаем сумму абонемента

         $_countOperator = (int)$count_operator + 1;
         $summ_subscription = 0;

         $tmps = $subscriptions->subscription_price;
         $real_currency_id = null;
         
         if($tmps->count() > 0)
         {
            foreach($tmps as $tmp)
            {
                if($tmp->currency_id == $currencies->id)
                {
                    $summ_subscription = $tmp->summ;
                    $real_currency_id  = $tmp->currency_id;
                }
            }
         }

         //Умножяем с количесов операторово
         if($summ_subscription <= 0)
         {
            $response = [
                'msg' => "Неизвестная ошибка 0010",
                'success'=> false,
            ];
    
            return response($response, 200);
         }

         $countOperatorWithSumm = $summ_subscription * $_countOperator;

         //Далле теперь умножаем с количество месяца
         $countMonth = $subscriptionMonth->count_month;

         if((int)$countMonth < 0)
         {
            $response = [
                'msg' => "Неизвестная ошибка 0011",
                'success'=> false,
            ];
    
            return response($response, 200);
         }

         //Это результат без скидки
         $withCountMonth = (float)$countOperatorWithSumm * (float)$countMonth;

         //Теперь подсчитаем скидку
         if($withCountMonth <= 0)
         {
            $response = [
                'msg' => "Неизвестная ошибка 0012",
                'success'=> false,
            ];
    
            return response($response, 200);
         }

         $total = 0;

         if($subscriptionMonth->discount != 0)
         {
            $withDiscount = ($withCountMonth * (float)$subscriptionMonth->discount) / 100;
            $total = $withCountMonth - $withDiscount;
         }else{
            $total = $withCountMonth;
         }

         //Теперь проверяем баланса
         $user = Auth::user();

         $balances = Balance::where('user_id', $user->id)->where('currency_id', $real_currency_id)->first();

         if(is_null($balances))
         {
            $response = [
                'msg' => "Баланс пользователя не найдена",
                'success'=> false,
            ];
    
            return response($response, 200);
         }

         //Теперь проверяем достаточно ли баланса для снятия с кошелька
         if((float)$balances->summ < $total)
         {
            $response = [
                'msg' => "На балансе недостаточно средств чтобы приобрести абонемент",
                'success'=> false,
            ];
    
            return response($response, 200);
         }

         $balances->summ =  $balances->summ - $total;
         $balances->save();

         //Теперь добавляем новый абонемент пользователю
         $newUserSubsription = new UserSubscriptions();
         $newUserSubsription->user_id = $user->id;
         $newUserSubsription->subscription_id = $subscriptions->id;
         $newUserSubsription->start_date = \Carbon\Carbon::now();
         $newUserSubsription->date_date = \Carbon\Carbon::now()->addMonths((int)$countMonth);
         $newUserSubsription->summ = $total;
         $newUserSubsription->currency_id = $real_currency_id;
         $newUserSubsription->count_operator = $count_operator;
         $newUserSubsription->save();

         $response = [
            'msg' => "Поздравляем! Вы успешно приобрели абонемент",
            'success'=> true,
         ];

        return response($response, 200);
    }
}