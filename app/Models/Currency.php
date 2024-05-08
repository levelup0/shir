<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class Currency extends Model {
    use HasFactory;

    protected $table = 'currency';

    protected $fillable = [
        'title',
        'symbol_left',
        'symbol_right',
        'code',
        'class',
        'decimal_place',
        'decimal_point',
        'thousand_point',
        'status',
    ];

   // public static $default = ['USD','RUB'];

    /*public function scopeGetDefault($query){
        return $query->where('code',Config::get('app.currency'))->first();
    }

    public function scopeGetActive($query){
        return $query->where('status',1)->get();
    }*/
}