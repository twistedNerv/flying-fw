/*
//Example 
 
$(document).ready(function () {

    $("#[search-id]").on('keyup', delay(function () {
        search_string = $("#[search-id]").val();
        $.ajax({
            type: 'POST',
            url: URL + '[class]/[method]',
            data: ({search_string: search_string}),
            success: function (data) {
                $('#[list-place]').hide().html(data).fadeIn("slow");
            }
        });

    },500));

});

function delay(callback, ms) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}*/