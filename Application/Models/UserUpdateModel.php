<?php
namespace Application\Models;

use stdClass;
use Application\Security\Validator;
use Application\Models\AbstractModel;

class UserUpdateModel extends AbstractModel
{
    public $id;
    public $role;
    public $email;
    public $oldPassword;
    public $password;
    public $confirm;

    public function validate()
    {
        $result = new stdClass();
        $result->isValid = false;
        $result->errors = [];

        if (!Validator::checkEmail($this->email)) {
            $result->errors['email'] = 'Invalid e-mail address.';
        }
    
        if (!Validator::checkPassword($this->oldPassword)) {
            $result->errors['oldPassword'] = 'Invalid password.';
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