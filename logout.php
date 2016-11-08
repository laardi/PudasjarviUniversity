<?php
if (isset($_COOKIE['authorised']))
{
    setcookie('authorised', '', time()-7000000, '/');
    setcookie('username', '', time()-7000000, '/');
}
header('Location: index.php');
exit;
?>