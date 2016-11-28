$(function(){

	// Spinbox func
	$(document).on('click', '.spinbox a.minus', function (e) {
		 e.preventDefault ();

		 var ths = $(this),
		 parent = ths.closest('.spinbox'),
		 input = parent.find('input[type="text"]'),
		 v = parseInt(input.val());
		 var pid=input.attr("data-id");

		 if (v>1) { v--; input.val(v); }

		var data_to_send = "product_id="+ pid + "&quantity=" + v;
		$.ajax({
            type: "POST",
            url: "/include/recalculate_cart.php?action=update_product",
            data: data_to_send
        }).done(function (response) {
            if (response) $('.__cart-count').text(response).removeClass('hidden').show();
			$.get("/personal/cart/", "", function (result) {
				var rblock=$(result).find(".sec-cart__info.right").html();
				$(document).find(".sec-cart__info.right").html(rblock);
			});			
        });

		 if (v>=2) {
		 ths.removeClass('disabled');
		 } else {
		 ths.addClass('disabled');
		 }
	 });

	 $(document).on('click', '.spinbox a.plus', function (e) {
		 e.preventDefault ();

		 var ths = $(this),
		 parent = ths.closest('.spinbox'),
		 minus = parent.find('a.minus'),
		 input = parent.find('input[type="text"]'),
		 v = parseInt(input.val());
		 var mq = parseInt(input.attr("max"));

		 if(v >= mq)
         {
             wsPoperValid.init([
                 input, 'Выбрано максимальное количество'
             ]);

             setTimeout(function () {wsPoperValid.removePoper(input)}, 2000);
         }

		 var pid=input.attr("data-id"); 

		 v++; 
		 
		 v = v > (input.attr('max')) ? (input.attr('max')) : v;
		
		 input.val(v);

		 if (v>=2) {
		 minus.removeClass('disabled');
		 } else {
		 minus.addClass('disabled');
		 }
		 
		var data_to_send = "product_id="+ pid + "&quantity=" + v;
		$.ajax({
            type: "POST",
            url: "/include/recalculate_cart.php?action=update_product",
            data: data_to_send
        }).done(function (response) {
            if (response) $('.__cart-count').text(response).removeClass('hidden').show();
			$.get("/personal/cart/", "", function (result) {
				var rblock=$(result).find(".sec-cart__info.right").html();
				$(document).find(".sec-cart__info.right").html(rblock);
			});
        });
		 
	 });
	 
	 $(document).on('click', '.cart-item-close-button', function (e) {
		 var pid=$(this).attr("data-id");
		 
		 var data_to_send = "product_id="+pid;
		
        $.ajax({
            type: "POST",
            url: "/include/recalculate_cart.php?action=delete_product", 
            data: data_to_send
        }).done(function (response) {
            if (response || response == 0) $('.__cart-count').text(response).show();
			$.get("/personal/cart/", "", function (result) {
				var rblock=$(result).find(".sec-cart__info.right").html();
				$(document).find(".sec-cart__info.right").html(rblock);
			});
        });
		
		 $(this).parents("li").remove();
	 });
});