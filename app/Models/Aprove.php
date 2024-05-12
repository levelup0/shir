<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class Aprove extends Model {
    use HasFactory;

    protected $table = 'aprove';

    protected $fillable = [
        'voz_id',
        'user_id',
        'status',
    ];

    public function voz()
    {
        return $this->hasOne(Voz::class, "id", "voz_id");
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

}