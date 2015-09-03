<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocalization extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_localization';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'latitude', 'longitude'];

    /**
     * Get the user record associated with the project.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
