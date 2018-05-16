
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

// script page edit government and activity
let $activity_gov = $('#edit_gov_activ_activity');

let $artisan_trades_gov = $('#edit_gov_activ_trades');

$artisan_trades_gov.hide();

let tag_gov = ('<div class="cssload-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before_gov = $("label[for=edit_gov_activ_trades]");

$before_gov.before(tag_gov);

let $loader_gov = $('.cssload-container');

$loader_gov.hide();
// When activity gets selected ...
$activity_gov.change(function () {
    $('#edit_gov_activ_trades').empty();

    // ... retrieve the corresponding form.
    let $form_gov = $(this).closest('form');
    // Simulate form data, but only include the selected activity value.
    let data_gov = {};
    data_gov[$activity_gov.attr('name')] = $activity_gov.val();
    // Submit data via AJAX to the form's action path.
    let id_gov =$activity_gov.val();
    // let url  = 'http://localhost:8000/add-artisan/' + id;
    let url =  Routing.generate('trade', { id : id_gov });
    console.log(url);
    $.ajax({
        url :url ,
        type: $form_gov.attr('method'),
        data : data_gov,
        beforeSend: function (jqXHR, options) {
            $loader_gov.show();
            setTimeout(function() {
                // null beforeSend to prevent recursive ajax call
                $.ajax($.extend(options, {beforeSend: $.noop}));
            }, 1000);
            return false;
        },
        success: function(data) {
            // Replace current position field ...
            $artisan_trades_gov.show();
            $.each(data, function(i, item) {
                console.log(data[i].name);
                $('#edit_gov_activ_trades').append(
                    ( "<option value='"+data[i].id +"'>" + data[i].name + "</option>" ),
                    $(data).find('#edit_gov_activ_trades')
                );
            });
            $loader_gov.hide();
        }
    });
    $artisan_trades_gov.hide();
});

// script page add company
let $activity_company = $('#company_activity');

let $company_trades = $('#company_trades');

  $company_trades.hide();

let tag_company = ('<div class="cssload-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before_company = $("label[for=company_trades]");

$before_company.before(tag_company);

let $loader_company = $('.cssload-container');

$loader_company.hide();
// When activity gets selected ...
$activity_company.change(function () {
    $('#company_trades').empty();

    // ... retrieve the corresponding form.
    let $form_gov = $(this).closest('form');
    // Simulate form data, but only include the selected activity value.
    let data_company = {};
    data_company[$activity_company.attr('name')] = $activity_company.val();
    // Submit data via AJAX to the form's action path.
    let id_company =$activity_company.val();
    // let url  = 'http://localhost:8000/add-artisan/' + id;
    let url =  Routing.generate('trade', { id : id_company });
    console.log(url);
    $.ajax({
        url :url ,
        type: $form_gov.attr('method'),
        data : data_company,
        beforeSend: function (jqXHR, options) {
            $loader_company.show();
            setTimeout(function() {
                // null beforeSend to prevent recursive ajax call
                $.ajax($.extend(options, {beforeSend: $.noop}));
            }, 1000);
            return false;
        },
        success: function(data) {
            // Replace current position field ...
            $company_trades.show();
            $.each(data, function(i, item) {
                console.log(data[i].name);
                $('#company_trades').append(
                    ( "<option value='"+data[i].id +"'>" + data[i].name + "</option>" ),
                    $(data).find('#company_trades')
                );
            });
            $loader_company.hide();
        }
    });
    $company_trades.hide();
});
