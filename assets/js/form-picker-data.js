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
    // format: 'YYYY-MM-DD',
});


