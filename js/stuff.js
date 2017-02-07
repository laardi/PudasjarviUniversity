


$( document ).ready(function() {
    //$('.datepicker').datepicker();
    console.log("ready, ime sykkivää");
    
    $.get('huone.php?huone=1', function ( data ) {
        console.log("Got something");
        $("#main_area").html( data );
    });
    

    // Huoneiden dropdown valikon nääppäilyt
    $( '#huone1' ).click( function(event) {
        $.get('huone.php?huone=1', function ( data ) {
            $("#main_area").html( data );
        });
    });
    $( '#huone2' ).click( function(event) {
        $.get('huone.php?huone=2', function ( data ) {
            $("#main_area").html( data );
        });
    });
    $( '#huone3' ).click( function(event) {
        $.get('huone.php?huone=3', function ( data ) {
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
    
    // --------------------------
    
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
});




