jQuery(function() {

	// Opens up first faq item
	jQuery('.fs-faq-loop-grid').each(function() {
		var gridCont = jQuery(this);

		// Triggers first item
		gridCont.find('[data-elementor-type="loop-item"]:first .e-n-accordion-item-title:first').get(0).click();
		gridCont.find('[data-elementor-type="loop-item"]:first .e-n-accordion-item-title:first').attr('aria-expanded', 'true');
	});

	jQuery(window).load(function() {
		jQuery('.fs-faq-loop-grid').each(function() {
			setTimeout(function() {
				jQuery(this).find('[data-elementor-type="loop-item"]:first .e-n-accordion-item-title').trigger('click');
			}, 500);
		});
	});

	jQuery('form.variations_form').each(function() {

		const $priceEl = jQuery('#sv-wc-product-price');
		const originalPrice = $priceEl.html();

		jQuery(this).on('found_variation', function (e, variation) {
			if (variation.price_html) {
				$priceEl.html(variation.price_html);
			}
		}).on('reset_data', function () {
				$priceEl.html(originalPrice);
		});

	})

})

jQuery(document).on('click', '.fs-faq-loop-grid .e-n-accordion-item-title[aria-expanded="false"]', function() {

	var parentCont = jQuery(this).parents('.elementor-grid'),
		thisCont = jQuery(this);

	parentCont.find('.e-n-accordion-item-title[aria-expanded="true"]').each(function() {
		jQuery(this).trigger('click');
	})

}).on('click mousedown mouseup', '.woo-variation-swatches .variable-items-wrapper .button-variable-item.disabled', function(e) {
	e.preventDefault();
	return false;
}).on('click', '.fs-fl-carousel-prev a', function(e) {
	
	e.preventDefault();
	jQuery(this).parents('.fs-fl-container').find('.elementor-swiper-button-prev').get(0).click();
	return false;
	
}).on('click', '.fs-fl-carousel-next a', function(e) {
	
	e.preventDefault();
	jQuery(this).parents('.fs-fl-container').find('.elementor-swiper-button-next').get(0).click();
	return false;
	
}).on('click', '.sv-read-more-bio', function(e) {
	
	e.preventDefault();
	
	var parentCont = jQuery(this).parents('.sv-bio-wrapper');
	
	if(parentCont.hasClass('active')) {
		parentCont.removeClass('active');
		parentCont.css({ height: 'auto' });
		jQuery(this).text('Read more');
	} else {
		parentCont.css({ height: parentCont.height() });
		parentCont.addClass('active');
		jQuery(this).text('Read less');
		document.addEventListener('click', bioWrapClickListened, { once: true });
	}
	
	return false;
	
});

var bioWrapClickListened = function(e) {
	
	// If we click outside the container
	if(!jQuery(e.target).is('.sv-bio-wrapper.active') || jQuery(e.target).parents('.sv-bio-wrapper.active').length < 1) {
		jQuery('.sv-bio-wrapper.active .sv-read-more-bio').text('Read more');
		jQuery('.sv-bio-wrapper.active').removeClass('active').css({ height: 'auto' });
	} else {
		document.addEventListener('click', bioWrapClickListened, { once: true });
	}
	
}





window.addEventListener('elementor/popup/show', function(e) {

	var popup = e.detail.instance.$element,
		popupId = e.detail.id;
		
	if(popupId != 7747) {
		return;
	}

	// Populates popup content
	setTimeout(function() {
		popup.find('.sv-mobile-menu-wrap').each(function() {
			var menuCont = jQuery(this),
				ulCont = menuCont.find('ul.menu');
			menuCont.find('ul.sub-menu').each(function() {
				jQuery(this).addClass('menu vertical nested');
			})
			menuCont.find('ul.menu').each(function() {
				jQuery(this).addClass('vertical menu drilldown').attr('data-drilldown', 'data-drilldown').attr('data-auto-height', 'true').attr('data-animation-duration', '1000').attr('data-animate-height', 'true');
			});
			var ddF = new Foundation.Drilldown(ulCont);
		})
	});
	
});



window.addEventListener('elementor/popup/show', function(e) {

	var popup = e.detail.instance.$element,
		popupId = e.detail.id;
		
	if(popupId != 7750) {
		return;
	}
	
	// Adds active classes to animations
	setTimeout(function() {
		popup.find('.sv-popup-fade-up').addClass('active');
		setTimeout(function() {
			jQuery('.dialog-message .e-search-input').get(0).focus();
			console.log(jQuery('.dialog-message .e-search-input'));
		}, 800);
	});
	
}).addEventListener('elementor/popup/close', function(e) {

	var popup = e.detail.instance.$element,
		popupId = e.detail.id;
		
	if(popupId != 7750) {
		return;
	}
	
	// Adds active classes to animations
	setTimeout(function() {
		popup.find('.sv-popup-fade-up').removeClass('active')
	});
	
});