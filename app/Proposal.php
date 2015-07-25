<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'proposals';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'client_id', 'name', 'proposal'];
}
