<?php

namespace Dsdevbe\LdapConnector\Model;

use App\User as DBUser;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $_authIdentifier;

    /**
     * @var string
     */
    // protected $_authPassword;

    /**
     * @var string
     */
    protected $_rememberToken;

    /**
     * @var array
     */
    protected $_groups;

    /**
     * @var array
     */
    protected $_user;

    /**
     * @var integer
     */
    public $primaryKey = 'id';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var array
     */
    protected $_eloquent;

    public function __construct(array $attributes)
    {
        $user = DBUser::where('username', $attributes['username'])->get()->first();
        $this->_authIdentifier = $attributes['username'];
        // $this->_authPassword = (isset($attributes['password'])) ? $attributes['password'] : null;
        if ($user) {
            $this->_eloquent = $user;
            $this->attributes = $user->attributes;
            $this->original = $user->original;
            $this->relations = $user->relations;
            $this->hidden = $user->hidden;
            $this->visible = $user->visible;
            $this->appends = $user->appends;
            $this->id = $user->id;
        }
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->_authIdentifier;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // return $this->_authPassword;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->_rememberToken;
    }

    /**
     * Get the user on timesheet db.
     *
     * @return eloquent
     */
    public function getEloquent()
    {
        return $this->_eloquent;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->_rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        // In LDAP no colomn to save
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->_groups;
    }

    /**
     * @param array $groups
     */
    public function setGroups(array $groups)
    {
        $this->_groups = $groups;
    }

    /**
     * @return bool
     */
    public function inGroup($groupName)
    {
        return in_array($groupName, $this->_groups);
    }

    /**
     * @param array $user
     */
    public function setUserInfo(array $user)
    {
        $this->_user = $user;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_user['username'];
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->_user['firstname'];
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->_user['lastname'];
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_user['email'];
    }
}
