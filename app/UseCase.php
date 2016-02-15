<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UseCase extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'use_cases';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['timesheet_task_id', 'ok', 'nok', 'impacted', 'cancelled'];
}
