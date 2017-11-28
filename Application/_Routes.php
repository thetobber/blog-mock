<?php
use Application\Router;
use Application\Database;
use Application\Models\UserCreateModel;
use Application\Models\UserUpdateModel;
use Application\Models\UserViewModel;
use Application\Security\Roles;
use Application\Security\Authenticator;

$router = new Router();

// GET: Index
$router->get('/^\/$/', function ($path, $query, $params) {
    include __DIR__.'/Pages/Index.php';
});

// GET: Sign in
$router->get('/^\/SignIn$/i', function ($path, $query, $params) {
    include __DIR__.'/Pages/SignIn.php';
});

// POST: Sign in
$router->post('/^\/SignIn$/i', function ($path, $query, $params) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if (Authenticator::signIn($_POST['username'], $_POST['password'])) {
            header('HTTP/1.1 302 Found', true);
            header('Location: /User/'.$_SESSION['user']['id']);
            return;
        }
    }

    $message = 'Invalid username or password.';
    include __DIR__.'/Pages/SignIn.php';
});

// POST: Sign out
$router->post('/^\/SignOut$/i', function ($path, $query, $params) {
    Authenticator::signOut();
    header('HTTP/1.1 302 Found', true);
    header('Location: /SignIn');
});

// GET: Profile
$router->get('/^\/User\/(?<id>\d+)$/i', function ($path, $query, $params) {
    $model = false;

    try {
        $statement = Database::getInstance()->prepare('CALL readUser(?)');
        $statement->bindValue(1, (int)$params['id'], PDO::PARAM_INT);
        $statement->execute();

        $model = $statement->fetch(PDO::FETCH_ASSOC);
        $model = new UserViewModel($model);

        $statement->closeCursor();
    }
    catch (PDOException $exception) {
        header('HTTP/1.1 500 Internal Server Error', true);
        include __DIR__.'/Pages/500.php';
        return;
    }

    if ($model === false) {
        header('HTTP/1.1 404 Not Found', true);
        include __DIR__.'/Pages/404.php';
    }
    else {
        include __DIR__.'/Pages/User/Profile.php';
    }
});

// GET: Create
$router->get('/^\/User\/Create$/i', function () {
    if (Authenticator::isVerified()) {
        header('HTTP/1.1 302 Found', true);
        header('Location: /User/'.$_SESSION['user']['id']);
        return;
    }
    
    include __DIR__.'/Pages/User/Create.php';
});

// POST: Create
$router->post('/^\/User\/Create$/i', function ($path, $query, $params) {
    if (Authenticator::isVerified()) {
        header('HTTP/1.1 302 Found', true);
        header('Location: /User/'.$_SESSION['user']['id']);
        return;
    }

    $model = new UserCreateModel($_POST);
    $state = $model->validate();

    if (!$state->isValid) {
        include __DIR__.'/Pages/User/Create.php';
        return;
    }

    try {
        $statement = Database::getInstance()->prepare('CALL createUser(?,?,?,?)');
        $password = password_hash($model->password, PASSWORD_BCRYPT);

        $statement->bindValue(1, Roles::SUBSCRIBER, PDO::PARAM_INT);
        $statement->bindValue(2, $model->username, PDO::PARAM_STR);
        $statement->bindValue(3, $model->email, PDO::PARAM_STR);
        $statement->bindValue(4, $password, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo '<div class="alert alert-success" role="alert">Your account has been created successfully.</div>';
            return;
        }
    }
    catch (PDOException $exception) {
        if ($exception->getCode() === '23000') {
            $state->errors['username'] = 'Username taken.';
            include __DIR__.'/Pages/User/Create.php';
            return;
        }

        header('HTTP/1.1 500 Internal Server Error', true);
        include __DIR__.'/Pages/500.php';
        return;
    }

    include __DIR__.'/Pages/User/Create.php';
});

// GET: Update
$router->get('/^\/User\/Update\/(?<id>\d+)$/i', function ($path, $query, $params) {
    if (!Authenticator::isSelf($params['id'])) {
        header('HTTP/1.1 401 Unauthorized', true);
        header('Location: /SignIn');
        return;
    }

    $model = false;
    
    try {
        $statement = Database::getInstance()->prepare('CALL readUser(?)');
        $statement->bindValue(1, (int)$params['id'], PDO::PARAM_INT);
        $statement->execute();

        $model = $statement->fetch(PDO::FETCH_ASSOC);
        $model = new UserUpdateModel($model);
        $statement->closeCursor();
    }
    catch (Exception $exception) {
        header('HTTP/1.1 500 Internal Server Error', true);
        include __DIR__.'/Pages/500.php';
        return;
    }

    if ($model === false) {
        header('HTTP/1.1 404 Not Found', true);
        include __DIR__.'/Pages/404.php';
    }
    else {
        include __DIR__.'/Pages/User/Update.php';
    }
});

// POST: Update
$router->post('/^\/User\/Update\/(?<id>\d+)$/i', function ($path, $query, $params) {
    if (!Authenticator::isSelf($params['id'])) {
        header('HTTP/1.1 401 Unauthorized', true);
        header('Location: /SignIn');
        return;
    }

    $model = new UserUpdateModel($_POST);
    $state = $model->validate();

    if (!$state->isValid) {
        include __DIR__.'/Pages/User/Update.php';
        return;
    }

    try {
        $statement = Database::getInstance()->prepare('CALL createUser(?,?,?,?)');
        $password = password_hash($model->password, PASSWORD_BCRYPT);

        $statement->bindValue(1, $model->id, PDO::PARAM_INT);
        $statement->bindValue(2, Roles::SUBSCRIBER, PDO::PARAM_INT);
        $statement->bindValue(3, $model->email, PDO::PARAM_STR);
        $statement->bindValue(4, $password, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo '<div class="alert alert-success" role="alert">Your account has been updated successfully.</div>';
            return;
        }
    }
    catch (PDOException $exception) {
        header('HTTP/1.1 500 Internal Server Error', true);
        include __DIR__.'/Pages/500.php';
        return;
    }

    include __DIR__.'/Pages/User/Create.php';
});

// GET: 404
$router->get('/^\/.*$/', function ($path, $query, $params) {
    include __DIR__.'/Pages/404.php';
});

$router->resolve();
