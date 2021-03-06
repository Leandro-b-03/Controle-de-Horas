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

    /**
     * Get the user record associated with the project.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the user record associated with the project.
     */
    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id');
    }

    /**
     * Get the all users in team with the string...
     */
    public function scopegetUsersTeam($query, $team_id)
    {
        return $query->where('team_id', $team_id);
    }

    /**
     * Get the all users in team with the string...
     */
    public function scopegetTeams($query, $user_id)
    {
        return $query->select('team_id')->where('user_id', $user_id);
    }

}
