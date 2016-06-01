<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimesheetTask extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'timesheets_tasks';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['timesheet_id', 'project_id', 'work_package_id', 'hours', 'start', 'end'];

    /**
     * Get the getNotifications record associated with the project.
     */
    public function getTask()
    {
        return $this->hasOne('App\Task', 'id', 'work_package_id');
    }

    /**
     * Get the getNotifications record associated with the project.
     */
    public function getProject()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    /**
     * Get the tasks record associated with the project.
     */
    public function scopegetTasks($query, $teams_id)
    {
        return $query->select('project_time_task_id')->whereIn('team_id', $teams_id);
    }

    /**
     * Get the projects.
     */
    public function scopegetProjects($query, $teams_id)
    {
        return $query->select('project_time_task_id')->whereIn('team_id', $teams_id);
    }
}
