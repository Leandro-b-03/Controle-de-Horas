<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'openproject';

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'work_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_id', 'project_id', 'subject', 'description', 'status_id', 'assigned_to_id', 'parent_id', 'root_id', 'lft', 'rgt', 'position'];
}