$(document).ready(function() {

	/*-------------------------------------------
	 Sticky Header
	 --------------------------------------------- */
//     var win = $(window);
//     var sticky_id = $("#sticky-header-with-topbar");
//     win.on('scroll',function() {
//         var scroll = win.scrollTop();
//         if (scroll < 245) {
//             sticky_id.removeClass("scroll-header");
//         }else{
//             sticky_id.addClass("scroll-header");
//         }
//     });
//
    $(document.body).on('click', '.add-to-cart', function (event) {
        button = $(this);
        size = $('#p_size option:selected').val();
        if(button.hasClass('one-size') || size != 0){
            $.ajax({
                method: 'get',
                url: '/cart/add',
                dataType: 'json',
                data: {
                    id: button.data('id'),
                    size: size,
                },
            }).done(function( data ) {
                add_to_cart_animation(button, data);
            });
		} else {
			$('.size-form').addClass('has-error');
		}
    });

    $(document.body).on('click', '.size-options', function (event) {
        size = $('#p_size option:selected').text();
        if(size.length > 0) {
            $('.size-form.has-error').removeClass('has-error');
        }
    });
//
//     $(document.body).on('click', '.product_wishlist', function () {
//         var w = $('.wishlist-login');
//         var e = $(this);
//         if(w.length > 0){
//             w.removeClass('hide');
//             return false;
//         } else {
//             updateWishlist(e);
//         }
//     });
//
//     $(document.body).on('click', '.catalog_wishlist', function () {
//     	var e = $(this);
//         updateWishlist(e);
//     });
//
//     $(document.body).on('submit', '#order-form', function (e) {
//         if ("ga" in window) {
//             tracker = ga.getAll()[0];
//             if (tracker)
//                 tracker.send("event", "button", "send_order");
//         }
//         yaCounter48289898.reachGoal('ORDER');
//     });
//
//     $(document.body).on('click', '.add-to-cart', function (e) {
//         if ("ga" in window) {
//             tracker = ga.getAll()[0];
//             if (tracker)
//                 tracker.send("event", "button", "add_to_cart");
//         }
//         yaCounter48289898.reachGoal('ADD_TO_CART');
//     });
//
//     $(document.body).on('mouseover', '.order-discount .fa-question-circle', function (e) {
//         $(".prices-popup").removeClass("hide");
//     });
//
//     $(document.body).on('mouseout', '.order-discount .fa-question-circle', function (e) {
//         $(".prices-popup").addClass("hide");
//     });
//
//     // aweProductRender(true);

    $(document.body).on('change', '#order-shipping_method' ,function(){
        $('.shipping_methods').children().each(function(){
        	$(this).hide();
        	$('#order-zip').val(null);
            $('#amount_total').text($('#amount_subtotal').text());
		});
        method = $(this).children("option:selected").val();
        if(method == 'self'){
            $('.payment_method_card2').hide();
            // $('.payment_method_cash').show();
            $('.payment_method_card').show();
            // $('#payment_method_cash').prop("checked", true);
            $('.payment_box.payment_method_card').hide();
        } else if(method == 'courier'){
            // $('.payment_method_cash').hide();
            $('.payment_method_card').show();
            $('.payment_method_card2').show();
            $('#payment_method_card2').prop("checked", true);
            $('.payment_box.payment_method_card').hide();
        } else {
            $('.payment_method_card2').hide();
            $('.payment_method_card').show();
            // $('.payment_method_cash').hide();
            $('#payment_method_card').prop("checked", true);
            $('.payment_box.payment_method_card').show();
        }

        if(method == 'self'){
            $('.shipping_methods .courier').hide();
            $('tr.shipping > td > .shipping-cost').html('0<i class="fa fa-ruble"></i>');
            $('.amount.total span').text($('.amount.subtotal span').text());
            $('#order-shipping_cost').val(0);
        } else if(method == 'courier'){
			$('.shipping_methods .courier').show();
			if($('#promo_is_active').val() == 1){
                $('tr.shipping > td > .shipping-cost').html('0<i class="fa fa-ruble"></i>');
                $('.amount.total span').text(parseInt($('.amount.subtotal span').text()));
                $('#order-shipping_cost').val(0);
            } else {
                $.ajax({
                    method: 'get',
                    url: '/cart/get_courier_cost',
                    data: {
                        type: $('#order-shipping_area').children("option:selected").val(),
                    },
                }).done(function (data) {
                    $('tr.shipping > td > .shipping-cost').html(data + '<i class="fa fa-ruble"></i>');
                    $('.amount.total span').text(parseInt($('.amount.subtotal span').text()) + parseInt(data));
                    $('#order-shipping_cost').val(data);
                });
            }
		} else if(method == 'rp'){
			$('.shipping_methods .rp').show();
            $.ajax({
                method: 'get',
                url: '/cart/get_rp_shipping_cost',
            }).done(function( data ) {
                $('tr.shipping > td > .shipping-cost').html(data + '<i class="fa fa-ruble"></i>');
                $('.amount.total span').text(parseInt($('.amount.subtotal span').text()) + parseInt(data));
                $('#order-shipping_cost').val(data);
            });
		} else if(method == 'tk'){
            $('.shipping_methods .tk').show();
            $.ajax({
                method: 'get',
                url: '/cart/get_tk_shipping_cost',
            }).done(function( data ) {
                $('tr.shipping > td > .shipping-cost').html(data + '<i class="fa fa-ruble"></i>');
                $('.amount.total span').text(parseInt($('.amount.subtotal span').text()) + parseInt(data));
                $('#order-shipping_cost').val(data);
            });
		}
    });

    $(document.body).on('change', '#order-shipping_area' ,function() {
        $.ajax({
            method: 'get',
            url: '/cart/get_courier_cost',
            data: {
                type: $(this).children("option:selected").val(),
                try: $('#order-is_try_on').prop('checked')
            },
        }).done(function( data ) {
            $('tr.shipping > td > .shipping-cost').html(data + '<i class="fa fa-ruble"></i>');
            $('.amount.total span').text(parseInt($('.amount.subtotal span').text()) + parseInt(data));
            $('#order-shipping_cost').val(data);
        });
    });

    $(document.body).on('change', '#order-is_try_on' ,function() {
        console.log($(this).prop('checked'));
        $.ajax({
            method: 'get',
            url: '/cart/get_courier_cost',
            data: {
                type: $('#order-shipping_area').children("option:selected").val(),
                try: $(this).prop('checked')
            },
        }).done(function( data ) {
            $('tr.shipping > td > .shipping-cost').html(data + '<i class="fa fa-ruble"></i>');
            $('.amount.total span').text(parseInt($('.amount.subtotal span').text()) + parseInt(data));
            $('#order-shipping_cost').val(data);
        });
    });

    //Change cart qty
    $(document.body).on('click', 'input.cart-qty' ,function(){
        if (checkProductCount($(this).parents('form'))) {
            qty = $(this).parent().find('.qty');
            if ($(this).hasClass('plus')) {
                qty.val(parseInt(qty.val()) + 1);
                updateCartQty($(this));
            } else if ($(this).hasClass('minus')) {
                if (qty.val() > 1) {
                    qty.val(parseInt(qty.val()) - 1);
                    updateCartQty($(this));
                }
            }
        }
    });

    $(document.body).on('click', '#header-remove_cart_item' ,function(){
        e = $(this).parents('.nav-cart-item');
        $.ajax({
            method: 'get',
            url: '/cart/remove',
            dataType: 'json',
            data: {
                id: $(this).data('id'),
				action: 'main',
            },
        }).done(function( data ) {
            if(data.cartCount > 0){
				e.hide('slow');
				$('.total-price span').text(data.cartTotal);
                $('.menu-cart-amount span').text(data.cartTotal);
                $('.nav-cart-icon').text(data.cartCount);
			} else {
                $("#header-cart").html(data.cart);
			}
            $("#header-mobile-cart").html(data.mobileCart);
        });
    });

    $(document.body).on('click', '#remove_cart_item' ,function(){
        e = $(this).parents('.cart_item');
        $.ajax({
            method: 'get',
            url: '/cart/remove',
            dataType: 'json',
            data: {
                id: $(this).data('id'),
                action: 'cart',
            },
        }).done(function( data ) {
            e.hide('slow');
            $("#header-cart").html(data.cart);
            $("#header-mobile-cart").html(data.mobileCart);
            $("#cart-total").html(data.cartTotal);
        });
    });

    $(document.body).on('click', '.promo_check_button', function (event) {
        $('#promo_is_active').val(0);
        button = $(this);
        promo = $('#order-promo').val();
        if(!promo){
            $('.field-order-promo').addClass('has-error');
            $('.field-order-promo .help-block-error').text('Введите промокод');
        } else {
            $.ajax({
                method: 'get',
                url: '/cart/check_promo',
                dataType: 'json',
                data: {
                    promo: promo,
                },
            }).done(function (data) {
                if(data.type == 'error'){
                    $('.field-order-promo').addClass('has-error');
                    $('.field-order-promo .help-block-error').text(data.message);
                } else if(data.type == 'success'){
                    $('.field-order-promo').removeClass('has-error');
                    $('.field-order-promo .help-block-error').text(data.message);
                    method = $('#order-shipping_method').children("option:selected").val();
                    $('#promo_is_active').val(1);
                    if(method == 'courier') {
                        $('tr.shipping > td > .shipping-cost').html('0<i class="fa fa-ruble"></i>');
                        $('.amount.total span').text($('.amount.subtotal span').text());
                        $('#order-shipping_cost').val(0);
                    }
                }
            });
        }
    });

//     $(".mobile-filter").on("click", function() {
//         i = $(this).find('i');
//         console.log(i);
//     	if(i.hasClass('fa-angle-down')){
//             $('.mobile-filter-field').each(function(){
// 				$(this).show();
// 				i.removeClass('fa-angle-down').addClass('fa-angle-up');
//             });
// 		} else {
//             $('.mobile-filter-field').each(function(){
//                 $(this).hide();
//                 i.removeClass('fa-angle-up').addClass('fa-angle-down');
//             });
// 		}
//     });
//
//     $(".noo-list").on("click", function() {
//     	if(!$(this).hasClass('active')){
//             $(this).addClass('active');
//             $('.noo-grid').removeClass('active');
//     		$('.products.row').addClass('product-list').removeClass('product-grid');
// 		}
//     });
//     $(".noo-grid").on("click", function() {
//         if(!$(this).hasClass('active')){
//             $(this).addClass('active');
//             $('.noo-list').removeClass('active');
//             $('.products.row').addClass('product-grid').removeClass('product-list');
//         }
//     });
//
//     // userFeed.run();
//     $(".noo-search").on("click", function() {
//         $(".search-header5").fadeIn(1).addClass("search-header-eff");
//         $(".search-header5").find('input[type="search"]').val("").attr("placeholder", "").select();
//         return false;
//     });
//     $(".remove-form").on("click", function() {
//         $(".search-header5").fadeOut(1).removeClass("search-header-eff");
//     });
//     $(".button-menu-extend").on("click", function() {
//         $(".noo-menu-extend-overlay").fadeIn(1, function() {
//             $(".noo-menu-extend").addClass("show");
//         }).addClass("show");
//         return false;
//     });
//     $(".menu-closed, .noo-menu-extend-overlay").on("click", function() {
//         $(".noo-menu-extend-overlay").removeClass("show").hide();
//         $(".noo-menu-extend").removeClass("show");
//     });
//     if ($("body").hasClass("fixed_top")) {
//         $(window).scroll(function() {
//             var $resTopbar = 0;
//             if ($(".noo-topbar").length > 0) {
//                 var $heightTopbar = $(".noo-topbar").height();
//                 $resTopbar = "-" + $heightTopbar + "px";
//             }
//             var $heightBar = $("header").height();
//             if ($(".header-5").length > 0) {
//                 if ($(window).width() < 992) {
//                     $resTopbar = "144px";
//                 } else {
//                     $heightBar = 200;
//                 }
//             }
//             var $top = $(window).scrollTop();
//             if ($top <= $heightBar) {
//                 if ($("header").hasClass("eff")) {
//                     if ($(".header-6").length > 0) {
//                         $("header").css("marginTop", "25px").removeClass("eff");
//                     } else {
//                         $("header").css("marginTop", 0).removeClass("eff");
//                     }
//                 }
//             } else {
//                 if (!$("header").hasClass("eff")) {
//                     $("header").css("marginTop", "-150px").animate({
//                         marginTop: $resTopbar
//                     }, 700);
//                     $("header").addClass("eff");
//                 }
//             }
//         });
//     }
//     resize_window();
//     $(window).resize(function() {
//         resize_window();
//     });
//     function resize_window() {
//         if ($(".header-1").length > 0) {
//             if ($(window).width() < 1500) {
//                 if ($("header").find(".noo-menu-option").find("li").length > 0) $("header").find(".noo-menu-option").addClass("collapse");
//             } else {
//                 $("header").find(".noo-menu-option").removeClass("collapse");
//             }
//         }
//         if ($(".header-3").length > 0) {
//             if ($(window).width() < 1300) {
//                 if ($("header").find(".noo-menu-option").find("li").length > 0) $("header").find(".noo-menu-option").addClass("collapse");
//             } else {
//                 $("header").find(".noo-menu-option").removeClass("collapse");
//             }
//         }
//     }
//     $("#off-canvas-nav li.menu-item-has-children").append('<i class="fa fa-angle-down"></i>');
//     $("#off-canvas-nav li.menu-item-has-children i").on("click", function(e) {
//         var link_i = $(this);
//         link_i.prev().slideToggle(300);
//         link_i.parent().toggleClass("active");
//     });
//     if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
//         $(".navbar-nav").find(".menu-item-has-children").find("a").on("touchstart", function(e) {
//             "use strict";
//             var link = $(this);
//             if (link.hasClass("hover")) {
//                 return true;
//             } else {
//                 link.addClass("hover");
//                 $(".navbar-nav").find(".menu-item-has-children").find("a").not(this).removeClass("hover");
//                 e.preventDefault();
//                 return false;
//             }
//         });
//     }
// 	//Countdown Timer
// 	if($('.defaultCountdown').length > 0) {
// 		var austDay = new Date(2016, 03 - 1,  31);
// 		$('.defaultCountdown').countdown({until: austDay});
// 		$('#year').text(austDay.getFullYear());
// 	}
// 	if($('.noo_custom_countdown').length > 0) {
// 		var austDay = new Date(2016, 03 - 1,  21);
// 		$('.noo_custom_countdown').countdown({until: austDay});
// 		$('#year').text(austDay.getFullYear());
// 	}
//
// 	//Owl Carousel
// 	$('.noo-product-sliders').owlCarousel({
// 		items : 4,
// 		itemsDesktop : [1199,4],
// 		itemsDesktopSmall : [991,2],
// 		itemsTablet: [768, 2],
// 		slideSpeed:500,
// 		paginationSpeed:800,
// 		rewindSpeed:1000,
// 		autoHeight: false,
// 		addClassActive: true,
// 		autoPlay: false,
// 		loop:true,
// 		pagination: false,
//         navigation:true,
//         navigationText: [
//             "<i class='fa fa-chevron-left'></i>",
//             "<i class='fa fa-chevron-right'></i>"
//         ],
//         dots: true,
// 	});
//
// 	//Owl Carousel
// 	$('.blog-slider').owlCarousel({
// 		items : 1,
// 		singleItem: true,
// 	});
//
// 	$('.noo-slider-image').owlCarousel({
// 		items : 3,
// 		itemsDesktop : [1199,3],
// 		itemsDesktopSmall : [991,2],
// 		itemsTablet: [768, 1],
// 		slideSpeed:500,
// 		paginationSpeed:800,
// 		rewindSpeed:1000,
// 		autoHeight: true,
// 		addClassActive: true,
// 		autoPlay: true,
// 		loop:true,
// 		pagination: false
// 	});
//
//     $('.noo-simple-product-slider').owlCarousel({
// 		items : 5,
// 		itemsDesktop : [1199,5],
// 		itemsDesktopSmall : [979,3],
// 		itemsTablet: [768, 2],
// 		slideSpeed:500,
// 		paginationSpeed:800,
// 		rewindSpeed:1000,
// 		autoHeight: true,
// 		addClassActive: true,
// 		autoPlay: false,
// 		loop:true,
// 		pagination: false,
//         navigation:true,
//         navigationText: [
//             "<i class='fa fa-chevron-left'></i>",
//             "<i class='fa fa-chevron-right'></i>"
//         ],
//         dots: true,
//
//     });
//
// 	//Testimonial Carousel
// 	var sync1 = $(".noo-testimonial-sync2");
// 	var sync2 = $(".noo-testimonial-sync1");
//
// 	sync1.owlCarousel({
// 		singleItem : true,
// 		slideSpeed : 1000,
// 		navigation: false,
// 		pagination:false,
// 		afterAction : syncPosition,
// 		responsiveRefreshRate : 200
// 	});
//
// 	function syncPosition(el){
// 		var current = this.currentItem;
// 		$(".noo-testimonial-sync1")
// 			.find(".owl-item")
// 			.removeClass("synced")
// 			.eq(current)
// 			.addClass("synced")
// 		if($(".noo-testimonial-sync1").data("owlCarousel") !== undefined){
// 			center(current)
// 		}
// 	}
//
// 	$(".noo-testimonial-sync1").on("click", ".owl-item", function(e){
// 		e.preventDefault();
// 		var number = $(this).data("owlItem");
// 		sync1.trigger("owl.goTo",number);
// 	});
//
// 	sync2.owlCarousel({
// 		items : 3,
// 		itemsDesktop      : [1199,3],
// 		itemsDesktopSmall     : [979,3],
// 		itemsTablet       : [768,3],
// 		itemsMobile       : [479,2],
// 		pagination:false,
// 		responsiveRefreshRate : 100,
// 		afterInit : function(el){
// 			el.find(".owl-item").eq(1).click();
// 		}
// 	});
//
// 	function center(number){
// 		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
// 		var num = number;
// 		var found = false;
// 		for(var i in sync2visible){
// 			if(num === sync2visible[i]){
// 				var found = true;
// 			}
// 		}
//
// 		if(found===false){
// 			if(num>sync2visible[sync2visible.length-1]){
// 				sync2.trigger("owl.goTo", num - sync2visible.length+2)
// 			}else{
// 				if(num - 1 === -1){
// 					num = 0;
// 				}
// 				sync2.trigger("owl.goTo", num);
// 			}
// 		} else if(num === sync2visible[sync2visible.length-1]){
// 			sync2.trigger("owl.goTo", sync2visible[1])
// 		} else if(num === sync2visible[0]){
// 			sync2.trigger("owl.goTo", num-1)
// 		}
// 	}
//
// 	$('.noo_testimonial').each(function(){
// 		$(this).owlCarousel({
// 			items : 1,
// 			itemsDesktop : [1199,1],
// 			itemsDesktopSmall : [979,1],
// 			itemsTablet: [768, 1],
// 			slideSpeed:500,
// 			paginationSpeed:800,
// 			rewindSpeed:1000,
// 			autoHeight: false,
// 			addClassActive: true,
// 			autoPlay: true,
// 			loop:true,
// 			pagination: true,
// 			afterInit : function(el){
// 				el.find(".owl-item").eq(1).addClass("synced");
// 			}
// 		});
// 	});
//
// 	//Ajax popup
// 	if($(".noo-qucik-view").length > 0) {
// 		$('.noo-qucik-view').magnificPopup({
// 			type: 'ajax'
// 		});
// 	}
//
// 	//Boxes hover
// 	$('.box-inner').each(function(){
// 		var first_color = $(this).find('.product-box-header li:first-child span').data('color');
// 		$(this).find('.product-box-header li:first-child span').css('background',first_color).addClass('acitve');
// 		$(this).find('.box-content h3').css('color',first_color);
// 		$(this).find('.box-description-tab').css('background-color',first_color);
// 	});
//
// 	$('.product-box-header li span').mousemove(function(){
// 		var $parent = $(this).closest('.box-inner');
// 		$parent.find('.product-box-header li span').removeAttr('style').removeClass('acitve');
// 		var color   = $(this).data('color');
// 		var id      = $(this).data('id');
// 		$(this).css('background',color).addClass('acitve');
// 		$parent.find('.box-content-tab').hide();
// 		$parent.find(id).show();
// 	});
//
// 	//Boxes Detail Slider
// 	$(".sync1").owlCarousel({
// 		singleItem : true,
// 		slideSpeed : 1000,
// 		navigation: false,
// 		pagination:false,
// 		autoHeight : true,
// 		responsiveRefreshRate : 200
// 	});
//
// 	$(".sync2").owlCarousel({
// 		items : 4,
// 		itemsDesktop      : [1199,4],
// 		itemsDesktopSmall : [979,4],
// 		itemsTablet       : [768,3],
// 		itemsMobile       : [479,2],
// 		pagination:false,
// 		responsiveRefreshRate : 100
// 	});
//
// 	$(".sync2").on("click", ".owl-item", function(e){
// 		e.preventDefault();
// 		var number = $(this).data("owlItem");
// 		$(".sync1").trigger("owl.goTo",number);
// 	});
//
// 	//Recent Post Background
// 	$('.widget_recent_entries .post_list_widget li').each(function(){
// 		var post_thumb = $(this).find(".post-thumb");
// 		post_thumb.css('background-image','url("' + post_thumb.attr("data-bg") + '")');
// 	});
//
// 	//Noo Simple Product Slider
// 	$('.noo-simple-product-slider li').each(function(){
// 		var slider_item = $(this).find(".noo-simple-slider-item");
// 		slider_item.css('background-image','url("' + slider_item.attr("data-bg") + '")');
// 	});
//
// 	//Init RevSlider
// 	if($('#rev_slider_1').length > 0) {
// 		revSlider_1();
// 	}
// 	if($('#rev_slider_2').length > 0) {
// 		revSlider_2();
// 	}
// 	if($('#rev_slider_3').length > 0) {
// 		revSlider_3();
// 	}
//
//     $(document.body).on('keyup', '#order-zip' ,function(){
//         if ($(this).val().length == 6) {
//             total = parseInt($('#amount_subtotal').text());
//             postcalc_url = 'http://test.postcalc.ru/mystat.php/';
//             postcode_from = '630001';
//             postcode_to = $(this).val();
//             weight = $('#order_weight').val() * 1000 * 1.1;
//             url = postcalc_url + '?f=' + postcode_from + '&t=' + postcode_to +'&w=' + weight +'&o=json';
//             $.ajax({
//                 url: url,
//                 type: "GET",
//                 dataType: 'jsonp',
//                 success: function (data) {
//                     if (data['Status'] == "OK") {
//                         tariff = parseInt(data['Отправления']['ЦеннаяПосылка']['Тариф']);
//                         shipping_cost = tariff + 30;
//                         new_total = total + shipping_cost;
//                         $('.shipping > td > p').html("<span id=\"amount_shipping\">" + shipping_cost.toFixed(0) + "</span><i class=\"fa fa-ruble\"></i>");
//                         $('#amount_total').html(new_total.toFixed(0));
//                         $("#order-shipping_cost").val(shipping_cost.toFixed(0));
//                     } else if(data['Status'] == "BAD_TO_INDEX"){
//                         $('.shipping > td > p').html("Стоимость не определена. Проверьте индекс и попробуйте снова");
//                         $('#amount_total').html(total);
//                         $("#order-shipping_cost").val(null);
//                     }
//                 }
//             })
//         }
//     });
});

