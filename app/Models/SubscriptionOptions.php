<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionOptions extends Model
{
    protected $table = "subscription_options";
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'subscription_id',
        'image',
        'queue_show',
        'status',
    ];

    public function subcription()
    {
        return $this->hasOne(Subscriptions::class, "id", "subscription_id");
    }
}
