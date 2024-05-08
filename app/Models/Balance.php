<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class Balance extends Model {
    use HasFactory;
    
    protected $table = 'balance';

   // public static $default = ['USD','RUB'];

    /*public function scopeGetDefault($query){
        return $query->where('code',Config::get('app.currency'))->first();
    }

    public function scopeGetActive($query){
        return $query->where('status',1)->get();
    }*/
}