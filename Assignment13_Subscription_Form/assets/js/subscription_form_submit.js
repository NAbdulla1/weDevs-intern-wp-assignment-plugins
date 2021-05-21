;(function () {

    function startLoading(status, loading_img) {
        status.append(loading_img);
        status.css('display', 'block');
    }

    function stopLoading(status, loading_img) {
        status.remove(loading_img);
        status.css('display', 'none');
    }

    function animateMessage(status, body) {
        let bgColor = status.css('background-color');
        if (!body.success) status.css('background-color', 'red');
        else status.css('background-color', 'green');

        status.text(body.data.message);
        status.fadeIn(1000, function () {
            status.fadeOut(1000, function () {
                status.text("");
                status.css('display', 'none');
                status.css('background-color', bgColor);
            });
        });
    }

    $(document).ready(function () {
        let loading_img = document.createElement('img');
        loading_img.src = a13sfs.loading_img_src;
        loading_img.alt = 'loading indicator';

        $("#a13_sfw").submit(async function (e) {
            e.preventDefault();

            let status = $('#a13_sfw_status');
            let formData = new FormData(this);
            try {
                startLoading(status, loading_img);
                let resp = await fetch(a13sfs.submit_endpoint, {
                    method: 'post',
                    body: formData
                });
                let body = await resp.json();
                stopLoading(status, loading_img);

                animateMessage(status, body);
            } catch (e) {
                setTimeout(function () {
                        stopLoading(status, loading_img);
                        animateMessage(status, {success: false, data: {message: e.message}})
                    }, 500
                )
                ;
            }
        });
    });
})();