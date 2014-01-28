// DOM Ready
jQuery(document).ready(function () {
				jQuery('ul.root-menu > li').hover(
			        function () {
			            //show its submenu
			            jQuery('ul:first', this).show();
			            jQuery(this).addClass("hover");	 
			        }, 
			        function () {
			            //hide its submenu
			            jQuery('ul:first', this).hide(); 
			            jQuery(this).removeClass("hover");        
			        }
			    );

				
				jQuery('.menu-features li').each(function () {
			    	var theorder = jQuery(".menu-order", this).text();
					jQuery(this).clone().insertAfter(".root-menu > li:nth-child(" + theorder + ") .child-menu:first > li:last");
				});
				
				jQuery('.noscript-hide').remove();
			    
			    
			    
			    jQuery('.quick-links a.dropdown').click( function () {

			            jQuery(this).next().slideToggle("fast");
			            jQuery(this).toggleClass("icon-up-dir");
			            return false;
			 
			    });


				jQuery('.slideshow').bxSlider({
					slideWidth: 880,
					controls: false,
					auto: true,
					pause: 4000,
					autoHover: true,
					mode: 'fade',
					pagerSelector: '.slideshow-nav'
			  	});
			  	
			  	// add classes for table styling
			  	
			  	jQuery('.page-content table tr td:last-child').addClass('lastcol');
			  	jQuery('.page-content table tr:last-child td').addClass('lastrow');
				  
				// Sliders
			  	
			  	if (jQuery(window).width() < 500) {
				         jQuery('.slider4col').bxSlider({
						  	slideWidth: 300,
						    minSlides: 1,
						    maxSlides: 1,
						    slideMargin: 10,
						    pager: true
						  	});
				    } else {
				         jQuery('.slider4col').bxSlider({
						  	slideWidth: 300,
						    minSlides: 4,
						    maxSlides: 4,
						    slideMargin: 10,
						    pager: false
						  	});
				    }
			  	
			  	/*jQuery(window).resize(function() {
				    if (jQuery(window).width() < 500) {
				         jQuery('.slider4col').bxSlider({
						  	slideWidth: 300,
						    minSlides: 1,
						    maxSlides: 1,
						    slideMargin: 10,
						    pager: false
			
						  	});
				    } else {
				         // do something else
				    }
				});*/

				
				

			    
				
});


