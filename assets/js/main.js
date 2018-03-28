'use strict';

import $ from "jquery";
require('bootstrap');
const routes = require('../../public/js/fos_js_routes.json');
const Routing = require('./Routing');


$("document").ready(function () {
    /**
     * @param {int}id
     * @param {string}token
     */
    window.deleteArtisan = function (id,token) {

        // swal with alert before delete artisan
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this artisan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            // if confirm delete action send the parameters to the controller
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        // use JsRoutingBundle to generate the routes dynamic
                        url: Routing.generate('delete', {id: id, token:token}),
                        type: 'POST',
                        dataType: 'json',
                        //success function with reload after 2 seconds
                        success: function (response) {
                             swal({
                                title : 'Deleted!',
                                message : response.message,
                                 status : response.status,
                                 icon : response.status,
                                 closeOnClickOutside: false,
                                 timer: 1000
                             });
                            setTimeout(function(){
                                window.location.reload(1);
                            }, 2000);
                            console.log(response);
                        },
                        // error function
                        error: function (response) {
                            swal({
                                title : 'ERROR can please contact admin !',
                                message : response.message,
                                status : response.status,
                                icon : response.status,
                                closeOnClickOutside: false,
                            });
                        }
                    })
                    // $('#del').submit();
                } else {
                    swal("You canceled the operation to delete an artisan!");
                }
            });
    };

//    dismiss success alert after redirect "flashBag message" script
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });


});