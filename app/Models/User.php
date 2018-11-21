<?php

namespace App\Models;
use Tanmo\Search\Traits\Search;
use App\Models\Subscription;
use App\Models\Category;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable implements JWTSubject
{
    //
    use Search,Notifiable;

    public function authWechat()
    {
        return $this->hasOne(UserAuthWechat::class);
    }

    public function subscriptions(){

        return $this->belongsToMany(Category::class, 'subscriptions', 'user_id', 'category_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }


}
