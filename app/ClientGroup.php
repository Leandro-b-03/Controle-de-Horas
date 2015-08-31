<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientGroup extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients_groups';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'client_id', 'description'];

    /**
     * Get the client record associated with the project.
     */
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
