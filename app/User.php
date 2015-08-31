<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Traits\Messagable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use EntrustUserTrait;
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
	protected $fillable = ['username', 'first_name', 'last_name', 'email', 'photo', 'phone', 'rg', 'cpf', 'birthday', 'password', 'status', 'confirmation_code'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /**
     * Get the getNotifications record associated with the project.
     */
    public function getNotifications()
    {
        return $this->hasMany('App\UserNotification');
    }

    /**
     * Get the user settings...
     */
	public function settings()
    {
        return $this->hasOne('App\UserSetting');
    }

    /**
     * Get the all users with the string...
     */
	public function scopefindUserAC($query, $string)
    {
        return $query->whereRaw('CONCAT_WS(" ", username, first_name, last_name, email) LIKE "%' . $string . '%"');
    }

    /**
     * Get the user with the confirmation code...
     */
	public function scopefindConfirmationCode($query, $confirmation_code)
    {
        return $query->where('confirmation_code', $confirmation_code)->where('status', '<>', 'A');
    }

}
