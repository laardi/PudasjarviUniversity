


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
    // 
    $( '#index' ).click( function(event) {
        //window.location="../";
        $.get('etusivu.php', function ( data ) {
            $("#main_area").html( data );
        });
    });
    $( '#omatVaraukset' ).click( function(event) {
        console.log("Omat varaukset");
        $.get('userIndex.php', function ( data ) {
            $("#main_area").html( data );
        });
    });

    
    $( '#login_button' ).click( function(event) {
        //var formData = $( '#login_form' ).serializeArray();
        //console.log("Böh");
        //e.preventDefault();
        //console.log(formData);
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
                if(html=="True")
                {
                    window.location="../";
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
});




