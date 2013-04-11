var formMaximized = false; // is overwritten by formMaximized defined in search-form.phtml
var formMinimizedHeight = 31;
// var formMaximizedHeight = 250;
var executeShowHideForm = function showHideForm() {
	var searchFormContainerElement = jQuery('#searchFormContainer');
	var searchFormAreaElement = jQuery('#searchFormArea');
	if (formMaximized == true) {
		searchFormContainerElement.animate({
			height: formMinimizedHeight
		});
		searchFormAreaElement.css('padding-bottom', '');
	} else {
		searchFormContainerElement.animate({
			height: searchFormContainerElement.prop('scrollHeight')
		});
		searchFormAreaElement.css('padding-bottom', 30);
	}
	formMaximized = !formMaximized;
}
jQuery(document).ready(function() {
	executeShowHideForm();
	jQuery('#showFormButton').click(executeShowHideForm);
});