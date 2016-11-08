<?php
$user = "sampus";
$pass = "huuskus";

$users = array(    "sampus" => "huuskus",
                "dlib"   => "rib",
                "hampus" => "seos",
                "jarno"  => "1234",
                "matti"  => "esa");
            
$flag = False;

if (isset($_GET['username']) && isset($_GET['password'])) 
{
    if (($users[$_GET['username']]) && ($_GET['password'] == $users[$_GET['username']])) 
    {    
        
        /* Cookie expires when browser closes */
        setcookie('username', $_GET['username'], false);
        //setcookie('password', md5($_GET['password']), false);
        setcookie('authorised', "tosi", false);
        header('Location: index.php');
    } 
    else 
    {
        $flag = True;
    }
    
} 
//else 
//{
//    echo 'You must supply a username and password.';
//}    

///action='{$_SERVER['PHP_SELF']}' method='post'
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pudas järven yli opisto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
<?php 
if ($flag == True)
    echo '<br>
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="alert alert-danger">
                    <strong>Halt!</strong> Salattu sana tai käyttäjä tunnus väärin! Ota yhteys rehtori Markus "Käkä" Käkelään.
                </div>
            </div>
        </div>
        ';
?>
<div id="login-modal">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h1>Kirjaudu sissään</h1><br>
          <form>
            <input type="text" name="username" placeholder="Käyttäjätunnus">
            <input type="password" name="password" placeholder="Salasana">
            <input type="submit" name="login" class="login loginmodal-submit" value="Kirjaudu">
          </form>
          <div class="login-help">
            <a href="#">Unohtuiko sala sana?</a>
          </div>
        </div>
    </div>
</div>
</body>
</html>
