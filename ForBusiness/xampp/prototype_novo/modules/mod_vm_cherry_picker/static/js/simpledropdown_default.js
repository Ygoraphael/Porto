function cpSimpleDropdownLayoutDefaultEvents(_moduleData) {

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

				'change:relay(select.cp-filter-select)': function() {
					obj.processSelectboxChangeEvent();
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



	this.processSelectboxChangeEvent = function() {
		if (this.moduleData.updateEachStep) {
			var url = this.getAppliedRefinementsURL();
			cpUpdateResutsViaAjaxObj.updateProductsOnly(url);
		}
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
			// cpUpdateResutsViaAjaxObj.updateProductsOnly(url);
			cpUpdateResutsViaAjaxObj.updateResults(url);
		} else {
			var selectElements = this.moduleData.moduleContainer.getElements('.cp-filter-select'),
				form = this.moduleData.moduleContainer.getElement('form');

			selectElements.each(function(selectElement) {
				// if (selectElement.value == '') selectElement.name = '';
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
