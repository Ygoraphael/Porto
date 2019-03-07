var cpWarningMessageEvents = function(_moduleData) {

	this.moduleData = _moduleData;
	this.fadingEffect = null;

	this.init = function() {
		var obj = this,
			messageContainer = document.id('cpWarningMessage' + this.moduleData.moduleID);

		messageContainer.getElement('.cp-warn-close').addEvent('click', function() {
			obj.processCloseWarningMessageEvent(messageContainer);
		});

	}



	this.processCloseWarningMessageEvent = function(messageContainer) {
		var //messageContainer = document.getElement('.cp-warn-cont'),
			// messageContainer = clickedElement.getParent('.cp-warn-cont'),
			messageType = messageContainer.getAttribute('data-messagetype');

		if (this.fadingEffect) return;

		var data = 'action_type=warning_message_dialog&message=' + messageType +
			'&module_id=' + this.moduleData.moduleID;;

		new Request({
			url: cp_fajax,
			data: data,
			onComplete: function(response) {
				if (response == 1)
					alert("Cherry Picker Message:\n\nThere was an error while saving configuration. Your server config doesn't allow editing files. You would need to edit:\n/modules/mod_vm_cherry_picker/assistOptions.php\n\nby manually setting this variable to '0':\n$cpAssistOption['cp_first_run'] = 0;");
			}
		}).send();

		var fade = new Fx.Tween(messageContainer, {
			duration: 200,
			property: 'opacity',
			onComplete: function() {
				messageContainer.destroy();
			}
		});

		this.fadingEffect = fade;

		fade.start(1, 0);
	}

}
