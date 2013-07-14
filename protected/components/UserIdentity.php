<?php

/**
 * UserIdentity represents the data needed to identity a user.
 */
class UserIdentity extends CUserIdentity
{
    private $id;
    private $user;

    public function getId()
    {
        return $this->id;
    }


    /**
     * Authenticates a user.
     * @var $by_pin boolean Validates PIN-code instead of password
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = Admins::model()->find('LOWER(username) = :username', array(':username' => strtolower($this->username)));
        $this->user = $user;

        // User not found
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        }

        // Validate password
        if (sha1($this->password) !== $user->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }

        // Successful authentication
        if ($this->errorCode == self::ERROR_UNKNOWN_IDENTITY) {
            $this->id = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }
}