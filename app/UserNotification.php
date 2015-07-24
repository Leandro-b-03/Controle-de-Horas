<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_notifications';


	public function scopeunseen($query)
    {
        return $query->where('see', false);
    }
}
