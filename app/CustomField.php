<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
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
	protected $table = 'custom_values';

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
    protected $fillable = ['customized_type', 'customized_id', 'custom_field_id', 'value'];
}
