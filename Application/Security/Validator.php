<?php
namespace Application\Security;

class Validator
{
    public static function checkRole($string)
    {
        if (\preg_match('/^[1-3]$/', $string) === 1) {
            return true;
        }
        
        return false;
    }

    public static function checkEmail($string)
    {
        if (\filter_var($string, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        }

        return false;
    }

    public static function checkUsername($string)
    {
        if (\preg_match('/^[!-~]{1,191}$/', $string) === 1) {
            return true;
        }
        
        return false;
    }

    public static function checkPassword($string)
    {
        if (\preg_match('/^[!-~]{8,}$/', $string) === 1 &&
            \preg_match('/(?>[!-\/]|[:-@]|[[-`]|[{-~])/', $string) === 1 &&
            \preg_match('/(?>[A-Z])/', $string) === 1 &&
            \preg_match('/(?>[a-z])/', $string) === 1 &&
            \preg_match('/(?>[0-9])/', $string) === 1) {
            return true;
        }
    
        return false;
    }

    public static function checkEquality($value1, $value2)
    {
        return $value1 === $value2;
    }
}
