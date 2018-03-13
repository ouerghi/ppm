'use strict';

// js file to import
import  $ from 'jquery';
global.$ = $;
import 'tether';
import Popper from 'popper.js';
global.Popper = Popper;
require('bootstrap');
import 'sweetalert';

// css file to import
import 'bootstrap/dist/css/bootstrap.css';
import 'font-awesome/css/font-awesome.css';
import '../css/login.css';



$( document ).ready(function() {
    console.log( "ready now ok dhuj" );
    $('#swal').click(function () {
        swal("Hello world!");
    })
});