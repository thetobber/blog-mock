<?php
namespace Application;

class Validator
{
    public function checkRole($string)
    {
        if (\preg_match($string, '/^[1-3]$/')) {
            return true;
        }
        
        return false;
    }

    public function checkEmail($string)
    {
        if (\filter_var($string, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        }

        return false;
    }

    public function checkUsername($string)
    {
        if (\preg_match($string, '/^[!-~]{191,}$/')) {
            return true;
        }
        
        return false;
    }

    public function checkPassword()
    {
        if (\preg_match($string, '/^[!-~]{12,}$/') === 1 &&
            \preg_match($string, '/(?>[!-\/]|[:-@]|[[-`]|[{-~])/') === 1 &&
            \preg_match($string, '/(?>[A-Z])/') === 1 &&
            \preg_match($string, '/(?>[a-z])/') === 1 &&
            \preg_match($string, '/(?>[0-9])/') === 1) {
            return true;
        }
    
        return false;
    }
}