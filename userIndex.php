<?php
print_r($_POST);
echo json_decode($_POST);

function getWeek($week, $year) {
    $paivat = array("Ma", "Ti", "Ke", "To", "Pe", "La", "Su" );
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    foreach ($paivat as $paiva){
        $ret[$paiva] = $dto->format('d.m.Y');
        $dto->modify('+1 days');
    }
    return $ret;
}
$viikkoNro = date("W", strtotime("now"));
$vuosi  = date("Y", strtotime("now"));
$viikko = getWeek($viikkoNro ,$vuosi);

$varaus = array(    "huone"     =>  "Kuivala",
                    "pvm"       =>  "16.2",
                    "klo"       =>  "08:00-10:00");
$varaukset  = array( $varaus );

?>
<div class="container">
    <div class="row">
        <div class="col-xs-5 col-xs-offset-3">
        <table  class="table table-striped table-bordered table-condensed">
              <tr>
                    <td><b>Huone</b></td>
                    <td><b>Pvm</b></td>
                    <td><b>Klo</b></td>
                    <td><b>Poista</b></td>
              </tr>
              <tr>
                    <?php
                        foreach ($varaukset as $varaus) {
                            //foreach ($varaus as )
                            echo "<td>".$varaus["huone"]."</td><td>".$varaus["pvm"]."</td><td>".$varaus["klo"]."</td><td></td>";
                        }
                    ?>
              </tr>

        </table>
        </div>
    </div>
</div>
