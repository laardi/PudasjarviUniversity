<?php 
// TESTING FILE IGNORE THIS FILE

require './vendor/autoload.php';

// Muuttujia
$servername = "localhost";
$dbname     = "pudb";
$username   = "pudisaccess";
$password   = "seos";

// Slimmi app
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "pudisaccess";
$config['db']['pass']   = "seos";
$config['db']['dbname'] = "pudb";

// Luodaan slim app
$app = new \Slim\App(["settings" => $config]);
// containeri
$container = $app->getContainer();
// Lisätään containeriin loggeri
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('Keyloggeri wtf');
    $file_handler = new \Monolog\Handler\StreamHandler("logs/slim_app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
// lisätään db hanskaus
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};


// ======================== GET ================================

// ------------------------ GET /USERS -------------------------
$app->get('/users/', function () {
    $this->logger->addInfo("User list");
    $stmt = $this->db->prepare("select username from users");
    $stmt->execute();
    $users = $stmt->fetchAll();

    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($users);
});

// ------------------------ GET /USERS/ID ----------------------
$app->get('/users/{id}', function ($request, $response, $args) {

    $id = (int)$args['id'];
    $this->logger->addInfo("Username by id");
    $stmt = $this->db->prepare("select username from users where id = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $user = $stmt->fetch();
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($user);
});

// ajetaan slim appi
$app->run();
?>