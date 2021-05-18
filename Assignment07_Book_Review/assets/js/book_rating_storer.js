;(function () {
    $(document).ready(
        function () {
            let startsBox = $('div[data-rater-postid] > div').click(async function () {
                let width = startsBox[0].style['width'];
                width = parseInt(width.substr(0, width.indexOf('%')));
                let rating = width / 20;

                let url = book_review_info['ajaxUrl'];
                let formData = new FormData();

                formData.set('rating', rating.toString());
                formData.set('post_id', book_review_info['post_id']);
                formData.set('user_id', book_review_info['user_id']);
                formData.set('user_ip', book_review_info['user_ip']);
                formData.set('action', book_review_info['action']);
                formData.set('a07_r_nonce', book_review_info['a07_r_nonce']);

                try {
                    let response = await fetch(url, {
                        method: 'POST',
                        body: formData
                    });

                    let json = await response.json();
                    if (response.ok) {
                        if (json.success) {
                            alert(json.data.message);
                            //do something elese on success
                        } else {
                            alert(json.data.message);
                            //do something elese on failure
                        }
                    } else {
                        alert(json.data.message);
                        //do something elese on failure
                    }
                    console.log(json.data);
                } catch (e) {
                    console.log(e);
                }
            });
        });
})();

