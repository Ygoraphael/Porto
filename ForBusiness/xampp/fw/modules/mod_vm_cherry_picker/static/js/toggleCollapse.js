function cpCollapseEvent(_moduleData) {

	this.moduleData = _moduleData;
	// this.FX = [];

	var GROUP_GLOBAL = 0;
	var GROUP_COLLAPSED = 1;
	var GROUP_EXPANDED = 2;

	this.init = function() {
		var obj = this,
			// moduleContainer = obj.moduleData.moduleContainer;
			moduleContainer = jQuery('#cpFilters' + this.moduleData.moduleID);

		// moduleContainer.addEvent('click:relay(.cp-collapse)', function(event) {
		moduleContainer.delegate(".cp-collapse", "click", function(event) {
			// when clicked on Clear inside Header
			if (event.target.nodeName == "A")
				return;

			obj.runFXTransition(this, 'toggle');
		});

		// hide Parameters on page-load
		// if (this.moduleData.defaultStateCollapsed) {
			this.collapseGroupsIfNeeded();
		// }

		if (this.moduleData.updateProducts) { // need to add: && this.moduleData.registeredForUpdates
			moduleContainer[0].addEventListener('cpupdate', function() {
				// console.log('should clear');
				// obj.FX = [];

				// if (obj.moduleData.defaultStateCollapsed) {
					obj.collapseGroupsIfNeeded();
				// }
			});
		}
	}


	this.collapseGroupsIfNeeded = function() {
		var obj = this;
		var defaultCollpsed = this.moduleData.defaultStateCollapsed;
		// this.moduleData.moduleContainer.getElements('.cp-collapse').each(function(triggerElement) {
			// if (triggerElement.getAttribute('applied') != 1) {
			// 	var groupState = parseInt(triggerElement.getAttribute('data-default'));
			// 	if (groupState == GROUP_COLLAPSED || defaultCollpsed && (!groupState || groupState == GROUP_GLOBAL))
			// 		obj.runFXTransition(triggerElement, 'hide');
			// }

		jQuery.each(jQuery('#cpFilters' + this.moduleData.moduleID + ' .cp-collapse'), function(index, element) {
			if (element.getAttribute('applied') != 1) {
				var groupState = parseInt(element.getAttribute('data-default'));
				if (groupState == GROUP_COLLAPSED || defaultCollpsed && (!groupState || groupState == GROUP_GLOBAL))
					obj.runFXTransition(element, 'hide');
			}
		});
	}


	this.runFXTransition = function(triggerElement, type) {
		var block = jQuery(triggerElement).next();
		if (type == "hide") {
			setTimeout(function() {
				block.hide();
			}, 1);
			return;
		}

		var options = {
			duration: 300,
			direction: "vertical",
			easing: (typeof jQuery.easing.easeOutCubic == "undefined") ? "swing" : "easeOutCubic",
			effect: "blind",
			complete: function() {
				var state = jQuery(triggerElement).children(':first');
				state.html((state.html() == '[-]') ? '[+]' : '[-]');
			}
		}

		var obj = this;
		var groupName = '_' + this.moduleData.moduleID + '_' + triggerElement.getAttribute('data-name');
		// var completeHandler = function() {
		// 	var state = jQuery(triggerElement).children(':first');
		// 	// state.innerHTML = (state.innerHTML == '-') ? '+' : '-';
		// 	state.html((state.html() == '-') ? '+' : '-');
		// }

		// block.toggle("blind", options, 300, completeHandler);
		block.toggle(options);
		// console.log('posting event: ', groupName + "_ToggleDidBeginEvent");
		// Post notification that header did begin toggle event.
		// This event is handful in trackbar class: if block was hidden
		// trackbar wasn't able to init properly. Now when the block is
		// displayed it can do so.
		obj.createAndDispatchEvent(groupName + "_ToggleDidBeginEvent");
/* */

// 		var fx = this.getTriggersFX(triggerElement);
// console.log(type);
// 		switch (type) {
// 			case 'toggle':
// 				fx.toggle();
// 				// bug with MT1.4.5 and Opera: toggle() doesn't work. slideIn & slideOut might be used instead
// 				break

// 			case 'hide':
// 				fx.hide();
// 				break;

// 			default:
// 				fx.toggle();
// 		}
	}

/*
	this.getTriggersFX = function(triggerElement) {
		var triggerName = triggerElement.getAttribute('data-name');

		for (var i = 0, len = this.FX.length; i < len; i++) {
			if (triggerName == this.FX[i].triggerName) {
				return this.FX[i].fx;
			}
		}

		// if here -- nothing found. It's not been created, so let's do so
		var block = triggerElement.getNext();
		var fx = new Fx.Slide(block, {
			duration: 200,
			onComplete: function() {
				var state = triggerElement.getFirst();
				state.innerHTML = (state.innerHTML == '-') ? '+' : '-';
			},
			resetHeight: true,
			hideOverflow: true
		});

		this.FX.push({"triggerName": triggerName, "fx": fx});

		return fx;
	}
*/

	this.createAndDispatchEvent = function(eventType) {
		// we can't use 'new Event()' here becuase MooTools (sic!) throws error
		if (typeof CustomEvent == "function") {
			var event = new CustomEvent(eventType);
		} else {
			var event = document.createEvent('Event');
			event.initEvent(eventType, true, true);
		}
		window.dispatchEvent(event);
	}
}
