window.addEvent('domready', function() {

	$('configurationOptions').addEvents({

		'click:relay(.conf-save-button)': function() {
			saveConfiguration(this);
		},

		'change:relay(.confopt-chkbx)': function() {
			toggleDimImage(this);
		}

	});

});


function saveConfiguration(clickedButton) {

	if (validateForm() == false) return;

	var form = document.configuration,
		loaderId = clickedButton.getAttribute('data-loaderid'),
		loader = $(loaderId);

	new Request({
		url: url,
		data: form,
		onRequest: function(){
			loader.removeClass('hid');
		},
		onComplete: function(){
			loader.addClass('hid');
		}
	}).send();

}

function validateForm() {
	//var form = document.configuration;

	return true;
}


function toggleDimImage(clickedCheckbox) {

	var imageId = clickedCheckbox.getAttribute('name') + '_fig',
		image = $(imageId);

	image.toggleClass('semi-transparent');

}
