<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class CategoryVozUser extends Model {
    use HasFactory;

    protected $table = 'category_voz_user';

    protected $fillable = [
        'user_id',
        'category_voz_id',
    ];

    public function category()
    {
        return $this->hasOne(CategoryVoz::class, "id", "category_voz_id");
    }



}