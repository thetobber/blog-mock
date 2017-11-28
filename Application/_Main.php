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
    'Application\\Router' => '/Router.php',
    
    'Application\\Security\\Authenticator' => '/Security/Authenticator.php',
    'Application\\Security\\RequestForgery' => '/Security/RequestForgery.php',
    'Application\\Security\\Roles' => '/Security/Roles.php',
    'Application\\Security\\Validator' => '/Security/Validator.php',

    'Application\\Models\\AbstractModel' => '/Models/AbstractModel.php',
    'Application\\Models\\UserViewModel' => '/Models/UserViewModel.php',
    'Application\\Models\\UserUpdateModel' => '/Models/UserUpdateModel.php',
    'Application\\Models\\UserCreateModel' => '/Models/UserCreateModel.php',
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

use Application\Security\Authenticator;

require __DIR__.'/_Helpers.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Static/bootstrap.css">
    <title>BlogMock</title>
</head>

<body>
    <nav class="container my-4">
        <div class="navbar navbar-expand-sm navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="#">BlogMock</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
    
                <?php if (Authenticator::isVerified()): ?>
                    <form action="/SignOut" method="POST" class="form-inline my-2 my-lg-0">
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Sign out</button>
                    </form>
                <?php else: ?>
                    <a href="/SignIn" class="btn btn-info my-2 mr-sm-3 my-sm-0">Sign in</a>
                    <a href="/SignIn" class="btn btn-success my-2 my-sm-0">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php require __DIR__.'/_Routes.php'; ?>
    </main>

    <script src="/Static/jquery.js"></script>
    <script src="/Static/popper.js"></script>
</body>

</html>