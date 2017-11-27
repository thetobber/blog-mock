<?php
use Application\Router;
use Application\Database;

$router = new Router();

// GET: Index
$router->get('/^\/$/', function ($path, $query, $params) {
    include __DIR__.'/Pages/Index.php';
});

// GET: Profile
$router->get('/^\/User\/(?<id>\d+)$/i', function ($path, $query, $params) {
    $result = false;

    try {
        $statement = Database::getInstance()->prepare('CALL readUser(?)');
        $statement->bindValue(1, (int)$params['id'], PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
    }
    catch (Exception $exception) {
        header('HTTP/1.1 500 Internal Server Error', true);
        include __DIR__.'/Pages/500.php';
        return;
    }

    if ($result === false) {
        header('HTTP/1.1 404 Not Found', true);
        include __DIR__.'/Pages/404.php';
    }
    else {
        include __DIR__.'/Pages/User/Profile.php';
    }
});

// GET: Create
$router->get('/^\/User\/Create$/i', function ($path, $query, $params) {
    include __DIR__.'/Pages/User/Create.php';
});

// GET: Update
$router->get('/^\/User\/Update\/(?<id>\d+)$/i', function ($path, $query, $params) {
    include __DIR__.'/Pages/User/Update.php';
});

// GET: 404
$router->get('/^\/.*$/', function ($path, $query, $params) {
    include __DIR__.'/Pages/404.php';
});



// GET: Single user by username
/* $router->get('/^\/(?<username>[a-zA-Z0-9]+)$/', function ($path, $query, $params) {
    try {
        $statement = Database::getInstance()->prepare('CALL readUser(?)');
        $statement->bindValue(1, 'tobias', PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if ($result !== false) {
            $user = $result;
        }
    }
    catch (PDOException $exception) {
    }
});
 */

// POST: Create new user
/* $router->post('/^\/$/', function () use ($database) {
    try {
        $statement = Database::getInstance()->prepare('CALL createUser(?,?,?,?)');
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $statement->bindValue(1, Roles::SUBSCRIBER, PDO::PARAM_INT);
        $statement->bindValue(2, $_POST['username'], PDO::PARAM_STR);
        $statement->bindValue(3, $_POST['email'], PDO::PARAM_STR);
        $statement->bindValue(4, $password, PDO::PARAM_STR);

        $statement->execute();
    }
    catch (PDOException $exception) {

    }

    include __DIR__.'/Pages/Index.php';
}); */

$router->resolve();
