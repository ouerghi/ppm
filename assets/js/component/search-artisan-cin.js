

$(document).ready(function () {
    let cin = $("#artisan_cin");
    let loader = $('#loader_cin');
    loader.hide();
    cin.keyup(function () {
        let input = $(this).val();
        let url =  Routing.generate('search_cin');
        if (input.length >= 4 ) {
            loader.show();
            let data = {input : input};
            console.log(input);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                timeout: 3000,
                success: function (response) {
                    console.log(response);
                    $.each(response, function(index) {
                        alert(response[index].id);
                        alert(response[index].cin);
                    });
                    loader.hide();
                }
            })
        }else{
            loader.hide();
        }
    })
});