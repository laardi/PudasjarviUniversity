<!DOCTYPE html>
<div class="col-xs-4">
</div>
<div class="col-xs-4">
    <?php 
        if ($user) {
            echo "Tervetuloa takaisin $user!<br><br>Voit tarkastella oimia varauksiasi ylhäältä oikealta(Omat varaukset), tai tarkastella varaustilannetta ja varata uusia aikoja ylhäältä vasemmalta(Valitse Huone).";
        }
        else {
            echo "Tervetuloa Pudasjärven Yliopiston huonevarausjärjestelmään!
            <br><br>
            Voit tarkastella varaustilannetta kirjautumatta. Kirjautumalla sisään voit varata tilan itsellesi.";
            
        }
        ?>
</div>
<div class="col-xs-4">
</div>
