<?php
namespace App\Traits;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Log;

trait UserRoleTrait{
  
  public function isAdmin(User $user):bool
  {
    $adminRole = UserRole::where('name', 'superadmin')->first();

    if(is_null($adminRole))
    {
      Log::error("[UserRoleTrait][isAdmin] admin role not found");
      return false;
    }

    if($user->user_role_id != $adminRole->id)
    {
      return false;
    }
    
    return true;
  }
}