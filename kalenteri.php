    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <?php echo "Alla näet varaustilanteen tilan ".$room." osalta."; ?><br>
        </div>
    </div>
    <div class="row">
    </div>
<?php
    //<div class="row">
    //    <div class="col-xs-8 col-xs-offset-2">
    //    <div id='calendar'></div>
    //    </div>
    //</div>

    


function getWeek($week, $year) {
    $paivat = array("Ma", "Ti", "Ke", "To", "Pe", "La", "Su" );
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    foreach ($paivat as $paiva){
        $ret[$paiva] = $dto->format('d.m');
        $dto->modify('+1 days');
    }
    return $ret;
}
$viikkoNro = date("W", strtotime("now"));
$vuosi  = date("Y", strtotime("now"));
$viikko = getWeek($viikkoNro ,$vuosi);



?>

<div class="container">
    <table  class="table table-striped table-condensed table-bordered">
          <tr>
                <td><b>Kello</b></td>
                <?php 
                    foreach ($viikko as $paiva=>$maara) {
                        echo "<th>".$paiva." ".$maara."</th>";
                    }
                ?>

          </tr>
                <?php
                    for ($i=8; $i<=18; $i=$i+2) {
                        $j = $i +2;
                        echo "<tr>";
                        echo "<td>$i-$j</td>";
                        for ($k=1; $k<=7; $k++) {
                            echo "<td>varattu</td>";
                        }
                        echo "</tr>";
                    }
                
                

                ?>

    </table>
</div>
