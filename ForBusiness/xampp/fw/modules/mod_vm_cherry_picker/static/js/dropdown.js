var cpDropdownLayoutEvents = function(_moduleData) {

	this.moduleData = _moduleData;
	this.toggleFiltersTimeout = [];
	this.delayTimeout = 300;

	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		moduleContainer.addEvents({

			'click:relay(.cp-dd-filter-group-button)': function() {
				obj.processFilterButtonClickEvent(this);
			},

			'mouseenter:relay(.cp-dd-filter-group-button)': function() {
				obj.processFilterButtonMouseEnterEvent(this);
			},


			'mouseleave:relay(.cp-dd-filter-group-button)': function() {
				obj.processFilterButtonMouseLeaveEvent(this);
			},

			'mouseenter:relay(.cp-dd-filter-group)': function() {
				obj.processFilterListMouseEnterEvent(this);
			},

			'mouseleave:relay(.cp-dd-filter-group)': function() {
				obj.processFilterListMouseLeaveEvent(this);
			}

		});

		if (this.moduleData.updateProducts) {
			moduleContainer.addEvents({
				'click:relay(.cp-dd-filter-link)': function(event) {
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
				},

				'submit:relay(form)': function(event) {
					event.preventDefault();

					obj.submitFiltersForm();
				}
			});
		}
	}


	this.processLinkClickEvent = function(clickedFilter) {
		var locationURL = clickedFilter.getAttribute('href');
		cpUpdateResutsViaAjaxObj.updateResults(locationURL);
	}


	this.processFilterButtonClickEvent = function(clickedButton) {
		var index = document.id(clickedButton).getAttribute('data-id');

		this.moduleData.moduleContainer.getElements('.cp-dd-filter-group').addClass('hid');

		clearTimeout(this.toggleFiltersTimeout[index]);
		this.toggleFiltersTimeout[index] = null;

		this.showFilters(clickedButton);
	}

	this.processFilterButtonMouseEnterEvent = function(activeElement) {
		var index = document.id(activeElement).getAttribute('data-id'),
			obj = this;

		if (this.toggleFiltersTimeout[index]) {
			clearTimeout(this.toggleFiltersTimeout[index]);
			this.toggleFiltersTimeout[index] = null;
		} else {
			var button = activeElement;
			this.toggleFiltersTimeout[index] = setTimeout(function() {obj.showFilters(button)}, obj.delayTimeout);
		}
	}

	this.processFilterButtonMouseLeaveEvent = function(activeElement) {
		var index = document.id(activeElement).getAttribute('data-id'),
			obj = this;

		if (document.id(index).hasClass('hid') == false) {
			this.toggleFiltersTimeout[index] = setTimeout(function() {obj.hideFilters(index)}, obj.delayTimeout);
		} else {
			clearTimeout(this.toggleFiltersTimeout[index]);
			this.toggleFiltersTimeout[index] = null;
		}
	}

	this.processFilterListMouseEnterEvent = function(activeElement) {
		var index = document.id(activeElement).id;

		clearTimeout(this.toggleFiltersTimeout[index]);
		this.toggleFiltersTimeout[index] = null;
	}

	this.processFilterListMouseLeaveEvent = function(activeElement) {
		var index = document.id(activeElement).id,
			obj = this;

		this.toggleFiltersTimeout[index] = setTimeout(function() {obj.hideFilters(index)}, obj.delayTimeout);
	}


	this.showFilters = function(filterButton) {
		var buttonContainer = document.id(filterButton),
			id = buttonContainer.getAttribute('data-id'),
			filtersContainer = document.getElementById(id),
			left = buttonContainer.offsetLeft,
			top = buttonContainer.offsetTop + document.id(buttonContainer).getHeight();

		if (this.moduleData.loadDropdownFiltersWithAjax && filtersContainer.getAttribute('data-loaded') == 0)
			this.loadFilters(filtersContainer);

		filtersContainer.removeClass('hid');
		filtersContainer.setStyles({top: top, left: left});
	}

	this.hideFilters = function(index) {
		this.toggleFiltersTimeout[index] = null;
		document.id(index).addClass('hid');
	}


	this.submitFiltersForm = function() {
		var url = this.moduleData.moduleContainer.getElement('#cp' +
				this.moduleData.moduleID  + '_base_url_with_filters').getAttribute('data-value'),
			form = this.moduleData.moduleContainer.getElement('form'),
			lowPrice = form['low-price'],
			highPrice = form['high-price'];


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


		cpUpdateResutsViaAjaxObj.updateResults(url);
	}

 }
