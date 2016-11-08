<!DOCTYPE html>
<?php
$users = array(    "sampus" => "huuskus",
                "dlib"   => "rib",
                "hampus" => "seos",
                "jarno"  => "1234",
                "matti"  => "esa");
$flag = False;

if (isset($_POST['username']) && isset($_POST['password']) && $_POST['login'] = "Kirjaudu")  
{
    if (($users[$_POST['username']]) && ($_POST['password'] == $users[$_POST['username']])) 
    {    
        /* Cookie expires when browser closes */
        setcookie('username', $_POST['username'], false);
        //setcookie('password', md5($_POST['password']), false);
        setcookie('authorised', "tosi", false);
    } 
    else 
    {
        $flag = True;
    }
}

if (isset($_COOKIE["authorised"]))
    $user = $_COOKIE["username"];
else
    $user = Null;
?>
<html lang="en">
<head>
    <title>Pudas järven yli opisto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.timekit.io/booking-js/v1/booking.min.js"></script>
    <script src="js/stuff.js"></script>
    <script src='http://momentjs.com/downloads/moment.min.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css"> 
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Pudasjärvi University</a>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#">Huoneet</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php 
                    if ($user)
                        echo '
                <li><a href="#">'.$user.'</a></li>
                <li><a href="logout.php">Kirjaudu Ulos</a></li> ';
                    else
                        echo '
                <li><a href="#" data-toggle="modal" data-target="#login-modal">Kirjaudu</a></li> ';
                ?>
            </ul>
        </div>
    </nav>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div id='calendar'></div>
    </div>
</div>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h1>Kirjaudu sissään</h1><br>
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <input type="text" name="username" placeholder="Käyttäjätunnus">
                <input type="password" name="password" placeholder="Salasana">
                <input type="submit" name="login" class="login loginmodal-submit" value="Kirjaudu">
            </form>

            <div class="login-help">
                <a href="#">Unohtuiko salasana? Hajoa itseesi.</a>
            </div>
        </div>
    </div>
</div>
</body>



<script>
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
    
    header: {
       right: 'today, prev,next'
        // put your options and callbacks here
    },
    defaultView: 'basicWeek',
	events: [
		{title : 'Dlib Ribin varaus',
		 start : '2016-11-08',
		 end   : '2016-11-10',
		 allDay : true 
		}
	]
    })

});
</script>


</html>

