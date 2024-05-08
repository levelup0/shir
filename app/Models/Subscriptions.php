<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    protected $table = "subscriptions";
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        
        'image',
        'queue_show',
        'status',
    ];

    public function options()
    {
        return $this->hasMany(SubscriptionOptions::class, "subscription_id", "id")->orderBy('queue_show', "asc");
    }

    public function subscription_price()
    {
        return $this->hasMany(SubscriptionPriceCurrency::class, "subscription_id", "id");
    }
}
