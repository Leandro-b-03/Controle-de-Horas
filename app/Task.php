<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects_times_tasks';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'project_id', 'project_time_id'];

    /**
     * Get the user record associated with the project_time.
     */
    public function projects_times()
    {
        return $this->belongsTo('App\ProjectTime', 'project_time_id');
    }

    /**
     * Get the user record associated with the project.
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
