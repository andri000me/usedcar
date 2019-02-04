/* Add Custom Code Jquery
 ========================================================*/
$(document).ready(function(){
	// Fix hover on IOS
	$('body').bind('touchstart', function() {}); 
	



	jQuery(function(){
		$(window).load(function() {
			var windowswidth = $(window).width();
			var containerwidth = $('.container').width();
			var widthcss = 70;
			var hei = 142;
			var rtl = jQuery( 'body' ).hasClass( 'rtl' );
			//if( !rtl ) {
				jQuery(".fixed-left").css("left",widthcss);
			//}else{
				//jQuery(".fixed-left").css("right",widthcss);
			//}
			var navScroll = $(".fixed-left > div");
			
			//if (navScroll.length > 0) {
				//$(".custom-scoll").fadeOut();
				jQuery(".fixed-left").css("top",hei);
				jQuery(".fixed-left").css("position","fixed");

				$(window).scroll(function() {
					if( $(window).scrollTop() > 142  ) {
						//$(".custom-scoll").fadeIn();
						
						jQuery(".fixed-left").css("top",30);
				
					} 
					else {
						//$(".custom-scoll").fadeOut();
						jQuery(".fixed-left").css("top",142);
	
					}
			
				});

	        //}
	    })
	});
	jQuery(function(){
		$(window).load(function() {
			var widthcss = 70;
			var hei = 142;
			var rtl = jQuery( 'body' ).hasClass( 'rtl' );
			//if( !rtl ) {
				jQuery(".fixed-right").css("right",widthcss);
			// }else{
			//	jQuery(".fixed-right").css("left",widthcss);
			// }
			
			//if (navScroll.length > 0) {
				//$(".custom-scoll").fadeOut();
				jQuery(".fixed-right").css("top",hei);
				jQuery(".fixed-right").css("position","fixed");

				$(window).scroll(function() {
					if( $(window).scrollTop() > 142  ) {
						
						jQuery(".fixed-right").css("top",30);
				
					} 
					else {
						//$(".custom-scoll").fadeOut();
						jQuery(".fixed-right").css("top",142);
	
					}
			
				});

	        //}
	    })
	});

	jQuery(function(){
		$(window).load(function() {
			var windowswidth = $(window).width();
			var containerwidth = $('.main-container').width();
			var widthcss = (windowswidth-containerwidth)/2 + 15;
			
			var rtl = jQuery( 'body' ).hasClass( 'rtl' );
			if( !rtl ) {
				jQuery(".left-fixed").css("left",widthcss);
				jQuery(".right-fixed").css("right",widthcss);
			}else{
				jQuery(".left-fixed").css("right",widthcss);
				jQuery(".right-fixed").css("left",widthcss);
			}
			
	    })
	});


// FB like index 3
	(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

	
	// Messenger Top Link
	$('.list-msg').owlCarousel2({
		pagination: false,
		center: false,
		nav: false,
		dots: false,
		loop: true,
		slideBy: 1,
		autoplay: true,
		margin: 30,
		autoplayTimeout: 4500,
		autoplayHoverPause: true,
		autoplaySpeed: 1200,
		startPosition: 0, 
		responsive:{
			0:{
				items:1
			},
			480:{
				items:1
			},
			768:{
				items:1
			},
			1200:{
				items:1
			}
		}
	});






	// Close pop up countdown
	 $( "#so_popup_countdown .customer a" ).click(function() {
	  $('body').toggleClass('hidden-popup-countdown');
	 });
	// =========================================


	// click header search header 
	jQuery(document).ready(function($){
		$( ".search-header-w .icon-search" ).click(function() {
		$('#sosearchpro .search').slideToggle(200);
		$(this).toggleClass('active');
		});
	});

	// add class Box categories
	jQuery(document).ready(function($){

		if($("#accordion-category .panel .panel-collapse").hasClass("in")){
			$('#accordion-category .panel .accordion-toggle').addClass("show");			
		} 
		else{
			$('#accordion-category .panel .accordion-toggle').removeClass("show");
		}

	});

	// slider categories
	jQuery(document).ready(function($) {
	    var slidercate = $(".layout-2 .so-categories.custom-slidercates .cat-wrap");
	    slidercate.owlCarousel2({    
	    margin:30,
	    nav:true,
	    loop:true,
	    dots: false,
	    navText: ['',''],
	    responsive:{
	            0:{
	                items:1
	            },
	            480:{
	                items:2
	            },
	            768:{
	                items:3
	            },
	            992:{
	                items:4
	            },
	            1200:{
	                items:5
	            },
	        },
	    })
	});

	jQuery(document).ready(function($) {
	    var slidercate = $(".layout-3 .so-categories.custom-slidercates .cat-wrap");
	    slidercate.owlCarousel2({    
	    margin:30,
	    nav:true,
	    loop:true,
	    dots: false,
	    navText: ['',''],
	    responsive:{
	            0:{
	                items:1
	            },
	            480:{
	                items:2
	            },
	            768:{
	                items:3
	            },
	            992:{
	                items:4
	            },
	            1200:{
	                items:4
	            },
	        },
	    })
	});


	// custom to show footer center
	$(".description-toggle").click(function () {
		if($('.showmore').hasClass('active'))
			$('.showmore').removeClass('active');
		else
			$('.showmore').addClass('active');
	}); 


	$(".content-product-content .button-toggle").click(function () {
		if($(this).children('.showmore').hasClass('active')) $(this).children().removeClass('active');
		else $(this).children().addClass('active');
		
		
		
		if($(this).prev().hasClass('showdown')) $(this).prev().removeClass('showdown').addClass('showup');
		else $(this).prev().removeClass('showup').addClass('showdown');
	}); 

	$(".clearable").each(function() {
  
	  var $inp = $(this).find("input:text"),
	      $cle = $(this).find(".clearable__clear");

	  $inp.on("input", function(){
	    $cle.toggle(!!this.value);
	  });
	  
	  $cle.on("touchstart click", function(e) {
	    e.preventDefault();
	    $inp.val("").trigger("input");
	  });
	  
	});

});