function add_to_cart_animation(button, data){
        button.addClass('is-added').find('path').eq(0).animate({
            //draw the check icon
            'stroke-dashoffset':0
        }, 300, function(){
            setTimeout(function(){
            	$("#header-cart").html(data.cart);
            	$("#header-mobile-cart").html(data.mobileCart);
                button.removeClass('is-added').find('em').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
                    //wait for the end of the transition to reset the check icon
                    button.find('path').eq(0).css('stroke-dashoffset', '19.79');
                    animating =  false;
                });

                if( $('.no-csstransitions').length > 0 ) {
                    // check if browser doesn't support css transitions
                    addToCartBtn.find('path').eq(0).css('stroke-dashoffset', '19.79');
                    animating =  false;
                }
            }, 600);
        });
};

function revSlider_1(){
	$("#rev_slider_1").show().revolution({
	  sliderType:"standard",
	  sliderLayout:"fullscreen",
	  dottedOverlay:"none",
	  delay:9000,
	  navigation: {
		  keyboardNavigation:"off",
		  keyboard_direction: "horizontal",
		  mouseScrollNavigation:"off",
		  onHoverStop:"on",
		  touch:{
			  touchenabled:"on",
			  swipe_threshold: 75,
			  swipe_min_touches: 50,
			  swipe_direction: "horizontal",
			  drag_block_vertical: false
		  }
		  ,
		  bullets: {
			  enable:true,
			  hide_onmobile:true,
			  hide_under:600,
			  style:"ares",
			  hide_onleave:true,
			  hide_delay:200,
			  hide_delay_mobile:1200,
			  direction:"vertical",
			  h_align:"right",
			  v_align:"center",
			  h_offset:30,
			  v_offset:0,
			  space:5,
			  tmp:'<span class="tp-bullet-title">{{title}}</span>'
		  }
	  },
	  responsiveLevels:[1240,1024,778,480],
	  visibilityLevels:[1240,1024,778,480],
	  gridwidth:[1240,1024,778,480],
	  gridheight:[600,768,960,720],
	  lazyType:"none",
	  parallax: {
		  type:"mouse",
		  origo:"slidercenter",
		  speed:2000,
		  levels:[2,3,4,5,6,7,12,16,10,50,47,48,49,50,51,55],
		  type:"mouse",
	  },
	  shadow:0,
	  spinner:"off",
	  stopLoop:"on",
	  stopAfterLoops:2,
	  stopAtSlide:1,
	  shuffle:"off",
	  autoHeight:"off",
	  fullScreenAutoWidth:"off",
	  fullScreenAlignForce:"off",
	  fullScreenOffsetContainer: "",
	  fullScreenOffset: "",
	  hideThumbsOnMobile:"on",
	  hideSliderAtLimit:0,
	  hideCaptionAtLimit:0,
	  hideAllCaptionAtLilmit:0,
	  debugMode:false,
	  fallbacks: {
		  simplifyAll:"off",
		  nextSlideOnWindowFocus:"off",
		  disableFocusListener:false,
	  }
  });
}

