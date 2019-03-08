function cpQuickrefineEvents(_moduleData) {

	this.moduleData = _moduleData;
	var _matched_filters = [];
	var _selected_match;
	var _popup;

	var SELECT_NEXT = 1;
	var SELECT_PREVIOUS = 2;
	var POPUP_ALIGN_TOP = 0;
	var POPUP_ALIGN_RIGHT = 1;
	var HIDE_NOT_MATCHED = 0;
	var HIDE_NOT_MATCHED_AND_KEEP_SIZE = 1;
	var DIM_NOT_MATCHED = 2;

	var POPUP_APPLY_SELECTED_FILTER_STR = "Press <span class=\"cp-qr-popup-key\">Enter</span> to apply <span class=\"cp-qr-popup-filter\">{filter}</span>";
	var POPUP_REMOVE_SELECTED_FILTER_STR = "Press <span class=\"cp-qr-popup-key\">Enter</span> to deselect <span class=\"cp-qr-popup-filter\">{filter}</span>";
	var POPUP_NEXT_FILTER_STR = "Use <span class=\"cp-qr-popup-key\">Tab</span> to select next filter <span class=\"cp-qr-popup-filter\">{filter}</span>";
	var POPUP_NO_MATCHES_STR = "No matches";
	var FIELD_CLICK_TO_REMOVE_STR = "Click to remove";


	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		if (this.moduleData.showPopup)
			_popup = new quickrefinePopup();

		POPUP_APPLY_SELECTED_FILTER_STR = this.moduleData.applySelectedStr;
		POPUP_REMOVE_SELECTED_FILTER_STR = this.moduleData.removeSelectedStr;
		POPUP_NEXT_FILTER_STR = this.moduleData.nextFilterStr;
		POPUP_NO_MATCHES_STR = this.moduleData.noMatchesStr;
		FIELD_CLICK_TO_REMOVE_STR = this.moduleData.clickToRemoveStr;

		moduleContainer.addEvents({

			'keydown:relay(.cp-quickrefine-input)': function(event) {
				var key = event.code;

				// console.log(event);

				if (key == 9) {
					//tab
					event.preventDefault();
					var selectDirection = (event.shift) ? SELECT_PREVIOUS : SELECT_NEXT;

					obj.selectNextMatchedFilter(selectDirection);
					obj.updatePopupDirections(this);
				} else if (key == 13) {
					//enter
					event.preventDefault();
					/* order of these two calls matters! */
					obj.applySelectedFilter();
					obj.syncFieldWithSelectedFilter(this);


					if (obj.moduleData.resetOnSubmit || obj.layoutNeedsResetInputAndClearHighlights())
						obj.resetInputAndClearHighlights(this);
					else
						obj.updatePopupDirections(this);
				}

			},

			'keyup:relay(.cp-quickrefine-input)': function(event) {
				var key = event.code;
				var blockKeys = [9, 13, 16, 17, 18, 37, 38, 39, 40, 224];

				// console.log(event);

				if (blockKeys.indexOf(key) == -1) {
					obj.adjustInputWidth(this);
					obj.refineFilters(this);
				}
			},

			'blur:relay(.cp-quickrefine-input)': function() {
				var field = this.getParent('.cp-quickrefine-field');
				if (_popup)
					_popup.close(field);

				field.removeClass('active');
			},

			'focus:relay(.cp-quickrefine-input)': function() {
				var field = this.getParent('.cp-quickrefine-field');
				field.addClass('active');
			},

			'click:relay(.cp-quickrefine-field)': function() {
				this.getElement('.cp-quickrefine-input').focus();
			},

			'click:relay(.cp-qr-field-layout-element)': function() {
				var parent = this.getParent();
				if (parent.lastElementChild == this)
					return;
				var input = parent.getElement('.cp-quickrefine-input');
				obj.removeAppliedFilterFromFieldEvent(this);
				obj.adjustInputWidth(input);
			}

		});
	}


	this.adjustInputWidth = function(editedInput) {
		var	field = editedInput.getParent('.cp-quickrefine-field');

		// console.log(field.getElements('.cp-qr-field-layout-element').length);
		if (field.getElements('.cp-qr-field-layout-element').length < 2) {
			editedInput.setProperty('placeholder', editedInput.getAttribute('data-placeholder'));
			editedInput.setStyle('width', '100%');
			return;
		}

		editedInput.removeAttribute('placeholder');

		var	maxWidth,
			width;

		maxWidth =  field.offsetWidth - 8;

		var style_block = "position:absolute;left:-1000px;top:-1000px;";
		var styles = ['font-size', 'font-style', 'font-weight', 'font-family', 'line-height', 'text-transform', 'letter-spacing'];
		for (var _i = 0, _len = styles.length; _i < _len; _i++) {
			style = styles[_i];
			style_block += style + ":" + editedInput.getStyle(style) + ";";
		}

		var div = document.createElement('div');
		div.setProperty('style', style_block);
		div.innerHTML = editedInput.value;
		document.body.appendChild(div);
		width = div.getWidth();

		div.destroy();

		width += 25;
		if (width > maxWidth)
			width = maxWidth;

		editedInput.setStyle('width', width);
	}


	this.refineFilters = function(editedInput) {
		var keyword = editedInput.value;

		if (keyword.trim() == '') {
			this.clearHighlights(editedInput);
			if (_popup)
				_popup.close(editedInput.getParent('.cp-quickrefine-field'));
			// if (this.moduleData.refineStyle == HIDE_NOT_MATCHED_AND_KEEP_SIZE) {
			//	var groupName = editedInput.getAttribute('data-name');
			//	var filtersContainer = this.moduleData.moduleContainer.getElement('#cp' + this.moduleData.moduleID +
			//		'_group_' + groupName).firstChild;
			//	filtersContainer.removeAttribute('style');
			// }
			return;
		}


		var parentContainer = document.id('cp' + this.moduleData.moduleID + '_group_' +
			editedInput.getAttribute('data-name'));
		var filterElements = parentContainer.getElements('.cp-qr-filter');
		var filtersCount = filterElements.length;

		/* remove previous highlights if any */
		this.clearHighlights(editedInput);


		var refineStyle = this.moduleData.refineStyle;
		if (refineStyle == HIDE_NOT_MATCHED_AND_KEEP_SIZE) {
			var groupName = editedInput.getAttribute('data-name');
			var filtersContainer = this.moduleData.moduleContainer.getElement('#cp' + this.moduleData.moduleID +
				'_group_' + groupName).firstChild;
			filtersContainer.style.minHeight = filtersContainer.clientHeight + "px";
		}

		// var needsHighlight = parseInt(editedInput.getAttribute('data-needshighlight'));

		keyword = keyword.replace(/[^\w]+/g, "\\$&");
		var regex = new RegExp(keyword, "i");
		// console.log(regex);
		var matched_filters = [];
		for (var i = 0; i < filtersCount; ++i) {
			var node = filterElements[i].firstChild;
			var nodeValue = node.nodeValue;
			var regmatch = regex.exec(nodeValue);
			// console.log(regmatch);

			if (regmatch) {
				if (refineStyle == DIM_NOT_MATCHED)
					filterElements[i].getParent('.cp-qr-filter-parent').removeClass('cp-qr-not-matched');
				else
					filterElements[i].getParent('.cp-qr-filter-parent').removeClass('hid');


				matched_filters.push(filterElements[i]);

				// if (needsHighlight) {
					var matchElement = document.createElement('span');
					matchElement.className = 'cp-qr-match';
					matchElement.appendChild(document.createTextNode(regmatch[0]));

					// console.log('match element: ' + matchElement);

					var after = node.splitText(regmatch.index);
					after.nodeValue = after.nodeValue.substring(regmatch[0].length);
					filterElements[i].insertBefore(matchElement, after);
				// }
			} else {
				if (refineStyle == DIM_NOT_MATCHED)
					filterElements[i].getParent('.cp-qr-filter-parent').addClass('cp-qr-not-matched');
				else
					filterElements[i].getParent('.cp-qr-filter-parent').addClass('hid');
			}
		}

		// console.log(matched_filters);
		_matched_filters = matched_filters;

		// if (editedInput.getAttribute('data-popup'))
			// this.updatePopupDirections(editedInput);
		// else
		this.showDirectionsForMatchedFiltersForInput(editedInput);
	}


	this.clearHighlights = function(editedInput) {
		var parentContainer = document.id('cp' + this.moduleData.moduleID + '_group_' +
			editedInput.getAttribute('data-name'));

		if (this.moduleData.refineStyle == DIM_NOT_MATCHED)
			parentContainer.getElements('.cp-qr-filter-parent').removeClass('cp-qr-not-matched');
		else
			parentContainer.getElements('.cp-qr-filter-parent').removeClass('hid');

		// if (parseInt(editedInput.getAttribute('data-needshighlight'))) {
			var matches = this.moduleData.moduleContainer.getElements('.cp-qr-match');
			var i = matches.length;
			while (i--) {
				var parentNode = matches[i].parentNode;
				parentNode.replaceChild(matches[i].firstChild, matches[i]);
				parentNode.normalize();
			}
		// }

		_matched_filters = [];
		_selected_match = null;
	}


	this.showDirectionsForMatchedFiltersForInput = function(editedInput) {
		if (_matched_filters.length == 0) {
			// return;
			_selected_match = null;
		} else {
			_selected_match = _matched_filters[0];
			_selected_match.getElement('.cp-qr-match').addClass('cp-qr-match-selected');
		}

		this.updatePopupDirections(editedInput);
	}


	this.selectNextMatchedFilter = function(selectDirection) {
		var next_match = this.getNextMatchedFilter(selectDirection);
		if (_selected_match != next_match) {
			_selected_match.getElement('.cp-qr-match').removeClass('cp-qr-match-selected');
			next_match.getElement('.cp-qr-match').addClass('cp-qr-match-selected');
			_selected_match = next_match;
		}
	}


	this.updatePopupDirections = function(editedInput) {
		var popupText = '';

		if (_selected_match == null) {
			popupText += POPUP_NO_MATCHES_STR;
		} else {
			var filterName = _selected_match.getAttribute('data-filter');
			var filterApplied = this.isFilterApplied(filterName);
			popupText = "<div>";
			popupText += (filterApplied) ? POPUP_REMOVE_SELECTED_FILTER_STR.replace(/\{filter\}/, filterName) :
				POPUP_APPLY_SELECTED_FILTER_STR.replace(/\{filter\}/, filterName);
			popupText += "</div>";

			var next_match = this.getNextMatchedFilter(SELECT_NEXT);

			if (_selected_match != next_match) {
				popupText += "<div>";
				popupText += POPUP_NEXT_FILTER_STR.replace(/\{filter\}/, next_match.getAttribute('data-filter'));
				popupText += "</div>";
			}
		}

		if (_popup) {
			var relatedElement = editedInput.getParent('.cp-quickrefine-field');
			if (relatedElement.getAttribute('data-popup'))
				_popup.updateContent(relatedElement, '', popupText);
			else
				_popup.showPopupForElement(relatedElement, '', popupText, POPUP_ALIGN_TOP);
		}
	}


	this.getNextMatchedFilter = function(selectDirection) {
		var matched_filters = _matched_filters;
		var count = matched_filters.length;
		var i;

		if (count < 2)
			return _selected_match;

		// console.log(matched_filters);
		// _selected_match.getElement('.cp-qr-match').removeClass('cp-qr-match-selected');
		// console.log(selectDirection, selected_match);

		var next_match;

		for (i = 0; i < count; ++i) {
			if (_selected_match == matched_filters[i]) {
				if (selectDirection == SELECT_NEXT)
					next_match = (i + 1 < count) ? matched_filters[i + 1] : matched_filters[0];
				else
					next_match = (i - 1 >= 0) ? matched_filters[i - 1] : matched_filters[count - 1];

				break;
			}
		}

		return next_match;
	}


	this.syncFieldWithSelectedFilter = function(editedInput) {
		if (! _selected_match)
			return;

		var filterName = _selected_match.getAttribute('data-filter');
		var field = editedInput.getParent('.cp-quickrefine-field');
		this.syncFieldWithFilter(filterName, field);
	}


	/*
	* This method is public.
	* It may be called from events when clicked on filter and want to add this filter
	* to the Quickrefine field.
	*/
	this.syncFieldWithFilter = function(filterName, relatedField) {
		if ( !filterName || !relatedField)
			return;

		var filterApplied = this.isFilterApplied(filterName);

		// console.log(filterName, relatedField, filterApplied);

		if (! filterApplied) {
		// var foundFilter = false;

			var elements = relatedField.getElements('.cp-qr-field-layout-element');
			var len = elements.length - 1;
			while (len--) {
				if (elements[len].firstChild.firstChild.firstChild.nodeValue == filterName) {
					relatedField.removeChild(elements[len]);
					// return;
					// foundFilter = true;
					break;
				}
			}

		} else {
		// if (! foundFilter) {
			var newFilterElement = document.createElement('li');
			newFilterElement.className = 'cp-qr-field-layout-element';
			newFilterElement.innerHTML = '<span class="cp-qr-field-filter" title="' + FIELD_CLICK_TO_REMOVE_STR +
				'"><span class="cp-qr-field-filter-name">' + filterName +
				'</span><span class="cp-qr-field-filter-x">x</span></span>';

			// document.id(newFilterElement).inject(relatedField.lastElementChild, 'before');
			relatedField.insertBefore(newFilterElement, relatedField.lastElementChild);
		}

		this.adjustInputWidth(relatedField.getElement('.cp-quickrefine-input'));
	}


	this.resetInputAndClearHighlights = function(editedInput) {
		editedInput.value = '';
		this.adjustInputWidth(editedInput);

		this.clearHighlights(editedInput);

		if (_popup)
			_popup.closeWithoutAnimation(editedInput.getParent('.cp-quickrefine-field'));
	}


	this.removeAppliedFilterFromFieldEvent = function(clickedElement) {
		var filterName = clickedElement.firstChild.firstChild.firstChild.nodeValue;
		var groupName = clickedElement.parentNode.getElement('.cp-quickrefine-input').getAttribute('data-name');
		clickedElement.parentNode.removeChild(clickedElement);

		if (typeof cpSimpleListLayoutEventsObj != "undefined") {
			cpSimpleListLayoutEventsObj.processFilterSelectEvent(filterName, groupName);
		} else if (typeof cpCheckboxListLayoutEventsObj != "undefined") {
			cpCheckboxListLayoutEventsObj.processFilterSelectEvent(filterName, groupName);
		}
	}


	this.isFilterApplied = function(filterName) {
		if (! filterName)
			return false;

		var applied;

		if (typeof cpSimpleListLayoutEventsObj != "undefined") {
			applied = cpSimpleListLayoutEventsObj.isFilterApplied(filterName);
		} else if (typeof cpCheckboxListLayoutEventsObj != "undefined") {
			applied = cpCheckboxListLayoutEventsObj.isFilterApplied(filterName);
		}

		return applied;
	}


	this.applySelectedFilter = function() {
		if (! _selected_match)
			return;

		/* Note. If we have two copies of CP simplelist and checkboxlist on page at the same time,
			there might be a problem here. In this case we'd have to use moduleData */
		if (typeof cpSimpleListLayoutEventsObj != "undefined") {
			var filterName = _selected_match.getAttribute('data-filter');
			var groupName = _selected_match.getParent('.cp-filter-group').getAttribute('data-name');
			cpSimpleListLayoutEventsObj.processFilterSelectEvent(filterName, groupName);
		} else if (typeof cpCheckboxListLayoutEventsObj != "undefined") {
			var id = _selected_match.parentNode.getAttribute('for');
			var input = this.moduleData.moduleContainer.getElement('#' + id);
			input.checked = !input.checked;
			cpCheckboxListLayoutEventsObj.processFilterClickEvent(input);
		}
	}


	this.layoutNeedsResetInputAndClearHighlights = function() {
		var needsReset = false;

		if (typeof cpSimpleListLayoutEventsObj != "undefined") {
			if (cpSimpleListLayoutEventsObj.moduleData.updateProducts)
				needsReset = true;
		} else if (typeof cpCheckboxListLayoutEventsObj != "undefined") {
			if (cpCheckboxListLayoutEventsObj.moduleData.updateProducts
				&& cpCheckboxListLayoutEventsObj.moduleData.updateEachStep)
				needsReset = true;
		}

		return needsReset;
	}



	// ---------------------------------------------------------
	// ----------------     POPUP      -------------------------
	// ---------------------------------------------------------

	function quickrefinePopup() {

		var _popupId = 0;
		var _bottom_arrow_padding = 8;

		this.showPopupForElement = function(parentElement, title, text, align) {

			if ( !parentElement || parentElement.getAttribute('data-popup'))
				return;

			var popupContainer = document.createElement('div');
			popupContainer.className = 'cp-qr-popup';
			var id = parentElement.id + '-cpqr-popup' + _popupId;
			++_popupId;
			popupContainer.id = id;

			parentElement.setProperty('data-popup', id);

			var popupContent = document.createElement('div');
			var innerHTML = "";
			if (title) {
				innerHTML += title;
			}

			if (text) {
				innerHTML += text;
			}

			popupContent.innerHTML = innerHTML;
			popupContainer.appendChild(popupContent);

			var arrowOuter = document.createElement('div'),
				arrowInner = document.createElement('div');
			arrowOuter.className = "cp-qr-popup-arrow cp-qr-popup-arrow-outer";
			arrowInner.className = "cp-qr-popup-arrow cp-qr-popup-arrow-inner";

			popupContainer.appendChild(arrowOuter);
			popupContainer.appendChild(arrowInner);

			document.body.appendChild(popupContainer);

			// console.log(popupContainer.offsetWidth, popupContainer.offsetLeft);

			var left,
				top,
				viewportWidth = document.body.getWidth();

			if (align == POPUP_ALIGN_RIGHT) {
				left = parentElement.getLeft() + parentElement.offsetWidth + 6;
				top = parentElement.getTop() + parentElement.offsetHeight / 2 - popupContainer.offsetHeight / 2;
				popupContainer.setStyles({'left': left, 'top': top, 'opacity': 0.0});
			} else if (align == POPUP_ALIGN_TOP) {
				top = parentElement.getTop() - popupContainer.offsetHeight - _bottom_arrow_padding;
				left = parentElement.getLeft();
				if (left + popupContainer.offsetWidth > viewportWidth) {
					left = viewportWidth - left - parentElement.offsetWidth;
					popupContainer.setStyles({'right': left, 'top': top, 'opacity': 0.0});
					// move arrow to the right
					arrowOuter.setStyles({'right': 12, 'left': 'auto'});
					arrowInner.setStyles({'right': 12, 'left': 'auto'});
				} else
					popupContainer.setStyles({'left': left, 'top': top, 'opacity': 0.0});
			}



			var fadeFx = new Fx.Tween(popupContainer, {
				transition: Fx.Transitions.Linear,
				duration: 200,
			    property: 'opacity'
			});
			fadeFx.start(0, 1);
		}


		this.updateContent = function(parentElement, newTitle, newText) {
			if ( !parentElement || !parentElement.getAttribute('data-popup'))
				return;

			var popup = document.id(parentElement.getAttribute('data-popup'));
			var innerHTML = "";
			if (newTitle)
				innerHTML += newTitle;

			if (newText)
				innerHTML += newText;

			popup.firstChild.innerHTML = innerHTML;

			// because of content change we need to reposition popup
			var top;
			top = parentElement.getTop() - popup.offsetHeight - _bottom_arrow_padding;
			popup.setStyle('top', top);
		}


		this.close = function(parentElement) {
			var popupId = parentElement.getAttribute('data-popup');
			if (! popupId)
				return;

			var popupContainer = document.id(popupId);

			var fadeFx = new Fx.Tween(popupContainer, {
				transition: Fx.Transitions.Linear,
				duration: 100,
			    property: 'opacity',
			    onComplete: function() {
					popupContainer.destroy();
					parentElement.removeAttribute('data-popup');
			    }
			});
			fadeFx.start(popupContainer.style.opacity, 0);

		}


		this.closeWithoutAnimation = function(parentElement) {
			var popupId = parentElement.getAttribute('data-popup');
			if (! popupId)
				return;

			var popupContainer = document.id(popupId);
			popupContainer.destroy();
			parentElement.removeAttribute('data-popup');
		}

	}

}




