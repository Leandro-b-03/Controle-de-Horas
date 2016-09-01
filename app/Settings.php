<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'description', 'api_key', 'locktime', 'idle_time', 'default_theme', 'maintenance', 'maintenance_message', 'from_address', 'from_name', 'page_size'];

}