function revSlider_2(){
	$("#rev_slider_2").show().revolution({
		sliderType:"standard",
		sliderLayout:"fullscreen",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			keyboardNavigation:"off",
			keyboard_direction: "horizontal",
			mouseScrollNavigation:"off",
			onHoverStop:"off",
			arrows: {
				style:"hades",
				enable:true,
				hide_onmobile:false,
				hide_onleave:false,
				tmp:'<div class="tp-arr-allwrapper"><div class="tp-arr-imgholder"></div></div>',
				left: {
					h_align:"left",
					v_align:"center",
					h_offset:20,
					v_offset:0
				},
				right: {
					h_align:"right",
					v_align:"center",
					h_offset:20,
					v_offset:0
				}
			}
		},
		visibilityLevels:[1240,1024,778,480],
		gridwidth:1240,
		gridheight:868,
		lazyType:"none",
		shadow:0,
		spinner:"spinner0",
		stopLoop:"on",
		stopAfterLoops:1,
		stopAtSlide:0,
		shuffle:"off",
		autoHeight:"off",
		fullScreenAutoWidth:"off",
		fullScreenAlignForce:"off",
		fullScreenOffsetContainer: "",
		fullScreenOffset: "",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
  });
}

function revSlider_3(){
	$("#rev_slider_3").show().revolution({
		sliderType:"standard",
		sliderLayout:"fullscreen",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			keyboardNavigation:"off",
			keyboard_direction: "horizontal",
			mouseScrollNavigation:"off",
			onHoverStop:"on",
			arrows: {
				style:"zeus",
				enable:true,
				hide_onmobile:false,
				hide_onleave:false,
				tmp:'<div class="tp-title-wrap">  	<div class="tp-arr-imgholder"></div> </div>',
				left: {
					h_align:"left",
					v_align:"center",
					h_offset:20,
					v_offset:0
				},
				right: {
					h_align:"right",
					v_align:"center",
					h_offset:20,
					v_offset:0
				}
			}
		},
		visibilityLevels:[1240,1024,778,480],
		gridwidth:1240,
		gridheight:868,
		lazyType:"none",
		shadow:0,
		spinner:"spinner0",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		fullScreenAutoWidth:"off",
		fullScreenAlignForce:"off",
		fullScreenOffsetContainer: "",
		fullScreenOffset: "",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
  });
}

