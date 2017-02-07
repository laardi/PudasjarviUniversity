<?php
// Tulostetaan huoneen tietoja


$rooms = array( 1 => "Huone 1",
                2 => "Huone 2",
                3 => "Huone 3");

$room_no = $_GET['huone'];
$room = $rooms[$room_no];

//echo "NAHKAJOOSEPIN MUNA ".$room;

//echo '
//<div class="container-fluid">
//  <h1>Hello World!</h1>
//  <div class="row">
//    <div class="col-sm-4" style="background-color:yellow;">
//      <p>'.$room.'</p>
//    </div>
//    <div class="col-sm-8" style="background-color:pink;">
//      <p>Sed ut perspiciatis...</p>
//    </div>
//  </div>
//</div>
//';

if ($room_no == 1) {
    //echo "PEENIS";
    echo file_get_contents('kalenteri.php');
}

?>