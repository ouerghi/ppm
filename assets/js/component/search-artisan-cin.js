

$(document).ready(function () {
    function empty(data)
    {
        if(typeof(data) === 'undefined' || data === null)
        {
            return true;
        }
        if(typeof(data.length) !== 'undefined')
        {
            return data.length === 0;
        }
        let count = 0;
        for(let i in data)
        {
            if(data.hasOwnProperty(i))
            {
                count ++;
            }
        }
        return count === 0;
    }
    let cin = $("#artisan_cin");
    let loader = $('#loader_cin');
    loader.hide();

    cin.keyup(function () {
        let input = $(this).val();
        let url =  Routing.generate('search_cin');
        let content = $('#content_search_cin');
        loader.show();
          if (input.length >= 4 ) {
            let data = {input : input};
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                timeout: 3000,
                success: function (response) {
                    if (!empty(response))
                    {
                        content.html(response.listCin);
                        loader.hide();
                    }
                    else{
                        content.html('');
                        loader.show();
                    }
                    },
                error: function () {
                    content.text('problem with request');
                }
            })
        }else{
              content.text('');
        }
    })
});