
<?php
namespace Application\Models;

use Application\Models\AbstractModel;

class UserModel extends AbstractModel
{
    public $id;
    public $role;
    public $username;
    public $email;
    public $password;
    public $created;
}
