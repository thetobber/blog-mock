<?php
namespace Application\Security;

use PDO;
use Application\Database;

class Authenticator
{
    public static function signIn($username, $password)
    {
        try {
            $statement = Database::getInstance()->prepare('CALL readUserByName(?)');
            $statement->bindValue(1, $username, PDO::PARAM_STR);

            if ($statement->execute()) {
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if ($user !== false) {
                    if (self::validatePassword($password, $user['password'])) {
                        unset($_SESSION['user']);

                        $_SESSION['user'] = [
                            'id' => $user['id'],
                            'role' => $user['role'],
                            'username' => $user['username'],
                            'email' => $user['email'],
                            'created' => $user['created'],
                        ];
                        return true;
                    }
                }
            }
    
            $statement->closeCursor();
        }
        catch (PDOException $exception) {
            return false;
        }
    
        return false;
    }

    public static function signOut()
    {
        unset($_SESSION['user']);
    }

    public static function isVerified()
    {
        return isset($_SESSION['user']['id']);
    }

    public static function isSelf($id)
    {
        if (self::isVerified()) {
            return $_SESSION['user']['id'] === $id;
        }
        
        return false;
    }

    public static function hasRole()
    {

    }

    public static function validatePassword($password, $hash)
    {
        return \password_verify($password, $hash);
    }
}