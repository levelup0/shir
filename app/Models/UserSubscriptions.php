<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{
    protected $table = "user_subscriptions";
    use HasFactory;


    public function currency()
    {
        return $this->hasOne(Currency::class, "id", "currency_id");
    }

    public function subscription()
    {
        return $this->hasOne(Subscriptions::class, "id", "subscription_id");
    }

}
