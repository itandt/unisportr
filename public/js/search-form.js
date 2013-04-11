var formMaximazed = false;
var formMinHeight = 31;
var formMaxHeight = 250;
var executeShowHideForm = function showHideForm() {
	var newHeight = formMaximazed == true ? formMinHeight : formMaxHeight;
	formMaximazed = !formMaximazed;
	jQuery('#searchFormContainer').animate({
		height: newHeight
	});
}
jQuery(document).ready(function() {
//	executeShowHideForm();
	jQuery('#showFormButton').click(executeShowHideForm);
});