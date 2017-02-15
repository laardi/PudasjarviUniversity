<?php
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

?>
<div class="well">
    Basic well. 
</div>'
<div class="container">
    <table  class="table table-striped">
          <tr>
                <td><b>Kello</b></td>
                <?php 
                    foreach ($viikko as $paiva=>$maara) {
                        echo "<th>".$paiva." ".$maara."</th>";
                    }
                ?>

          </tr>
          <tr>
                <td>08:00-10:00</td>
                <?php
                    for ($i=1; $i<=7; $i++) {
                        echo "<td>Jill</td>";
                    }
                ?>
          </tr>
          <tr>
                <td>Eve</td>
                <td>Jackson</td> 
                <td>94</td>
          </tr>
    </table>
</div>
