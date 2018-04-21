
import  $ from 'jquery';
global.$ = $;
import 'bootstrap'
import 'fullcalendar'
import 'fullcalendar/dist/locale/fr'
let moment = require('moment');

$(function() {

    console.log(moment().format()) ;
    moment.locale('fr');
    if (top.location.pathname === '/survey')
    {
        let url = Routing.generate('json_survey');
        $.ajax({
            type: "POST",
            url: url,
            success: function(data) {
                console.log(data);
                $.each(data, function() {
                    $.each(this, function(k, v) {
                        console.log(k + '-------' + v) ;
                    });
                });
                $('#calendar').fullCalendar({
                    dayClick: function(date, jsEvent, view) {

                        alert('Clicked on: ' + date.format());

                        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                        alert('Current view: ' + view.name);

                        // change the day's background color just for fun
                        $(this).addClass('bg-success');

                    },
                    editable: true,
                    droppable: true,
                    locale: 'fr',
                    events: data,
                    eventClick: function (event,jsEvent,view) {
                        $('#modalTitle').html(event.title);
                        $('#modalBody').html(event.start.format("LLLL") +'---' + event.end.format("LLLL"));
                        $('#eventUrl').attr('href',event.url);
                        $('#fullCalModal').modal();
                    }
                });
            }
        });
    }
});