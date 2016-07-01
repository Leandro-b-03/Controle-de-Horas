<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enumeration extends Model
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
    protected $table = 'enumerations';
}
