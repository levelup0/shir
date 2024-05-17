<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class VozCategoryRelation extends Model {
    use HasFactory;

    protected $table = 'voz_category_relation';

    protected $fillable = [
        'voz_id',
        'category_voz_id',
    ];

    public function category()
    {
        return $this->hasOne(CategoryVoz::class, "id", "category_voz_id");
    }
}