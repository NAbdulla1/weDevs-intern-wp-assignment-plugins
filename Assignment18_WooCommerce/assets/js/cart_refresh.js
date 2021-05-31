; (async function () {
	let url = a18_wc_cart_ref.cart_url;//url from localization object
	let resp = await fetch(url);//send request to server for latest cart information
	if (!resp.ok) return;
	let data = await resp.json();

	//update cart
	let cart_view = document.getElementsByClassName('cart-contents')[0];
	cart_view.children[0].textContent = `${data.totals.currency_prefix}${(data.totals.total_items / 100.0).toFixed(2)}`;
	cart_view.children[1].textContent = `${data.items_count} items`;
})();