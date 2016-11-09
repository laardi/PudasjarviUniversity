


$( document ).ready(function() {
    //$('.datepicker').datepicker();
    console.log("ready, ime sykkivää");
    
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
            url: "testing.php/log/",
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

        
        //var ding = formData.split("&");
        //console.log(ding);
        //var tempArray = {} ;
        //for ( i=0; i < ding.length; i++) {
        //    //console.log(ding[i]);
        //    var doodle = ding[i].split("=");
        //    //console.log(doodle);
        //    tempArray[doodle[0]] = doodle[1];
        //}
        //console.log(tempArray);
        //console.log(tempArray["alakupvm"]);
        //console.log(tempArray["loppupvm"]);
        //console.log(tempArray["user"]);
        //console.log(tempArray["room"]);
        //
        //var dataToSend =    {"template":
        //                        {"data":
        //                            [
        //                            {"prompt":"","name":"user","value":""},
        //                            {"prompt":"","name":"rdate","value":""},
        //                            {"prompt":"","name":"ldate","value":""},
        //                            {"prompt":"","name":"item","value":""},
        //                            ]
        //                        }
        //                    };
        
        
        
        return false;
    });
});




