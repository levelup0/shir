<?php

namespace App\Traits;

use App\Models\UserChats;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Log;

trait GenerateHash{
  
  public function createUserHash($input)
  {
    $hash_base64 = base64_encode( hash( 'sha256', $input, true ) );
    // Replace non-urlsafe chars to make the string urlsafe.
    $hash_urlsafe = strtr( $hash_base64, '+/', '-_' );
    // Trim base64 padding characters from the end.
    $hash_urlsafe = rtrim( $hash_urlsafe, '=' );
    // Shorten the string before returning.
    return substr( $hash_urlsafe, 0, 50 );
  }

  public function createHash($channel, $userProfile)
  {
      Log::info('[GenerateHash][IndexController][createHash]');
      Log::info('[GenerateHash][IndexController][createHash][hash]: '.$channel );
      
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

          return $generateHash;
      }
  }
}
