;(function () {
    $(document).ready(function () {
        $("#a13_sfw").submit(async function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            try {
                let resp = await fetch(a13sfs.submit_endpoint, {
                    method: 'post',
                    body: formData
                });
                let body = await resp.json();

                let status = $('#a13_sfw_status');
                console.log(body.success);
                status.text(body.data.message);
                status.css('display', 'block');
                if (!body.success) status.css('background-color', 'red');
                else status.css('background-color', 'green');
                setTimeout(function () {
                    status.text("");
                    status.css('display', 'none');
                }, 2000);
            } catch (e) {
                console.log('Error:', e.message);
            }
        });
    });
})();