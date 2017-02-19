

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function userReservations(user) {
    $.ajax(
    {
        type: "GET",
        url: "api.php/users/reservations/"+user+"/",
        success: function(reservs)
        {   
            //console.log(reservs);
            //console.log(JSON.parse(reservs));
            //console.log(JSON.stringify(JSON.parse(reservs)));
            console.log(reservs);
            console.log(reservs.length);
            if (reservs.length >2) {
                var html = drawReservationTable(JSON.parse(reservs));
            }
            else {
                var html = drawReservationTable();
            }
            //console.log(html);
            $("#main_area").html( html );
        }
    });
}

function roomSelection( roomID ) {
        $.get('huone.php?huone='+roomID, function ( data ) {
        $("#main_area").html( data );
        kalenteri();
    });
}


function kalenteri() {
    $('#calendar').fullCalendar({
        header: {
           right: 'today, prev,next'
        },
        defaultView: 'agendaWeek',
        editable: true,
        firstDay: 1,
        weekNumbers: true,
        weekends: false,
        minTime: '8:00',
        maxTime: '16:00',
        
        events: [
            {
             title : 'Dlib Ribin varaus',
             start : '2017-02-02T08:00:00',
             end   : '2017-02-02T12:00:00',
             },
             {
             title : 'Kakelan varaus',
             start : '2017-02-01T10:00:00',
             end   : '2017-02-01T14:00:00',
             }
        ]
    });
}    

function drawReservationCalendar(room) {
    // room = kayttajan ID
    
    var html =  "<div class='container'>";
        html +=     "<table  class='table table-striped table-condensed table-bordered'>";
        html +=         "<tr>";
        html +=             "<td><b>Kello</b></td>";
        //                    <?php 
        //                        foreach ($viikko as $paiva=>$maara) {
        //                            echo "<th>".$paiva." ".$maara."</th>";
        //                        }
        //                    ?>
        //html +=
        //html +=         "</tr>";
        //html +=             <?php
        //html +=                 for ($i=8; $i<=18; $i=$i+2) {
        //html +=                     $j = $i +2;
        //html +=                     echo "<tr>";
        //html +=                     echo "<td>$i-$j</td>";
        //html +=                     for ($k=1; $k<=7; $k++) {
        //html +=                         echo "<td>Jill</td>";
        //html +=                     }
        //html +=                     echo "</tr>";
        //html +=                 }
        //html +=             ?>
        html +=     "</table>";
        html += "</div>'";
}

function getDaysOfWeek() {
    //var curr = new Date();
    //var monday = new Date(curr.getDate()-curr.GetDay());
    //var monday = moment().startOf('isoweek').format("DD.MM");
    //var monday = moment().isoWeekday(1);
    var viikko = ["13.2","14.2","15.2","16.2","17.2","18.2","19.2"];
    return viikko;
}

function drawReservationTable(reservations)  {
    // reservations = array jonka sisällä varaukset
    if (typeof reservations == 'object') {
    var html = '<div class="container">                                                                                                         ';
    html =html+ '    <div class="row">                                                                                                           ';
    html =html+ '        <div class="col-xs-5 col-xs-offset-3">                                                                                  ';
    html =html+ '        <table  class="table table-striped table-bordered table-condensed">                                                     ';
    html =html+ '              <tr>                                                                                                              ';
    html =html+ '                    <td><b>Huone</b></td>                                                                                       ';
    html =html+ '                    <td><b>Pvm</b></td>                                                                                         ';
    html =html+ '                    <td><b>Klo</b></td>                                                                                         ';
    html =html+ '                    <td><b></b></td>                                                                                      ';
    html =html+ '              </tr>                                                                                                             ';
        for (i = 0; i < reservations.length; i++) {    
            var varausID = reservations[i].resid;
            var paikka = reservations[i].name;
            var starttime = reservations[i].starttime;
            var endtime = reservations[i].endtime;
            var pvm = starttime.slice(6,8)+"."+starttime.slice(4,6); // 2017 0213 1000
            var klo = starttime.slice(8,10)+":"+starttime.slice(8,10)+"-"+endtime.slice(8,10)+":"+endtime.slice(8,10);
            
            html =html+ '<tr>'; 
            html =html+ "<td>"+paikka+"</td><td>"+pvm+"</td><td>"+klo+"</td><td><a href='#' id='poistaVaraus' value='"+varausID+"'>Poista</a></td>";   
            html =html+ '</tr>';
        }                                                                                                        
    html =html+ '        </table>                                                                                                                ';
    html =html+ '        </div>                                                                                                                  ';
    html =html+ '    </div>                                                                                                                      ';
    html =html+ '</div>';
    }
    else {
    var html = '<div class="container">';
    html = html+ ' <div class="row">';
    html = html+ ' <div class="col-xs-4 col-xs-offset-4">';
    html = html+ ' Sinulla ei ole yhtään voimassaolevaa varausta.<br>';
    html = html+ ' Voit varata ylläolevan "Valitse huone" valikon kautta itsellesi tiloja.'; 
    html = html+ ' </div>';
    html = html+ ' </div>';
    html = html+ ' </div>';
    }
    return html;
}


$( document ).ready(function() {
    console.log("Sivun lataus valmis.");
    

    // Huoneiden dropdown valikon nääppäilyt
    $( '#huone1' ).click( function(event) {
        console.log("Valittu huone1");
        roomSelection(1);
    });
    $( '#huone2' ).click( function(event) {
        console.log("Valittu huone2");
        roomSelection(2);
    });
    $( '#huone3' ).click( function(event) {
        console.log("Valittu huone3");
        roomSelection(3);
    });
    
    // Yliopiston nimen kliksautus
    $( '#index' ).click( function(event) {
        //window.location="../";
        $.get('etusivu.php', function ( data ) {
            $("#main_area").html( data );
        });
    });
    
    // Omat varaukset nappi
    $( '#omatVaraukset' ).click( function(event) {
        console.log("Omat varaukset");
        var uid = getCookie('userid');
        userReservations(uid);
    });
    
    $( '#poistaVaraus' ).click( function(event) {
        console.log("Varauksen poisto");
        var asd = $(this).attr('value');
        console.log(asd);
        
        
    });
    
    $( '#login_button' ).click( function(event) {
        var user = $( '#username' ).val();
        var pass = $( '#password' ).val();
        //console.log(user);
        $.ajax(
        {
            type: "POST",
            url: "api.php/log/",
            data: $( '#login_form' ).serialize(),
            success: function(html)
            {
                console.log(html);
                if(html)
                {
                    //console.log(USERID);
                    window.location="../";
                    //userReservations(html);
                    //console.log("yritetään ohjata indexiin");
                }
                else
                {
                    $( "#error" ).show();
                    //console.log(html);
                    //console.log("Virheellinen yhistelmä");
                }
            }
        });
        return false;
    });
});




