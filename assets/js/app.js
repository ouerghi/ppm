'use strict';
// css file to import
import 'bootstrap/dist/css/bootstrap.css';
import 'font-awesome/css/font-awesome.css';

import '../css/login.css';
import  '../css/style.css'
import '../css/stylex.css';

// js file to import
import  $ from 'jquery';
global.$ = $;

import 'tether';
import Popper from 'popper.js';
global.Popper = Popper;
require('bootstrap');
import '../js/jquery.slimscroll'
import '../js/dropdown-bootstrap-extended'
import 'switchery'
import 'sweetalert';
import '../js/jasny-bootstrap'
import '../js/validator.min'
import '../js/select2.full.min'
import  '../js/bootstrap-select.min'
import '../js/init'





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
// When sport gets selected ...
$activity.change(function () {
    $('#artisan_trades').empty();

    // ... retrieve the corresponding form.
    let $form = $(this).closest('form');
    // Simulate form data, but only include the selected sport value.
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


