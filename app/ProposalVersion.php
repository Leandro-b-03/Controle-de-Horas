<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalVersion extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'proposals_versions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['proposal_id', 'proposal', 'version', 'send', 'date_send', 'date_return', 'authorise', 'data_authorise', 'signing_board', 'date_signing_board', 'active'];

    /**
     * Get the user record associated with the project.
     */
    public function user()
    {
        return $this->belongsTo('App\Proposal', 'proposal_id');
    }
}
