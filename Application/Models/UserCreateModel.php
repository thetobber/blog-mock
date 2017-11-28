<?php
namespace Application\Models;

use stdClass;
use Application\Security\Validator;
use Application\Models\AbstractModel;

class UserCreateModel extends AbstractModel
{
    public $username;
    public $email;
    public $password;
    public $confirm;

    public function validate()
    {
        $result = new stdClass();
        $result->isValid = false;
        $result->errors = [];

        if (!Validator::checkUsername($this->username)) {
            $result->errors['username'] = 'Invalid username.';
        }
    
        if (!Validator::checkEmail($this->email)) {
            $result->errors['email'] = 'Invalid e-mail address.';
        }
    
        if (!Validator::checkPassword($this->password)) {
            $result->errors['password'] = 'Invalid password.';
        }
    
        if (!Validator::checkEquality($this->password, $this->confirm)) {
            $result->errors['confirm'] = 'Password and confirmation must be the same.';
        }

        $result->isValid = empty($result->errors);

        return $result;
    }
}