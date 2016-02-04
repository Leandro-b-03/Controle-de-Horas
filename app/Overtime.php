<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'overtime';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'hours'];
}
