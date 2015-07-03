<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
	public function scopefindName($query, $name)
    {
        return $query->where('name', $name);
    }
}