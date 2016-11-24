if (!(typeof window['owox_buy_button'] == 'function')) {
	function owox_buy_button(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'click',
				'eventLabel': 'buyButton',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
		try {
			yaCounter20304250.reachGoal('IN_BASKET');
		} catch (err) {
		}
	}
}

if (!(typeof window['owox_tocart_button'] == 'function')) {
	function owox_tocart_button(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'click',
				'eventLabel': 'goToCart',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
	}
}

if (!(typeof window['owox_quantity_plus'] == 'function')) {
	function owox_quantity_plus(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'click',
				'eventLabel': 'QuantityPlus',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
		try {
			yaCounter20304250.reachGoal('IN_BASKET');
		} catch (err) {
		}
	}
}

if (!(typeof window['owox_quantity_minus'] == 'function')) {
	function owox_quantity_minus(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'click',
				'eventLabel': 'QuantityMinus',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
	}
}

if (!(typeof window['owox_wishlist_add'] == 'function')) {
	function owox_wishlist_add(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'add',
				'eventLabel': 'Wishlist',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
	}
}


if (!(typeof window['owox_wishlist_remove'] == 'function')) {
	function owox_wishlist_remove(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'remove',
				'eventLabel': 'Wishlist',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
	}
}

if (!(typeof window['owox_product_click'] == 'function')) {
	function owox_product_click(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'click',
				'eventLabel': 'Product',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
	}
}

if (!(typeof window['owox_checkout'] == 'function')) {
	function owox_checkout(link, pos_in_list, prf_name, cat_id, id, code, cat_name, vendor_id, price, promo) {
		try {
			dataLayer.push({
				'event': 'OWOX',
				'eventCategory': 'Interaction',
				'eventAction': 'click',
				'eventLabel': 'goToCart',
				'eventPosition': (parseInt(pos_in_list) + 1).toString(),
				'eventProductId': id,
				'eventProductGroupName': prf_name,
				'eventProductCategoryID': cat_id,
				'eventProductCategorySKU': code,
				'eventProductCategoryName': cat_name,
				'eventProductVendorID': vendor_id,
				'eventProductPromo': promo,
				'eventProductPriceLocal': price,
			})
			console.dir(dataLayer);
		} catch (err) {
		}
	}
}