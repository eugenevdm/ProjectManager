<?php

namespace App;

use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
    use EntrustUserTrait;

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
	protected $fillable = ['name', 'firstname', 'email', 'password', 'username', 'avatar', 'provider_id', 'provider', 'phone' , 'signature'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function tasklists()
    {
        return $this->belongsToMany('App\Tasklist')->orderBy('updated_at', 'desc');
    }

    public function name() {
        if ($this->firstname) {
            return $this->firstname;
        } else {
            return $this->name;
        }
    }

    /**
     * TODO Tasks must be filtered by assigned to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks2() {
        return $this->id->belongsToMany('App\Task');
    }

    public function tasks() {
        return $this->belongsToMany('App\Task');
    }

//find($user_id)->

    public function projects()
    {
        return $this->belongsToMany('App\Project')->orderBy('updated_at', 'desc');
    }

}
