<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'responsible', 'email', 'phone'];

    /**
     * Get the client group record associated with the client.
     */
    public function type()
    {
        return $this->hasMany('App\ClientGroup');
    }
}
