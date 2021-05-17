;(function ($) {
    $('#a05_cf_id').submit(function (e) {
        e.preventDefault();
        let data = $(this).serialize();

        $.post(a05_cf.ajaxurl, data, function (response) {
            if (response.success === true) {
                alert(response.data.message);
            } else {
                alert(response.data.message);
            }
        }).fail(function (error) {
            console.log(error);
            alert(a05_cf.error_msg);
        })
    })
})(jQuery);