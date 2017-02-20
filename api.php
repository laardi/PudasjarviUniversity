<?php 

require './vendor/autoload.php';

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
// ------------------------ GET /LOCATIONS -------------------------
$app->get('/locations/', function () {
    $this->logger->addInfo("Location list");
    $stmt = $this->db->prepare("select id,name from locations");
    $stmt->execute();
    $locs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($locs);
});

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



// ------------------------- GET /USERS/RESERVATIONS/ID/ /--------
$app->get('/users/reservations/{id}/', function ($request, $response, $args) {
    $id = (int)$args['id'];
    //$resid = (int)$args['resid'];
    $this->logger->addInfo("Reservation by userid");
    $stmt = $this->db->prepare("select locations.name, reservations.resid, date_format(reservations.date,'%e.%c.%Y') as date, reservations.time from reservations join locations on locations.ID = reservations.location where reservations.userid = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $reservations = $stmt->fetchall(PDO::FETCH_ASSOC);
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($reservations);
});

// ------------------------- GET /RESERVATIONS/ID/WEEKSTART/WEEKEND/ --------
$app->get('/reservations/{id}/{start}/{end}/', function ($request, $response, $args) {

    $id = (int)$args['id'];
    $start = (string)$args['start'];
    $end = (string)$args['end'];
    //$start = strtotime()
    //$resid = (int)$args['resid'];
    $this->logger->addInfo("Reservation by roomid");
    $stmt = $this->db->prepare("SELECT date_format(reservations.date,'%e.%c.%Y') as date, reservations.time from reservations where reservations.location = :id and reservations.date BETWEEN cast( :start as date) and cast( :end as date)");
    $stmt->bindParam(":id",$id);
    $stmt->bindParam(":start",$start);
    $stmt->bindParam(":end",$end);
    $stmt->execute();
    $reservations = $stmt->fetchall(PDO::FETCH_ASSOC);
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($reservations);
});

// ------------------------- GET /RESERVE/USERID/ROOMID/DAY/HOUR/ --------
$app->get('/reservations/{id}/{start}/{end}/', function ($request, $response, $args) {

    $id = (int)$args['id'];
    $start = (string)$args['start'];
    $end = (string)$args['end'];
    //$start = strtotime()
    //$resid = (int)$args['resid'];
    $this->logger->addInfo("Reservation by roomid");
    $stmt = $this->db->prepare("SELECT date_format(reservations.date,'%e.%c.%Y') as date, reservations.time from reservations where reservations.location = :id and reservations.date BETWEEN cast( :start as date) and cast( :end as date)");
    $stmt->bindParam(":id",$id);
    $stmt->bindParam(":start",$start);
    $stmt->bindParam(":end",$end);
    $stmt->execute();
    $reservations = $stmt->fetchall(PDO::FETCH_ASSOC);
    //$response->getBody()->write(var_export($users, true));
    //return $response;
    echo json_encode($reservations);
});

// ------------------------ POST /LOG/ -----------------------
$app->post('/log/', function ($request, $response) {
    $this->logger->addInfo("Joku yrittää kirjautua");
    $data = $request->getParsedBody();
    $this->logger->addInfo("Data parsettu");
    $username = $data["username"];
    $password = md5($data["password"]);
    $this->logger->addInfo("Tunnus :".$username);
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
            //$this->logger->addInfo("y is not work");
            setcookie('userid', $id, false, "/");
            setcookie('authorised', "tosi", false,"/");
            $this->logger->addInfo("ONNISTUI");
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