$(window).on('load', function(){
    $(".noo-page-heading").addClass("eff");
    $(".page-title").addClass("eff");
    $(".noo-page-breadcrumb").addClass("eff");
    $(".noo-spinner").remove();
});

function aweProductRender(thumbHorizontal) {

    var sMain = new Swiper('.product-slider-main', {
        loop: false,

        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    });

    var sThumb = new Swiper('.product-slider-thumbs', {
        loop: false,
        centeredSlides: true,
        spaceBetween: thumbHorizontal ? 15 : 0,
        slidesPerView: thumbHorizontal ? 4 : 3,
        direction: thumbHorizontal ? 'horizontal' : 'vertical',
        slideToClickedSlide: true
    });

    sMain.params.control = sThumb;
    sThumb.params.control = sMain;
}

function updateCartQty(b) {
	var form = b.parents('form');
	var e = form.find('input.qty');
	var id = form.find('input[name=id]').val();
	$.ajax({
	   method: 'get',
	   url: '/cart/update_cart_qty',
	   dataType: 'json',
	   data: $(form).serialize(),
	}).done(function( data ) {
		$('#amount_val_'+id).text(data.productTotal);
        $("#header-cart").html(data.cart);
        $("#header-mobile-cart").html(data.mobileCart);
        $("#cart-total").html(data.cartTotal);
	});

}

function checkProductCount(form) {
    var count = form.find("input[name='count']").val();
    var qty = form.find("input[name='quantity']");
    if(parseInt(qty.val()) > count){
        qty.val(count);
        form.find('.count-error').show();
        return false;
    } else {
        form.find('.count-error').hide();
        return true;
    }
}

function updateWishlist(e) {
    $.ajax({
        method: 'get',
        url: '/wishlist/update',
        dataType: 'json',
        data: {
            id: e.attr('id'),
        },
    }).done(function( data ) {
        p = e.parents('.yith-wcwl-add-to-wishlist');
        if(p.hasClass('active'))
            p.removeClass('active')
        else
            p.addClass('active');
    });
}