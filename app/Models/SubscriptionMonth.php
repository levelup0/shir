<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionMonth extends Model
{
    protected $table = "subscription_month";
    use HasFactory;

    protected $fillable = [
        'name',
        'discount',
        'count_month',
    ];

    // public function subcription()
    // {
    //     return $this->hasOne(Subscriptions::class, "id", "subscription_id");
    // }

    // public function currency()
    // {
    //     return $this->hasOne(Currency::class, "id", "currency_id");
    // }
}
