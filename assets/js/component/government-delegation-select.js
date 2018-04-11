
let $government = $('#edit_government_artisan_government');
let delegation =  $('#edit_government_artisan_delegation');
let tag = ('<div class="cssload-container">\n' +
    '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
    '</div>');
let $before = $("label[for=edit_government_artisan_delegation]");

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