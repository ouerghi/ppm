
let $activity = $('#artisan_activity');

let $artisan_trades = $('#artisan_trades');

$artisan_trades.hide();

let tag = ('<div class="cssload-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before = $("label[for=artisan_trades]");

$before.before(tag);

let $loader = $('.cssload-container');

$loader.hide();
// When activity gets selected ...
$activity.change(function () {
    $('#artisan_trades').empty();

    // ... retrieve the corresponding form.
    let $form = $(this).closest('form');
    // Simulate form data, but only include the selected activity value.
    let data = {};
    data[$activity.attr('name')] = $activity.val();
    // Submit data via AJAX to the form's action path.
    let id =$activity.val();
    // let url  = 'http://localhost:8000/add-artisan/' + id;
    let url =  Routing.generate('trade', { id : id });
    console.log(url);
    $.ajax({
        url :url ,
        type: $form.attr('method'),
        data : data,
        beforeSend: function (jqXHR, options) {
            $loader.show();
            setTimeout(function() {
                // null beforeSend to prevent recursive ajax call
                $.ajax($.extend(options, {beforeSend: $.noop}));
            }, 1000);
            return false;
        },
        success: function(data) {
            // Replace current position field ...
            $artisan_trades.show();
            $.each(data, function(i, item) {
                console.log(data[i].name);
                $('#artisan_trades').append(
                    ( "<option value='"+data[i].id +"'>" + data[i].name + "</option>" ),
                    $(data).find('#artisan_trades')
                );
            });
            $loader.hide();
        }
    });
    $artisan_trades.hide();
});

// script to dynamic select of activity in page template/setting/index.html.twig
// get the activity and trades dynamic

let $activity_edit = $('#edit_activity_activity');
let $artisan_trades_edit = $('#edit_activity_trades');
$artisan_trades_edit.hide();
let tag_edit = ('<div class="cssload-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before_edit = $("label[for=edit_activity_trades]");
$before_edit.before(tag_edit);
let $loader_edit = $('.cssload-container');
$loader_edit.hide();
// When sport gets selected ...
$activity_edit.change(function () {
    $('#edit_activity_trades').empty();

    // ... retrieve the corresponding form.
    let $form_edit = $(this).closest('form');
    // Simulate form data, but only include the selected sport value.
    let data = {};
    data[$activity_edit.attr('name')] = $activity_edit.val();
    // Submit data via AJAX to the form's action path.
    let id =$activity_edit.val();
    // let url  = 'http://localhost:8000/add-artisan/' + id;
    let url =  Routing.generate('trade', { id : id });
    console.log(url);
    $.ajax({
        url :url ,
        type: $form_edit.attr('method'),
        data : data,
        beforeSend: function (jqXHR, options) {
            $loader_edit.show();
            setTimeout(function() {
                // null beforeSend to prevent recursive ajax call
                $.ajax($.extend(options, {beforeSend: $.noop}));
            }, 1000);
            return false;
        },
        success: function(data) {
            // Replace current position field ...
            $artisan_trades_edit.show();
            $.each(data, function(i, item) {
                console.log(data[i].name);
                $('#edit_activity_trades').append(
                    ( "<option value='"+data[i].id +"'>" + data[i].name + "</option>" ),
                    $(data).find('#edit_activity_trades')
                );
            });
            $loader_edit.hide();
        }
    });
    $artisan_trades_edit.hide();
});
