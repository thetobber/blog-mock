<?php
$classMap = [
    'Application\\Database' => '/Database.php'
];

spl_autoload_register(function ($className) use ($classMap) {
    if (isset($classMap[$className])) {
        require(__DIR__.$classMap[$className]);
    }
}, true, true);
