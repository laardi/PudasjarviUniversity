<?php 

//require './vendor/autoload.php';

include_once 'sql_conf.php';

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
    $logger = new \Monolog\Logger('API logger');
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
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($users);
});

// ------------------------ GET /USERS/ID/ID ----------------------
$app->get('/users/id/{id}/', function ($request, $response, $args) {

    $id = (int)$args['id'];
    $this->logger->addInfo("Username by id");
    $stmt = $this->db->prepare("select username from users where id = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($user);
});

// ------------------------ GET /USERS/USERNAME ----------------------
$app->get('/users/{username}/', function ($request, $response, $args) {

    $username = $args['username'];
    $this->logger->addInfo("Id by username:".$username);
    $stmt = $this->db->prepare("select id from users where username = :username");
    $stmt->bindParam(":username",$username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($user);
});



// ------------------------- GET /USERS/ID/RESERVATIONS --------
$app->get('/users/reservations/{id}/', function ($request, $response, $args) {
    $id = (int)$args['id'];
    //$resid = (int)$args['resid'];
    $this->logger->addInfo("Reservation by userid");
    $stmt = $this->db->prepare("select locations.name, reservations.resid, reservations.starttime, reservations.endtime from reservations join locations on locations.ID = reservations.location where reservations.userid = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $reservations = $stmt->fetchall(PDO::FETCH_ASSOC);
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($reservations);
});

// ------------------------- GET /USERS/RESERVATIONS --------





// ------------------------ POST /LOG/ -----------------------
$app->post('/log/', function ($request, $response) {
    $this->logger->addInfo("Joku yrittää kirjautua");
    $data = $request->getParsedBody();
    $this->logger->addInfo("Data parsettu");
    $username = $data["username"];
    $password = md5($data["password"]);
    $query1 = "select ID from users where username = :user";
    $query2 = "select passhash, ID from passwords where ID = ':id'";
    $this->logger->addInfo("Aletaan kyseleen tietokannalta");
    $stmt = $this->db->prepare($query1);
    $stmt->bindParam(":user", $username);
    $stmt->execute();
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $id["ID"];
    $this->logger->addInfo("ID haettu: $id");
    if(isset($id))
    {
        $this->logger->addInfo("ID on asetettu");
        $stmt2 = $this->db->prepare("select passhash from passwords where ID = $id");
        //$stmt2->bindParam(":id",$id);
        $stmt2->execute();
        
        $passhash = $stmt2->fetch(PDO::FETCH_ASSOC);
        $this->logger->addInfo("saatiin:". json_encode($passhash));
        $passhs = $passhash['passhash'];
        $this->logger->addInfo("passhash haku onnistui $passhs");
        $this->logger->addInfo("annettu hash on        $password");
        if($password == $passhs)
        {
            setcookie('username', $username, false, "/");
            setcookie('userid', $id, false, "/");
            setcookie('authorised', "tosi", false,"/");
            $this->logger->addInfo("ONNISTUI 3=====D");
            echo $id;
        }
        else
        {
            echo "False";
        }
    }
    else
    {
        echo "False";
    }
});

// ajetaan slim appi
$app->run();
?>