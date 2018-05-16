import $ from 'jquery'
global .$ = $;
import 'bootstrap'
import 'moment/locale/fr'
import 'eonasdan-bootstrap-datetimepicker'


$('.birthday').datetimepicker({
    locale: 'fr',
    inline: true,
    format: 'YYYY-MM-DD',
    useCurrent: false
});
$('.dateCreation').datetimepicker({
    locale: 'fr',
    inline: true,
    format: 'YYYY-MM-DD',
});
$('.date_survey').datetimepicker({
    locale: 'fr',
    inline: true,
    format: 'YYYY HH:mm:ss DD-MM'
    //https://codereviewvideos.com/course/beginner-s-guide-to-symfony-3-forms/video/dealing-with-dates-and-times
    //format: 'YYYY-MM-DD',
});






