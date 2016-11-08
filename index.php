<!DOCTYPE html>
<?php
//echo 'Hello ' . htmlspecialchars($_COOKIE["authorised"]) . '!';
//$user = 'sampus';
//$pass = 'huuskus';

if (!isset($_COOKIE["authorised"]))
	header('Location: login.php');
else
	$user = $_COOKIE["username"];
	echo 'Hello '.$user.'!';
	
//
//if (isset($_POST['user']) && isset($_POST['pass'])) 
//{
//    if (($_POST['user'] == $user) && ($_POST['pass'] == $pass)) {    
//        
//        if (isset($_POST['rememberme'])) {
//            /* Set cookie to last 1 year */
//            setcookie('username', $_POST['user'], time()+60*60*24*365, '/account', 'www.example.com');
//            setcookie('password', md5($_POST['password']), time()+60*60*24*365, '/account', 'www.example.com');
//        
//        } else {
//            /* Cookie expires when browser closes */
//            setcookie('username', $_POST['user'], false, '/account', 'www.example.com');
//            setcookie('password', md5($_POST['pass']), false, '/account', 'www.example.com');
//        }
//        header('Location: index.php');
//        
//    } else {
//        echo 'Username/Password Invalid';
//    }
//    
//} 
//else 
//{
//    echo 'You must supply a username and password.';
//}


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
  <script src="stuff.js"></script>
  <script src='http://momentjs.com/downloads/moment.min.js'></script>
  <script src='fullcalendar/fullcalendar.js'></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="login.css"> 
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Pudasjärvi University</a>
    </div>
    <ul class="nav navbar-nav">

      <li><a href="#">Huoneet</a></li>
      <li><a href="#">Omat varaukset</a></li> 
      <li><a href="logout.php">Kirjaudu Ulos</a></li> 
    </ul>
  </div>
</nav>
<div class="container-fluid">
  <form method="post" id="varaus-form">
    <div class="row">
      <div class="col-xs-3">
        <h2>Varrauksen alaku pvm</h2>
        <div class="input-group date" data-provide="datepicker">
          <input type="text" class="form-control" name="alakupvm">
          <div class="input-group-addon">
              <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <h2>Varrauksen loppu pvm</h2>
        <div class="input-group date" data-provide="datepicker">
          <input type="text" class="form-control" name="loppupvm">
          <div class="input-group-addon">
              <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <div class="form-group">
          <h2>VALITE KETÄ</h2>
          <select name="user" class="form-control">
              <?php
                $nimet = array("sampooko", "kaarle", "ivan");
                foreach( $nimet as $nimi ){
                  echo "<option>$nimi</option>"; 
                }
              ?>
          </select>
        </div>
      </div>
      <div class="col-xs-3">
        <div class="form-group">
          <h2>VALITE MITÄ</h2>
          <select name="room" class="form-control">
              <?php
                $nimet = array(1,2,3);
                foreach( $nimet as $nimi ){
                  echo "<option value='$nimi'>$nimi</option>"; 
                }
              ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block" id="hinttari">SUB MIT</button>  
      </div>
    </div>
  </form>

</div>

<div class="row">
	<div class="col-xs-8 col-xs-offset-2">
		<div id='calendar'></div>
	</div>
</div>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<h1>Kirjaudu sissään</h1><br>
		  <form>
			<input type="text" name="user" placeholder="Käyttäjätunnus">
			<input type="password" name="pass" placeholder="Salasana">
			<input type="submit" name="login" class="login loginmodal-submit" value="Kirjaudu">
		  </form>
			
		  <div class="login-help">
			<a href="#">Unohtuiko salasana?</a>
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
	defaultView: 'basicWeek'
	})

});
</script>


</html>

