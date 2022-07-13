<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Define the relationship between two eloquent models: User & Entry
     */
    public function entry()
    {
        return $this->hasMany('App\Entry');
    }

    /**
     * Define the relationship between two eloquent models: User & Tag
     */
    public function tag()
    {
        return $this->hasMany('App\Tag');
    }

    /**
     * Define the relationship between two eloquent models: User & Mention
     */
    public function mention()
    {
        return $this->hasMany('App\Mention');
    }
}