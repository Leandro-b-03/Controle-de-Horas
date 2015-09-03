<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_settings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'skin', 'boxed', 'sidebar_toggle', 'right_sidebar_slide', 'right_sidebar_white'];

    /**
     * Get the user record associated with the project.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
