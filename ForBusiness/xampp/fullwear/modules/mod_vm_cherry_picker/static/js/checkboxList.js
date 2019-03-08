function cpCheckboxListLayoutEvents(_moduleData) {

	this.moduleData = _moduleData;
	this.totalProductsAjax = null;
	this.dynamicResultTimer = null;


	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		moduleContainer.addEvents({

			'change:relay(input.cp-filter-input)': function() {
				obj.processFilterClickEvent(this);
				obj.syncQuickrefineFieldIfNeeded(this);
			},

			'click:relay(.cp-color-palette-element)': function() {
				obj.processFilterClickEvent(this);
				obj.syncQuickrefineFieldIfNeeded(this);
			},

			'click:relay(.cp-dr-go)': function() {
				obj.submitFiltersForm();
			},

			'submit:relay(form)': function(event) {
				event.preventDefault();

				obj.submitFiltersForm();
			},

			'mouseenter:relay(h2.cp-collapse)': function(event) {
				var block = this.getNext().getElement('.cp-chkb-filter-group');
				if (block)
					block.addClass('cp-chkb-filter-group-hovered');
			},

			'mouseleave:relay(h2.cp-collapse)': function(event) {
				var block = this.getNext().getElement('.cp-chkb-filter-group');
				if (block)
					block.removeClass('cp-chkb-filter-group-hovered');
			}

		});

		if (this.moduleData.updateProducts) {
			moduleContainer.addEvents({
				'click:relay(.cp-clearlink)': function(event) {
					event.preventDefault();
					obj.processLinkClickEvent(this);
				},

				'click:relay(.cp-price-clear)': function(event) {
					event.preventDefault();
					obj.processLinkClickEvent(this);
				}
			});
		}

	}


	this.processLinkClickEvent = function(clickedLink) {
		var locationURL = clickedLink.getAttribute('href');
		cpUpdateResutsViaAjaxObj.updateResults(locationURL);
	}


	this.processFilterClickEvent = function(clickedFilter) {
		var groupName = clickedFilter.getAttribute('data-groupname'),
			form = this.moduleData.moduleContainer.getElement('form'),
			groupInput = form[groupName],
			selection = [],
			filterWasSelected,
			clickedFilterName;

		// otherwise it's the color filter
		var isRegularFilter = clickedFilter.hasClass('cp-filter-input');

		if (isRegularFilter) {
			filterWasSelected = clickedFilter.checked;
			clickedFilterName = clickedFilter.value;
		} else {
			if (clickedFilter.hasClass('cp-color-applied')) {
				clickedFilter.removeClass('cp-color-applied');
				filterWasSelected = false;
			} else {
				clickedFilter.addClass('cp-color-applied');
				filterWasSelected = true;
			}
			clickedFilterName = clickedFilter.getAttribute('data-filtername');
		}


		if (groupInput.value) selection = groupInput.value.split('|');

		if (filterWasSelected) {
			selection.push(clickedFilterName);
		} else {
			var index = selection.indexOf(clickedFilterName);
			selection.splice(index, 1);
		}

		//console.log(selection);

		groupInput.value = selection.join('|');



		if (this.moduleData.updateProducts && this.moduleData.updateEachStep) {
			var url = this.getAppliedRefinementsURL();
			cpUpdateResutsViaAjaxObj.updateResults(url);
		} else {
			this.updateTotalProductsFound(clickedFilter);
		}

	}



	// this.processFilterClickEvent = function(clickedFilter) {
	this.updateTotalProductsFound = function(clickedFilter) {
		// get total results
		var groupInputs = this.moduleData.moduleContainer.getElements('.hidden-filter'),
			appliedStaticFilterInputs = this.moduleData.moduleContainer.getElements('.hidden-static-filter'),
			form = this.moduleData.moduleContainer.getElement('form'),
			filtersSelection = [],
			parameters = '',
			lowPrice = form['low-price'],
			highPrice = form['high-price'],
			totalProductsNode = this.moduleData.moduleContainer.getElement('.cp-totalproducts'),
			isRegularFilter = clickedFilter.hasClass('cp-filter-input');

		groupInputs.each(function(groupInput) {
			if (groupInput.value) filtersSelection.push(groupInput.name + '=' + encodeURIComponent(groupInput.value));
		});

		appliedStaticFilterInputs.each(function(input) {
			if (input.value) filtersSelection.push(input.name + '=' + encodeURIComponent(input.value));
		});

		parameters = 'action_type=get_total&ptids=' + this.moduleData.productTypeIDs +
			'&module_id=' + this.moduleData.moduleID;
		parameters += '&' + cpEnvironmentValues.getEnvironmentValues();
		if (lowPrice) parameters += '&low-price=' + lowPrice.value;
		if (highPrice) parameters += '&high-price=' + highPrice.value;
		parameters += '&' + filtersSelection.join('&');


		if (this.totalProductsAjax) {
			this.totalProductsAjax.cancel();
			this.totalProductsAjax = null;
		}

		var showLiveResult = this.moduleData.showLiveResults;
		if (showLiveResult) {
			var liveResultBlock = this.moduleData.moduleContainer.getElement('.cp-checkboxlist-liveresult'),
				liveResultValue = liveResultBlock.getElement('.cp-dr-resvalue'),
				liveResultSubmit = liveResultBlock.getElement('.cp-dr-go');
				// label = clickedInput.getNext();
		}

		var obj = this;
		this.totalProductsAjax = new Request ({
			url: cp_fajax,
			method: 'get',
			data: parameters,
			onRequest: function() {
				if (totalProductsNode) totalProductsNode.getFirst().addClass('transparent');
				//totalProductsNode.addClass('transparent');
			},
			onComplete: function(response) {
				var result = (obj.isInt(response)) ? response : 0;
				// dynamicResValue.innerHTML = result;

				if (totalProductsNode) {
					totalProductsNode.getLast().innerHTML = result;
					totalProductsNode.getFirst().removeClass('transparent');
				}

				if (showLiveResult) {
					liveResultValue.innerHTML = result;

					if (result == 0) {
						liveResultSubmit.addClass('hid');
					} else {
						liveResultSubmit.removeClass('hid');
					}

					// since multiple copies of module can be used, we might need to hide
					// other modules' liveResultBlock
					document.getElements('.cp-checkboxlist-liveresult').addClass('hid');
					liveResultBlock.removeClass('hid');

					var viewportWidth = document.body.getWidth(),
						arrowPositionedLeft = true,
						posX,
						posY = 0;

					if (isRegularFilter) {
						var relativeElement;
						var scrollBox = clickedFilter.getParent('.cp-chkb-scroll-box');
						if (clickedFilter.offsetWidth == 0 || (scrollBox &&
							((clickedFilter.offsetTop - scrollBox.offsetTop -
								scrollBox.scrollTop > scrollBox.offsetHeight)
								|| (clickedFilter.offsetTop - scrollBox.scrollTop < scrollBox.offsetTop)
							))
							) {

							var quickrefineField = obj.moduleData.moduleContainer.getElement(
								'#cp' + obj.moduleData.moduleID + '_quickrefine_' +
								clickedFilter.getAttribute('data-groupname'));
							if (quickrefineField)
								relativeElement = quickrefineField;
							else
								relativeElement = clickedFilter;
						} else {
							relativeElement = clickedFilter.getNext();
							posY = (scrollBox) ? -scrollBox.scrollTop : 0;
						}


						posY = relativeElement.offsetTop + relativeElement.offsetHeight / 2
							- liveResultBlock.offsetHeight / 2 + posY;

						posX = relativeElement.offsetLeft + relativeElement.offsetWidth + 30;
						if (posX + liveResultBlock.offsetWidth > viewportWidth) {
							posX = clickedFilter.offsetLeft - liveResultBlock.offsetWidth - 20;
							arrowPositionedLeft = false;
						}
					} else {
						var paletteContainer = clickedFilter.getParent('.cp-color-palette');

						posY = clickedFilter.offsetTop + clickedFilter.offsetHeight / 2 - liveResultBlock.offsetHeight / 2;
						posX = paletteContainer.offsetLeft + paletteContainer.offsetWidth + 10;
						if (posX + liveResultBlock.offsetWidth > viewportWidth) {
							posX = paletteContainer.offsetLeft - liveResultBlock.offsetWidth - 20;
							arrowPositionedLeft = false;
						}
					}


					var liveResultBlockArrow = obj.moduleData.moduleContainer.getElements('.cp-dr-arrow');
					// if popup doesn't fit on screen -- show from left side
					if (arrowPositionedLeft) {
						liveResultBlockArrow[0].className = 'cp-dr-arrow cp-dr-arrow-outer-left';
						liveResultBlockArrow[1].className = 'cp-dr-arrow cp-dr-arrow-inner-left';
					} else {
						liveResultBlockArrow[0].className = 'cp-dr-arrow cp-dr-arrow-outer-right';
						liveResultBlockArrow[1].className = 'cp-dr-arrow cp-dr-arrow-inner-right';
					}

					liveResultBlock.setStyles({top: posY, left: posX});



					if (obj.dynamicResultTimer) {
						clearTimeout(obj.dynamicResultTimer);
						obj.dynamicResultTimer = null;
					}
					obj.dynamicResultTimer = setTimeout(function(){liveResultBlock.addClass('hid');}, 5000);
				}
			}
		});

		this.totalProductsAjax.send();
	}


	this.submitFiltersForm = function() {
		if (this.moduleData.updateProducts) {
			var url = this.getAppliedRefinementsURL();
			cpUpdateResutsViaAjaxObj.updateResults(url);
		} else {
			var groupInputs = this.moduleData.moduleContainer.getElements('.hidden-filter'),
				form = this.moduleData.moduleContainer.getElement('form');

			groupInputs.each(function(groupInput) {
				if (groupInput.value == '') groupInput.destroy();
			});

			var lowPrice = form['low-price'],
				highPrice = form['high-price'];
			// if (lowPrice && lowPrice.value == "") lowPrice.name = "";
			// if (highPrice && highPrice.value == "") highPrice.name = "";
			if (lowPrice && lowPrice.value == "") lowPrice.setProperty('disabled', true);
			if (highPrice && highPrice.value == "") highPrice.setProperty('disabled', true);

			form.submit();
		}
	}


	this.getAppliedRefinementsURL = function() {
		var url = this.moduleData.moduleContainer.getElement('#cp' +
				this.moduleData.moduleID  + '_base_url').getAttribute('data-value'),
			groupInputs = this.moduleData.moduleContainer.getElements('.hidden-filter'),
			appliedStaticFilterInputs = this.moduleData.moduleContainer.getElements('.hidden-static-filter'),
			form = this.moduleData.moduleContainer.getElement('form'),
			selection = [],
			lowPrice = form['low-price'],
			highPrice = form['high-price'];


		groupInputs.each(function(groupInput) {
			if (groupInput.value) selection.push(groupInput.name + '=' + encodeURIComponent(groupInput.value));
		});

		appliedStaticFilterInputs.each(function(input) {
			if (input.value) selection.push(input.name + '=' + encodeURIComponent(input.value));
		});


		if (lowPrice && lowPrice.value) selection.push('low-price=' + lowPrice.value);
		if (highPrice && highPrice.value) selection.push('high-price=' + highPrice.value);

		if (selection.length) {
			var uri = new URI(url);
			var query = uri.get('query');
			if (query != "") query += '&';
			query += selection.join('&');
			uri.set('query', query);

			url = uri.toAbsolute();
		}

		return url;
	}


	this.processFilterSelectEvent = function(filterName, groupName) {
		var filtersContainer = this.moduleData.moduleContainer.getElement(
			'#cp' + this.moduleData.moduleID + '_group_' + groupName);
		var elements = filtersContainer.getElements('.cp-filter-input');
		var len = elements.length;

		// var regex = new RegExp("^" + filterName + "$", "i");
		// console.log(regex);
		var needle = filterName.replace(/[^\w]+/g, "\\$&");
		var regex = new RegExp("^" + needle + "$", "i");
		while (len--) {
			// if (elements[len].value == filterName) {
			var filter = elements[len].getAttribute('data-filter');
			if (! filter)
				filter = elements[len].value;
			if (regex.exec(filter)) {
				// if (typeof cpQuickrefineEventsObj != "undefined" && this.moduleData.updateProducts
				//	&& this.moduleData.updateEachStep) {
				//	var input = this.moduleData.moduleContainer.getElement('#cp' + this.moduleData.moduleID
				//		+ '_quickrefine_' + groupName).getElement('.cp-quickrefine-input');
				//	cpQuickrefineEventsObj.resetInputAndClearHighlights(input);
				// }

				elements[len].checked = !elements[len].checked;
				this.processFilterClickEvent(elements[len]);
				// break;
				return;
			}
		}

		if (typeof cpSeeMoreEventObj != "undefined" && this.moduleData.seemoreUseAjax) {
			var input = document.createElement('input');
			input.className = "cp-filter-input";
			input.setAttribute("data-groupname", groupName);
			input.value = filterName;
			input.checked = 0;
			var showLiveResults = this.moduleData.showLiveResults;
			this.moduleData.showLiveResults = 0;
			this.processFilterClickEvent(input);
			this.moduleData.showLiveResults = showLiveResults;
		}
	}


	this.isFilterApplied = function(filterName) {
		if (! filterName)
			return false;

		var appliedElements = this.moduleData.moduleContainer.getElements('.cp-filter-input:checked');
		var len = appliedElements.length;

		if (! len)
			return false;

		var needle = filterName.replace(/[^\w]+/g, "\\$&");
		var regex = new RegExp("^" + needle + "$", "i");
		// console.log(regex);
		while (len--) {
			// if (appliedElements[len].value == filterName)
			var filter = appliedElements[len].getAttribute('data-filter');
			if (! filter)
				filter = appliedElements[len].value;
			if (regex.exec(filter))
				return true;
		}

		return false;
	}


	this.syncQuickrefineFieldIfNeeded = function(clickedInput) {

		if (typeof cpQuickrefineEventsObj != "undefined") {
			var groupName = clickedInput.getAttribute('data-groupname');
			var field = this.moduleData.moduleContainer.getElement('#cp' + this.moduleData.moduleID +
				'_quickrefine_' + groupName);
			// var filterName = clickedInput.value;
			/* this part serves for manufacturers because of their difference in slug and name */
			var filterName = ((filter = clickedInput.getAttribute('data-filter'))) ? filter : clickedInput.value;
			// console.log(filterName, field);
			cpQuickrefineEventsObj.syncFieldWithFilter(filterName, field);
		}
	}


	this.isInt = function(n) {
	   return n % 1 === 0;
	}

}
