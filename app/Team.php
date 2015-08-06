<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'teams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'user_id', 'color'];

    /**
     * Get the user record associated with the project.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the all teams with the string...
     */
    public function scopefindTeam($query, $string)
    {
        return $query->where('name', 'like', '%' . $string . '%');
    }

    /**
     * Get the all teams with the array...
     */
    public function scopefindTeamsJson($query, $array)
    {
        return $query->whereIn('id', $array);
    }
}
