<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'holidays';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'day', 'month', 'type'];

    /**
     * Compare dates to see if is holidays
     */
	public function scopeisHolyday($query, $day, $month)
    {
        return $query->where('day', $day)->where('month', $month);
    }
}