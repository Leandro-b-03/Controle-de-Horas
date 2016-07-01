<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskPermissionJournal extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks_permissions_journal';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['work_package_id', 'enumeration_id'];
}
