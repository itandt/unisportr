/*
 * Auto filling out of the search form for a faster testing.
 */
jQuery('document').ready(function() {
	jQuery('#devFilloutButton').click(function() {
		jQuery('#searchForm #searchFormKeyword').val('Salsa');
		jQuery('#searchForm #searchFormLevel2').attr('checked', true);
		jQuery('#searchForm #searchFormWeekdayWed').attr('checked', true);
		jQuery('#searchForm #searchFormWeekdayFri').attr('checked', true);
		jQuery('#searchForm #searchFormWeekdaySat').attr('checked', true);
	});
});

// <input id="devFilloutButton" type="button" value="<?php echo JText::_('DEV'); ?>" />