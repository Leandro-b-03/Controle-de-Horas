<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTeam extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks_teams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['team_id', 'project_time_task_id'];

    /**
     * Get the user record associated with the project.
     */
    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id');
    }

    /**
     * Get the user record associated with the project_time.
     */
    public function projects_times_tasks()
    {
        return $this->belongsTo('App\ProjectTime', 'project_time_task_id');
    }

    /**
     * Get the user record associated with the project.
     */
    public function scopegetTasksTeam($query, $teams_id)
    {
        return $query->select('project_time_task_id')->whereIn('team_id', $teams_id);
    }
}
