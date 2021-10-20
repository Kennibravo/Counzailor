<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Counsellee extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Search for Counsellee's username
     * @param string $name
     * @return mixed
     */
    public static function searchCounselleeUsername(string $name)
    {
        return self::whereOneLike('username', $name);
    }

    /**
     * Search for Multiple fields from the Counsellee's table
     * @param array $search
     * @return mixed
     */
    public static function searchCounselleeFields(array $search)
    {
        $attributes = ['username', 'firstname', 'lastname', 'email'];
        return self::whereMultiLike($attributes, $search);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
