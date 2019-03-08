function ActivateLoading() {
	jQuery("body").prepend("<div class='main-loader'><ul class='loader'><li></li><li></li><li></li></ul></div>");
}

function DeactivateLoading() {
	jQuery(".main-loader").remove();
}