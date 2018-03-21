'use strict';



$("document").ready(function () {
    console.log('main page');
    let confirmed = false;
    $("#deleteArtisan").on('click', function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this artisan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $('#del').submit();
                } else {
                    swal("You canceled the operation to delete an artisan!");
                }
            });
    });
});