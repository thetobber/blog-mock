<?php
namespace Application\Models;

use Application\Models\AbstractModel;

class UserViewModel extends AbstractModel
{
    public $id;
    public $role;
    public $username;
    public $email;
    public $created;
}
