<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects_times';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'cycle', 'budget', 'schedule_time'];

    /**
     * Get the user record associated with the project.
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

}
