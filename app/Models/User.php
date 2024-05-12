<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',

        'url_telegram',
        'date_birth',
        'vuz',
        'education_course',
        'interes',


         'action_sector',
         'business_sector',
        'user_id_created',
        'password',
        'user_role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $columns = 
    [
        'id', 
        'name', 
        'email',
        'email_verified_at',
        'password',
        // 'phone',
        'avatar',
        
        'url_telegram',
        'date_birth',
        'vuz',
        'education_course',
        'interes',

        'user_role_id',
        'user_id_created',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function scopeExclude($query, $value = []) 
    {
        return $query->select(array_diff($this->columns, (array) $value));
    }

    public function cv()
    {
        return $this->hasMany(CV::class, "user_id", "id");
    }
    

    public function roles()
    {
        return $this->hasOne(UserRole::class, "id", "user_role_id");
    }
}
