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
	protected $fillable = ['name', 'responsible', 'email', 'phone'];
}
