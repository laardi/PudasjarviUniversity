<?php
// Tulostetaan huoneen tietoja

include("huoneet.php");

$room_no = $_GET['huone'];
$room = $huoneet[$room_no];


if ($room_no <= count($huoneet)) {
    //echo file_get_contents('kalenteri.php');
    include('kalenteri.php');
}
?>