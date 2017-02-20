

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

function FINtoISO(time) {
    var time = time.split(".");
    time = time[2]+"-"+time[1]+"-"+time[0]
    return time;
}

function keyOfValue(obj, value) {
    for (i in obj) {
        if (obj[i] == value) {
        return i;
        }
    }
}

function roomReservations(room, week) {
    var start = FINtoISO(week[0]);
    var end = FINtoISO(week[6]);
    var reservationCalendar = {};
    //week = week.every();
    var paivat = [ "Ma", "Ti", "Ke", "To", "Pe", "La", "Su" ];
    
    for (kelo = 8; kelo < 19; kelo = kelo +2) {
        reservationCalendar[kelo] = {};
        for (i=0;i<7;i++) {
            reservationCalendar[kelo][paivat[i]] = "";
        }   
    }
    //console.log(reservationCalendar);
      //console.log(start);
    $.ajax(
    {
        type: "GET",
        url: "api.php/reservations/"+room+"/"+start+"/"+end+"/",
        success: function(result) {
            if (result.length > 2) {
                //console.log(JSON.parse(result));
                var res = JSON.parse(result);
               // var paivat = [ "Ma", "Ti", "Ke", "To", "Pe", "La", "Su" ];

                while (res.length>0){
                    var foo = res.shift();
                    var tI = keyOfValue(week, foo.date);
                    reservationCalendar[foo.time][paivat[tI]] = "Varattu";
                }
                //console.log(reservationCalendar);
                var html = drawReservationCalendar(room, reservationCalendar, week);
                
            }
            else {
                console.log("Not found stuf");
                var html = drawReservationCalendar(room, reservationCalendar, week);
            }
            $("#main_area").html( html );
            roomReserveButton();
        }
    });
    return reservationCalendar;
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
            //console.log(reservs);
            //console.log(reservs.length);
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
        //kalenteri();
        roomReservations(roomID, getDaysOfWeek(new Date()));
        //drawReservationCalendar(roomID, ,getDaysOfWeek(new Date()));
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

function drawReservationCalendar(room, reservations, week) {
    // room = kayttajan ID
    var rooms = [ "Kuivala", "ATK101", "Auditorio" ];
    var paivat = [ "Ma", "Ti", "Ke", "To", "Pe", "La", "Su" ];
    var uid = getCookie('userid');
    var html =  "<div class='container'>";
        html += "<div class='col-xs-4 col-xs-offset-4'>Kirjautumalla sisään voit varata tilan "+rooms[room-1]+" alla olevien linkkien kautta.</div>";
        html = html +     "<table  class='table table-striped table-condensed table-bordered'>";
        html = html +         "<tr>";
        html = html +             "<td><b>Kello</b></td>";
        for (i = 0; i<7 ;i++) {
            html = html + "<th>"+paivat[i]+" "+week[i]+"</th>";
        }
        html = html +         "</tr>";
        //html = html +                 for ($i=8; $i<=18; $i=$i+2) {

        
        for (i = 8; i<19; i = i+2) {
            var kello = reservations[i];
            html = html +         "<tr>";
            html = html +         "<td>"+i+":00-"+(i+2)+":00</td>";
            
            //console.log(JSON.stringify(kello));
            for (index in week) {
                var pva = paivat[index];
                //console.log(week[index]);
                //console.log("asd:"+index+", foo:"+kello[pva]);
                
                if (kello[pva] == "Varattu") {
                    html = html + "<td>  </td>";  // Jos huone on varattu niin jätetään tyhjäksi
                }
                else if (uid.length > 0) {
                    //html += "<td><a class='reserveRoom' href='/api.php/reserve/"+uid+"/"+room+"/"+week[index]+"/"+i+"/'> Vapaa </td>";
                    
                    html += '<td><a href="#" data-href="/api.php/reserve/'+uid+'/'+room+'/'+week[index]+'/'+i+'/" data-toggle="modal" data-target="#confirm-reservation">Vapaa</a></td>';

                    //html +='   <td ><button class="btn btn-default" data-href="/api.php/reserve/"+uid+"/"+room+"/"+week[index]+"/"+i+"/" data-toggle="modal" data-target="#confirm-reservation"> Vapaa </button></td>';

                }
                else {
                    html += "<td> Vapaa</td>";
                }
                
            }
            html = html +         "</tr>";
        }
        html = html +     "</table>";
        html = html + "</div>'";
        return html;
}

function getMonday(d) {
    d = new Date(d);
    var day = d.getDay(), diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
    var foo = new Date(d.setDate(diff))
    return foo;
}

function getDaysOfWeek(pvm) {
    var lista = {};
    //var dat = new Date();
    pvm = getMonday(pvm);
    lista[0] = pvm.toLocaleString().slice(0,9);
    
    for (i = 1; i<7; i++) {
        pvm.setDate(pvm.getDate() + 1);
        lista[i] = pvm.toLocaleString().slice(0,9);
    }
    return lista;
}

function drawReservationTable(reservations)  {
    // reservations = array jonka sisällä varaukset
    if (typeof reservations == 'object') {
        //console.log(reservations);
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
        //reservations = [ {resid:"15",name:"kuivala",date:"17.02",time:"8"}, {resid:"16",name:"atk123",date:"15.02",time:"10"} ];
        for (i = 0; i < reservations.length; i++) {    
            var varausID = reservations[i].resid;
            var paikka = reservations[i].name;
            var pvm = reservations[i].date;
            var klo1 = Number(reservations[i].time);
            var klo = klo1+":00-"+(klo1+2)+":00";
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

function automagicRoomButons(neededButtons) {
    buttonDropdown = document.getElementById('room-selector');
    var butons = JSON.parse(neededButtons);
    var listOfButtons = {};
    for (i = 0; i < butons.length; i++) {
        //console.log(i);
      var li = document.createElement("li");
      var link = document.createElement("a");
      var text = document.createTextNode(butons[i].name);
      var buttonId = "huone"+butons[i].id;
      //console.log(text);
      link.appendChild(text);
      link.href = "#";
      link.id = buttonId;
      li.appendChild(link);
      listOfButtons[i] = buttonId;
      
      buttonDropdown.appendChild(li);
      
      
      //newButton = document.createElement('input');
      //newButton.type = 'button';
      //newButton.value = neededButtons[i];
      //newButton.id = neededButtons[i];
      //newButton.onclick = function () {
      //  alert('You pressed '+this.id);
      //};
      //buttonContainer.appendChild(newButton);
    }

    return listOfButtons;
    
}
function enableRooms(rooms) {
    
    //for (var room in rooms) {
    //    console.log("Luodaan linkki tilalle: "+rooms[room]);
    //    var linkID = rooms[room];
    //    var roomID = linkID.slice(5);
    //    $( '#'+linkID ).click( function(event) {
    //        console.log("Valittu "+linkID);
    //        roomSelection(roomID);
    //    });
    //}
    
    //Huoneiden dropdown valikon nääppäilyt
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
}

function roomReserveButton() {
    $( '.reserveRoom' ).click( function(event) {
        event.preventDefault();
        event.stopPropagation();
        console.log("Clikked link");
        var href = this.getAttribute('href');
        console.log(href);
    });
}

function enableButtons() {
    $('#confirm-reservation').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('.btn-ok').click( function(e) {
            var href = $('.btn-ok').attr('href');
            
            e.preventDefault();
            console.log("Dingdong");
            console.log(href);
        });
        //window.location="../";
        //var href = $(this).find
        //e.preventDefault();
        //console.log(href);
        //$.get(href, function (data) {
        //    if (data=="True"){
        //        console.log("Onnistui");
        //    }
        //})
        //$("#confirm-reservation .close").click();
       // return false;
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
                //console.log(html);
                if (html != "False" )
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
}

$( document ).ready(function() {
    //console.log(getDaysOfWeek(new Date()));
    
    $.ajax(
    {
        type:"GET",
        url:"api.php/locations/",
        success: function( result ) {
            var list = automagicRoomButons(result);
            //console.log(list);
            enableRooms(list);
        }
    });
    enableButtons();
    
    console.log("Sivun lataus valmis.");
});




