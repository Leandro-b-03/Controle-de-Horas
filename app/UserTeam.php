<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_teams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'team_id'];
}
