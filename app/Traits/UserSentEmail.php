<?php
namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendMail;
use App\Mail\SendMailResponse;
use App\Models\User;
use App\Models\Voz;

trait UserSentEmail{

  public function sendEmail($data){
    $users = User::where('id', $data['user_id'])->first();
    $voz = Voz::where('id', $data['voz_id'])->first();

    if(is_null($users))
    {
      Log::error("The user is not found".  $data['user_id']);
      return;
    }

    if(is_null($voz))
    {
      Log::error("The voz is not found".  $data['voz_id']);
      return;
    }

    $mailTo = User::where('id', $voz->user_id)->first();

    if(is_null($mailTo))
    {
      Log::error("The mailTo is not found");
      return;
    }

    $text = "На ваш Вызов, размещенный на платформе Шторм-трек, откликнулся студент https://storm-track.ru/recipient/".$mailTo->id."' ".$mailTo->name."";
    $text2 ="Вы можете принять его заявку на реализацию по ссылке: https://storm-track.ru/my-aprove-pol?voz_id=".$voz->id."";
    $text3 = $data["text"];

        // try{
          $dataEmail = [];
          // $dataEmail[] = 'ФИО: '. $users->name;
          // $dataEmail[] = 'Телефон: '. $data["phone_number"];
          // $dataEmail[] = 'Email: '. $users->email;
          // $dataEmail[] = 'Статус: '. $data["status"];
          // $dataEmail[] = 'Описание: '. $data["text"];
          // $dataEmail[] = 'Дата и время: '. \Carbon\Carbon::now()->addHours(3);
  
          // $arrToString = implode(",", $dataEmail);
  
          $testMailData = [
            'title' => 'Новая заявка на реализацию Вызова!',
            // 'body' => $arrToString
            'text_1' => $text,
            'text_2' => $text2,
            'text_3' => $text3,
          ];

          Mail::to($mailTo->email)->send(new SendMail($testMailData));
        // }catch(\Exception $e){

        // }
  }

  public function sendEmail2($data){
    $users = User::where('id', $data->user_id)->first();
    $voz = Voz::where('id', $data->voz_id)->first();

    if(is_null($users))
    {
      Log::error("The user is not found");
      return;
    }

    if(is_null($voz))
    {
      Log::error("The voz is not found");
      return;
    }

    $mailTo = User::where('id', $voz->user_id)->first(); // Данные о вызоводателя

    if(is_null($mailTo))
    {
      Log::error("The mailTo is not found");
      return;
    }

    $text = "";
    $text2= "Вызоводатель ".$mailTo->name." принял вашу заявку на реализацию вызова ".$voz->name.". В письме Вы можете найти контакты Вызоводателя и продолжить взаимодействие с ним в телеграмм!";
    $text3 = $mailTo->url_telegram;
    $text4 = $mailTo->email;

        // try{
          $dataEmail = [];
          $dataEmail[] = 'ФИО: '. $mailTo->name;
          $dataEmail[] = 'Компания: '. $mailTo->company;
          // $dataEmail[] = 'Телефон: '. $data["phone_number"];
          // $dataEmail[] = 'Эл.Почта: '. $mailTo->email;
          $dataEmail[] = 'Описание деятельности: '. $mailTo->action_sector;
          
          // $dataEmail[] = 'Статус: '. $data["status"];
          // $dataEmail[] = 'Описание: '. 'Ваша заявка успешно принято!';
          // $dataEmail[] = 'Дата и время: '. \Carbon\Carbon::now()->addHours(3);
  
          $text = implode(",", $dataEmail);
  
          $testMailData = [
            'title' => 'Ваша заявка на Вызов принята!',
            // 'body' => $arrToString
            'text_1' => $text,
            'text_2' => $text2,
            'text_3' => $text3,
            'text_4' => $text4,
        ];

          Mail::to($users->email)->send(new SendMailResponse($testMailData));
        // }catch(\Exception $e){

        // }
  }
}
 