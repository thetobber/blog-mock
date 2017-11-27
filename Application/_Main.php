<?php
/**
 * Mapping of namespaces to their physical location on disk.
 */
$classMap = [
    'Application\\Database' => '/Database.php',
    'Application\\RoleTable' => '/RoleTable.php',
    'Application\\RouteTable' => '/RouteTable.php',
];

/**
 * Registration of autoload function which will require classes based on the
 * classmap
 */
spl_autoload_register(function ($className) use ($classMap) {
    if (isset($classMap[$className])) {
        require __DIR__.$classMap[$className];
    }
}, true, true);


use Application\RouteTable;

$routeTable = new RouteTable();

$routeTable->get('/^\/$/', function () {
    include __DIR__.'/Pages/Index.php';
});

$routeTable->resolve();
