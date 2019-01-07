<?php

namespace Platform\Model;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use QCod\ImageUp\HasImageUploads;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Platform extends User implements JWTSubject
{
    use Notifiable, HasRoles, HasImageUploads;

    /**
     * @var string
     */
    protected $table = 'admin';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $hidden = ['password', 'accessToken'];

    /**
     * @var string
     */
    protected $guard_name = 'admin';

    /**
     * @var array
     */
    protected $with = ['roles'];

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

    /**
     * @var array
     */
    protected static $imageFields = [
        'avatar' => [
            'width' => 200,
            'height' => 200,
            'path' => 'avatar',
            'rules' => 'image|mimes:jpeg,jpg,png|max:2000',
        ],
    ];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
