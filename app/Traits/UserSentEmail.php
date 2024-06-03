<?php
namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendMail;
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

        // try{
          $dataEmail = [];
          $dataEmail[] = 'Фио: '. $users->name;
          // $dataEmail[] = 'Телефон: '. $data["phone_number"];
          $dataEmail[] = 'Email: '. $users->email;
          // $dataEmail[] = 'Статус: '. $data["status"];
          $dataEmail[] = 'Описание: '. $data["text"];
          $dataEmail[] = 'Дата и время: '. \Carbon\Carbon::now()->addHours(3);
  
          $arrToString = implode(",", $dataEmail);
  
          $testMailData = [
            'title' => 'Новая заявка',
            'body' => $arrToString
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

    $mailTo = User::where('id', $voz->user_id)->first();

    if(is_null($mailTo))
    {
      Log::error("The mailTo is not found");
      return;
    }

        // try{
          $dataEmail = [];
          $dataEmail[] = 'ФИО: '. $mailTo->name;
          // $dataEmail[] = 'Телефон: '. $data["phone_number"];
          $dataEmail[] = 'Эл.Почта: '. $mailTo->email;
          // $dataEmail[] = 'Статус: '. $data["status"];
          $dataEmail[] = 'Описание: '. 'Ваша заявка успешно принято!';
          $dataEmail[] = 'Дата и время: '. \Carbon\Carbon::now()->addHours(3);
  
          $arrToString = implode(",", $dataEmail);
  
          $testMailData = [
            'title' => 'Новая заявка',
            'body' => $arrToString
        ];

          Mail::to($users->email)->send(new SendMail($testMailData));
        // }catch(\Exception $e){

        // }
  }
}
 