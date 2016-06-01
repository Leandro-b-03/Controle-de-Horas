<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'import';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['file', 'user_id', 'status', 'error'];

    /**
     * Get the user record associated with the import.
     */
    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}