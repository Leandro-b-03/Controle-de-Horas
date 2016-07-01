<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
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
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['user_id', 'client_id', 'proposal_id', 'name', 'name_complement', 'description', 'long_description', 'budget', 'schedule_time', 'time_spend'];

    /**
     * Get the user record associated with the project.
     */
    // public function user()
    // {
    //     return $this->belongsTo('App\User', 'user_id');
    // }

    /**
     * Get the client record associated with the project.
     */
    // public function client()
    // {
    //     return $this->belongsTo('App\Client', 'client_id');
    // }

    /**
     * Get the proposal record associated with the project.
     */
    // public function proposal()
    // {
    //     return $this->belongsTo('App\Proposal', 'proposal_id');
    // }

    /**
     * Get the proposal record associated with the project.
     */
    public function custom_field()
    {
        return $this->hasMany('App\CustomField', 'customized_id');
    }

    /**
     * Scope a query to get all the activities type.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivities($query)
    {
        return $query->join('projects_types', 'projects_types.project_id', '=', 'projects.id')
                     ->join('types', 'types.id', '=', 'projects_types.type_id');
    }
}
