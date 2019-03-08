var cpSimpleDropdownLayoutProgressiveLoadEvents = function(_moduleData) {

	this.moduleData = _moduleData;

	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		moduleContainer.addEvents({
			'change:relay(select.cp-filter-select)': function() {
				if (this.getAttribute('data-type') == 'manufacturer')
					return;
				obj.processSelectboxChangeEvent(this);
			},

			'submit:relay(form)': function(event) {
				event.preventDefault();
				obj.submitFiltersForm();
			}
		});

		if (this.moduleData.updateProducts) {
			moduleContainer.addEvents({

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



	this.processSelectboxChangeEvent = function(changedSelectbox) {
		var parentGroupElement = changedSelectbox.getParent('.cp-group-parent'),
			groupSelectElements = parentGroupElement.getElements('.cp-filter-select'),
			nextSelectElement,
			// nextGroupElement,
			loadFilters = true;
			// filtersSelection = [],
			// form = this.moduleData.filtersForm,
			// form = this.moduleData.moduleContainer.getElement('form'),
			// lowPrice = form['low-price'],
			// highPrice = form['high-price'];

		for (var i = 0, j = groupSelectElements.length; i < j; i++) {
			// if (groupSelectElements[i].value)
			// 	filtersSelection.push(groupSelectElements[i].name + '=' + encodeURIComponent(groupSelectElements[i].value));

			if (groupSelectElements[i] == changedSelectbox) {
				if (i == (j - 1)) {
					// this is the last select element
					if (this.moduleData.progressiveLoadAutosubmit) {
						if (this.moduleData.updateProducts) {
							var url = this.getAppliedRefinementsURL();
							cpUpdateResutsViaAjaxObj.updateProductsOnly(url);
						} else {
							this.submitFiltersForm();
						}
					}

					return;
				} else {
					nextSelectElement = groupSelectElements[i + 1];
					// nextGroupElement = nextSelectElement.getParent('.cp-filters-group-container');
				}

				var k;
				if (changedSelectbox.value == '') {
					loadFilters = false;
					k = i + 1;
				} else {
					k = i + 1; // was k = i + 2
				}

				for (k; k < j; k++) {
					// groupSelectElements[k].innerHTML = emptySelectElementHTML;
					for (var optI = 1, optLen = groupSelectElements[k].options.length; optI < optLen; optI++) {
						groupSelectElements[k].options[1].destroy();
					}
					groupSelectElements[k].setAttribute('disabled', 'disabled');
				}

				break;
			}
		}

		// console.log(filtersSelection);

		if (loadFilters) {
			this.loadFiltersForNextSelectbox(nextSelectElement);
			if (this.moduleData.updateProducts && this.moduleData.updateEachStep) {
				var url = this.getAppliedRefinementsURL();
				cpUpdateResutsViaAjaxObj.updateProductsOnly(url);
			}
		}

	}



	this.loadFiltersForNextSelectbox = function(nextSelectElement) {
		var selectElements = this.moduleData.moduleContainer.getElements('.cp-filter-select'),
			form = this.moduleData.moduleContainer.getElement('form'),
			lowPrice = form['low-price'],
			highPrice = form['high-price'],
			nextGroupElement = nextSelectElement.getParent('.cp-filters-group-container'),
			imageLoader = nextGroupElement.getElement('.cp-group-loader').getElement('img'),
			selection = [];


		var parameters = 'action_type=simple_dropdown_next_filters&ptids=' +
			this.moduleData.productTypeIDs + '&module_id=' + this.moduleData.moduleID;
		parameters += '&data_value=' + nextSelectElement.name;
		parameters += '&' + cpEnvironmentValues.getEnvironmentValues();
		if (lowPrice) parameters += '&low-price=' + lowPrice.value;
		if (highPrice) parameters += '&high-price=' + highPrice.value;


		selectElements.each(function(selectElement) {
			if (selectElement.value) selection.push(selectElement.name + '=' + encodeURIComponent(selectElement.value));
		});
		parameters += '&' + selection.join('&');



		new Request.HTML ({
			url: cp_fajax,
			method: 'get',
			data: parameters,
			onRequest: function() {
				imageLoader.removeClass('hid');
			},
			onComplete: function() {
				imageLoader.addClass('hid');
				nextSelectElement.removeAttribute('disabled');
			},
			update: nextSelectElement
		}).send();

	}


	this.getAppliedRefinementsURL = function() {
		var url = this.moduleData.moduleContainer.getElement('#cp' +
				this.moduleData.moduleID  + '_base_url').getAttribute('data-value'),
			selectElements = this.moduleData.moduleContainer.getElements('.cp-filter-select'),
			appliedStaticFilterInputs = this.moduleData.moduleContainer.getElements('.hidden-static-filter'),
			form = this.moduleData.moduleContainer.getElement('form'),
			selection = [],
			lowPrice = form['low-price'],
			highPrice = form['high-price'];


		selectElements.each(function(selectElement) {
			if (selectElement.value) selection.push(selectElement.name + '=' + encodeURIComponent(selectElement.value));
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


	this.submitFiltersForm = function() {
		if (this.moduleData.updateProducts) {
			var url = this.getAppliedRefinementsURL();
			cpUpdateResutsViaAjaxObj.updateResults(url);
		} else {
			var selectElements = this.moduleData.moduleContainer.getElements('.cp-filter-select'),
				form = this.moduleData.moduleContainer.getElement('form');

			selectElements.each(function(selectElement) {
				if (selectElement.value == '') selectElement.setProperty('disabled', true);
			});

			var lowPrice = form['low-price'],
				highPrice = form['high-price'];
			if (lowPrice && lowPrice.value == "") lowPrice.setProperty('disabled', true);
			if (highPrice && highPrice.value == "") highPrice.setProperty('disabled', true);

			form.submit();
		}
	}

}
