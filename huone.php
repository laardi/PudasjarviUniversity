<?php
// Tulostetaan huoneen tietoja

$rooms = array( 1 => "Huone 1",
                2 => "Huone 2",
                3 => "Huone 3");

$room_no = $_GET['huone'];
$room = $rooms[$room_no];


if ($room_no < 4) {
    //echo file_get_contents('kalenteri.php');
    include('kalenteri.php');
}
?>