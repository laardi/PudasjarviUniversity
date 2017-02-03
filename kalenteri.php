<!DOCTYPE html>
<html>
    <head
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.timekit.io/booking-js/v1/booking.min.js"></script>
        <script src='http://momentjs.com/downloads/moment.min.js'></script>
        <script src='fullcalendar/fullcalendar.js'></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    </head>
    
    <body>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
        <div id='calendar'></div>
        </div>
    </div>
    </body>
    
    <script>

        $('#calendar').fullCalendar({
        
        header: {
           right: 'today, prev,next'
            // put your options and callbacks here
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
        })
    </script>
</html>