<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPriceCurrency extends Model
{
    protected $table = "subscription_price_currency";
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'subscription_id',
        'summ',
    ];

    public function subcription()
    {
        return $this->hasOne(Subscriptions::class, "id", "subscription_id");
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, "id", "currency_id");
    }
}
