var formMaximized = false;
var formMinimizedHeight = 31;
// var formMaximizedHeight = 250;
var executeShowHideForm = function showHideForm() {
	var element = jQuery('#searchFormContainer');
	if (formMaximized == true) {
		element.animate({
			height: formMinimizedHeight
		});
	} else {
		element.animate({
			height: element.prop('scrollHeight')
		});
	}
	formMaximized = !formMaximized;
}
jQuery(document).ready(function() {
//	executeShowHideForm();
	jQuery('#showFormButton').click(executeShowHideForm);
});