<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Config;

class CategoryVoz extends Model {
    use HasFactory;
    
    protected $table = 'category_voz';
 
    protected $fillable = [
        'name',
    ];
}