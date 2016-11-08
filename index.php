<!DOCTYPE html>
<?php
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
        <link rel="stylesheet" type="text/css" href="css/login.css"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/stuff.js"></script>
        <script src='http://momentjs.com/downloads/moment.min.js'></script>
        <script type="text/javascript">
           function calcHeight()
           {
            //find the height of the internal page
            var the_height=
            document.getElementById('the_iframe').contentWindow.
            document.body.scrollHeight;

            //change the height of the iframe
            document.getElementById('the_iframe').height=
            the_height;
           }
        </script>
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
            <iframe id="the_iframe" src="kalenteri.php" width="100%" frameborder="0" scrolling="no"></iframe>
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
        var buffer = 20; //scroll bar buffer
        var iframe = document.getElementById('the_iframe');


        function pageY(elem) {
            return elem.offsetParent ? (elem.offsetTop + pageY(elem.offsetParent)) : elem.offsetTop;
        }


        function resizeIframe() {
            var height = document.documentElement.clientHeight;
            height -= pageY(document.getElementById('the_iframe'))+ buffer ;
            height = (height < 0) ? 0 : height;
            document.getElementById('the_iframe').style.height = height + 'px';
        }
        
        // .onload doesn't work with IE8 and older.
        if (iframe.attachEvent) {
            iframe.attachEvent("onload", resizeIframe);
        } else {
            iframe.onload=resizeIframe;
        }

        window.onresize = resizeIframe;
    </script>

</html>

