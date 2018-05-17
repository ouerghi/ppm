
let $government = $('#setting_company_government');
let delegation =  $('#setting_company_delegation');
let tag = ('<div class="cssload-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before = $("label[for=setting_company_delegation]");

$before.before(tag);

let $loader = $('.cssload-container');

$loader.hide();

$government.change(function() {
    // ... retrieve the corresponding form.
    let $form = $(this).closest('form');
    delegation.empty();
    // Simulate form data, but only include the selected sport value.
    let data = {};
    data[$government.attr('name')] = $government.val();
    // Submit data via AJAX to the form's action path.
    let id = $government.val();
    let url =  Routing.generate('edit_gov', { id : id });
    console.log(url);
    $.ajax({
        url : url,
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
            $.each(data, function(i, item) {
                console.log(item);
                delegation.append(
                    ( "<option value='"+item.id +"'>" + item.name + "</option>" ),
                    $(data).find(delegation)
                );
            });
            $loader.hide();
        }

    });
    delegation.hide();
});

// dynamic select of page edit gov and activity

// script page add company
let $activity_company = $('#setting_company_activity');

let $company_trades = $('#setting_company_trades');

$company_trades.hide();

let tag_company = ('<div class="cssloadx-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before_company = $("label[for=setting_company_trades]");

$before_company.before(tag_company);

let $loader_company = $('.cssloadx-container');

$loader_company.hide();
// When activity gets selected ...
$activity_company.change(function () {
    $company_trades.empty();

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
                $company_trades.append(
                    ( "<option value='"+data[i].id +"'>" + data[i].name + "</option>" ),
                    $(data).find($company_trades)
                );
            });
            $loader_company.hide();
        }
    });
    $company_trades.hide();
});