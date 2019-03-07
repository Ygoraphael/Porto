function cpSimpleListLayoutEvents(_moduleData) {

	this.moduleData = _moduleData;


	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;
		
		moduleContainer.addEvents({
			'submit:relay(form)': function(event) {
				event.preventDefault();
			
				obj.submitFiltersForm();
			}
		});


		if (this.moduleData.updateProducts) {
			moduleContainer.addEvents({	
				'click:relay(.cp-filter-link)': function(event) {
					event.preventDefault();
					obj.processLinkClickEvent(this);
				},

				'click:relay(.cp-color-palette-element)': function(event) {
					event.preventDefault();
					obj.processLinkClickEvent(this);
				},
				
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


	this.processLinkClickEvent = function(clickedFilter) {
		var locationURL = clickedFilter.getAttribute('href');
		cpUpdateResutsViaAjaxObj.updateResults(locationURL);
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

/*
	this.getAppliedRefinementsURL = function() {
		var url = this.moduleData.moduleContainer.getElement('#cp' +
				this.moduleData.moduleID  + '_base_url_with_filters').getAttribute('data-value'),
			form = this.moduleData.moduleContainer.getElement('form'),
			lowPrice = form['low-price'],
			highPrice = form['high-price'];


						var groupInputs = this.moduleData.moduleContainer.getElements('.hidden-filter'),
							form = this.moduleData.moduleContainer.getElement('form');

						groupInputs.each(function(groupInput) {
							if (groupInput.value == '') groupInput.destroy();
						});

		
		// can't use simple .setData() because MT double converts URL:
		// value=foo+bar becomes value=foo%2Bbar
		var prices = [];

		if (lowPrice && lowPrice.value) prices.push('low-price=' + lowPrice.value);
		if (highPrice && highPrice.value) prices.push('high-price=' + highPrice.value);
		// if (lowPrice && lowPrice.value) uri.setData('low-price', lowPrice.value);
		// if (highPrice && highPrice.value) uri.setData('high-price', highPrice.value);

		if (prices.length) {
			var uri = new URI(url);
			var query = uri.get('query');
			if (query != "") query += '&';
			query += prices.join('&');
			uri.set('query', query);

			url = uri.toAbsolute();
		}

		return url;
	}
*/


	this.getAppliedRefinementsURL = function() {
		var url = this.moduleData.moduleContainer.getElement('#cp' +
				this.moduleData.moduleID  + '_base_url').getAttribute('data-value'),
				//this.moduleData.moduleID  + '_base_url_with_filters').getAttribute('data-value'),
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
		var elements = filtersContainer.getElements('.cp-filter-filter');
		var len = elements.length;

		while (len--) {
			if (elements[len].textContent == filterName) {
				// before page reloads we want to mark filter appropriately
				var applied = elements[len].hasClass('selected');
				if (applied) {
					elements[len].removeClass('selected');
					elements[len].parentNode.firstChild.removeClass('selected');
				} else {
					elements[len].addClass('selected');					
					elements[len].parentNode.firstChild.addClass('selected');
				}

				if (this.moduleData.updateProducts)
					this.processLinkClickEvent(elements[len].parentNode);
				else {
					elements[len].parentNode.click();
					// console.log(elements[len].parentNode);
					// alternative could be:
					// location.href = getElements[len].parentNode.href;
				}
				// break;
				return;
			}
		}

		// if here no element found, so let's remove element from the URL directly
		var uri = new URI(location.href);
		var parts = uri.get('query').split('&');
		var len = parts.length;
		if (len) {
			var result_parts = [];
			for (var i = 0; i < len; ++i) {
				var split = parts[i].split('=');
				if (split[0] == groupName) {
					var applied = decodeURIComponent(split[1]).split('|');
					applied.splice(applied.indexOf(filterName), 1);
					if (applied.length) {
						result_parts.push(split[0] + '=' + encodeURIComponent(applied.join('|')));
					}
				} else
					result_parts.push(parts[i]);
			}

			if (result_parts.length)
				uri.set('query', result_parts.join('&'));
			else
				uri.set('query', '');

			var newLocation = uri.toString();
			if (this.moduleData.updateProducts)
				cpUpdateResutsViaAjaxObj.updateResults(newLocation);
			else
				location.href = newLocation;
			
		}
		
	}


	this.isFilterApplied = function(filterName) {
		if (! filterName)
			return false;

		var appliedElements = this.moduleData.moduleContainer.getElements('.cp-filter-filter.selected');
		var len = appliedElements.length;
		
		if (! len)
			return false;

		while (len--) {
			if (appliedElements[len].textContent == filterName)
				return true;
		}

		return false;
	}

}
