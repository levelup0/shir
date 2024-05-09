<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class Voz extends Model {
    use HasFactory;

    protected $table = 'voz';

    protected $fillable = [
        'name',
        'sector',
        'description',
        'publish_date',
        'end_date',
        'user_id',
        'status',
        'category_voz_id',
    ];

    public function category()
    {
        return $this->hasOne(CategoryVoz::class, "id", "category_voz_id");
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

  

}