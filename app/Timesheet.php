<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'timesheets';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'workday', 'hours', 'start', 'end', 'lunch_hours', 'lunch_start', 'lunch_end', 'overtime_hours', 'overtime_start', 'overtime_end', 'status'];

    /**
     * Get the all workdays with the date...
     */
	public function scopefindWorkday($query, $date)
    {
        return $query->where('workday', $date);
    }
}
