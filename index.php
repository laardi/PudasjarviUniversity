<!DOCTYPE html>
<?php
//require_once __DIR__ . './vendor/autoload.php';

if (isset($_COOKIE["username"]) && isset($_COOKIE["authorised"]))
{
    $user = $_COOKIE["username"];
}
else
{
    $user = Null;
}

include("huoneet.php");
?>
<html lang="en">
    <head>
        <title>Pudasjärven yliopisto</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/login.css"> 
        <link rel="stylesheet" type="text/css" href="css/table.css"> 
        <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/stuff.js"></script>
        <script src='http://momentjs.com/downloads/moment.min.js'></script>
        <script src='fullcalendar/fullcalendar.js'></script>
        <script src="https://cdn.timekit.io/booking-js/v1/booking.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#" id="index">Pudasjärvi University</a>
                </div>
                <ul class="nav navbar-nav navbar-left">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Valitse Huone 
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="room-selector">
                            <?php
                            //foreach ($huoneet as $nro => $huone) {
                            //    echo '<li><a id="huone'.$nro.'" href="#">'.$huone.'</a></li>';
                            //}
                            ?>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php 
                        if ($user) {
                            echo '
                    <li><a href="#" id="omatVaraukset">Omat varaukset</a></li>
                        <li><a href="logout.php">Kirjaudu Ulos</a></li> ';}
                        else {
                            echo '
                    <li><a href="#" data-toggle="modal" data-target="#login-modal">Kirjaudu</a></li> ';}
                    ?>
                </ul>
            </div>
        </nav>
        

        <div class="container-fluid">
        
        <div class="row" id="main_area">
            <!-- <iframe id="the_iframe" src="etusivu.php" width="95%" frameborder="0" scrolling="no"></iframe> -->
            <!-- TÄHÄN PUKATAAN JUTTUA -->
            <?php 
            //if ($user) {
            //    include('userIndex.php');
            //}
            //else {
                //echo file_get_contents('etusivu.php');
                include('etusivu.php');
            //}
             ?>
        </div>
        
        </div>
        
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <h1>Kirjaudu sissään</h1><br>
                    <form id="login_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <input id="username" type="text" name="username" placeholder="Käyttäjätunnus">
                        <input id="password" type="password" name="password" placeholder="Salasana">
                        <input id="login_button" type="submit" name="login" class="login loginmodal-submit" value="Kirjaudu">
                    </form>

                    <div class="login-help">
                        <a href="#">Unohtuiko salasana? Vaihda salasana PudUni-järjestelmän kautta.</a>
                    </div>
                    <div id="error" class="alert alert-danger alert-dismissable" style="display: none;">
                        <strong>Halt!</strong> Salasana tai tunnus väärä.
                        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
                            &times;
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal varausta varten-->
        <div class="modal fade" role="dialog" id="confirm-reservation" aria-hidden="true">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Tilan varaus</h4>
                    </div>
                    <div class="modal-body">
                        <p>Pitäskö varata</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-success btn-ok varaa">Kyllä</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Ei</button>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Modal varauksen poistoa varten-->
        <div class="modal fade" role="dialog" id="delete-reservation" aria-hidden="true">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Varauksen poisto</h4>
                    </div>
                    <div class="modal-body">
                        <p>Poistetaanko varaus?</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-success btn-ok poista">Kyllä</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Ei</button>
                    </div>
                </div>

            </div>
        </div>
        
    </body>
</html>

