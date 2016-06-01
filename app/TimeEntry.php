<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
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
    protected $table = 'time_entries';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'user_id', 'work_package_id', 'hours', 'activity_id', 'spent_on', 'tyear', 'tmonth', 'tweek', 'created_on', 'updated_on'];
}
