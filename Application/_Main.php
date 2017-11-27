<?php
/**
 * Starting session
 */
session_start();

/**
 * Configure session (should be done in PHP config)
 */
ini_set('session.name', 'vf56p3x0');
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);
ini_set('session.cookie_lifetime', 0);

/**
 * Set the default timezone to be used with all date and time functions.
 */
date_default_timezone_set('Europe/Copenhagen');

/**
 * Mapping of namespaces to their physical location on disk.
 */
$classMap = [
    'Application\\Database' => '/Database.php',
    'Application\\Roles' => '/Roles.php',
    'Application\\Router' => '/Router.php',
    'Application\\RequestForgery' => '/RequestForgery.php',
    'Application\\Validator' => '/Validator.php'
];

/**
 * Registration of autoload function which will require classes based on the
 * classmap.
 */
spl_autoload_register(function ($className) use ($classMap) {
    if (isset($classMap[$className])) {
        require __DIR__.$classMap[$className];
    }
}, true, true);

require __DIR__.'/_Routes.php';
exit();
