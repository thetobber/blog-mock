<?php
namespace Application;

class Environment
{
    protected static $requestPath;

    public static function getMethodPath()
    {
        
    }

    public static function getRequestPath()
    {
        if (self::$requestPath === null) {
            self::$requestPath = $_SERVER['REQUEST_URI'];
            
            if ($pathEnd = strpos(self::$requestPath, '?')) {
                self::$requestPath = substr(
                    self::$requestPath,
                    0,
                    $pathEnd
                );
            }
    
            if (empty(self::$requestPath)) {
                self::$requestPath = '/';
            }
        }

        return self::$requestPath;
    }

    public static function getRequestQuery()
    {

    }
}