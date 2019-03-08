var cpSimpleDropdownLayoutSelfUpdateEvents = function(_moduleData) {

	this.moduleData = _moduleData;

	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		moduleContainer.addEvents({
			'change:relay(select.cp-filter-select)': function() {
				obj.processSelectboxChangeEvent();
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


	this.processSelectboxChangeEvent = function() {

		if (this.moduleData.updateProducts && this.moduleData.updateEachStep) {
			var url = this.getAppliedRefinementsURL();
			// cpUpdateResutsViaAjaxObj.updateProductsOnly(url);
			cpUpdateResutsViaAjaxObj.updateResults(url);
		} else {
			this.updateModule();
		}

	}


	// this.processSelectboxChangeEvent = function() {
	this.updateModule = function() {
		var selectElements = this.moduleData.moduleContainer.getElements('.cp-filter-select'),
			// updateBlock = this.moduleData.moduleContainer.getFirst(),
			form = this.moduleData.moduleContainer.getElement('form'),
			filtersSelection = [],
			parameters = '',
			lowPrice = form['low-price'],
			highPrice = form['high-price'],
			blanket = this.moduleData.moduleContainer.getElement('.cp-sdd-blanket');


		selectElements.each(function(selectElement) {
			if (selectElement.value) filtersSelection.push(selectElement.name + '=' + encodeURIComponent(selectElement.value));
		});

		// parameters = 'sdd_with_ajax=1&action_type=simple_dropdown_update&ptids=' +
		parameters = 'action_type=load_module&ptids=' +
			this.moduleData.productTypeIDs + '&module_id=' + this.moduleData.moduleID;
		parameters += '&' + cpEnvironmentValues.getEnvironmentValues();
		if (lowPrice) parameters += '&low-price=' + lowPrice.value;
		if (highPrice) parameters += '&high-price=' + highPrice.value;
		parameters += '&' + filtersSelection.join('&');

		var obj = this;
		new Request.HTML ({
			url: cp_fajax,
			method: 'get',
			data: parameters,
			evalScripts: false,
			onRequest: function() {
				blanket.removeClass('hid');
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				// console.log(responseElements);
				// console.log(responseJavaScript);
				var container = responseElements[0];
				obj.moduleData.moduleContainer.innerHTML = container.innerHTML;
				eval(responseJavaScript);
				blanket.addClass('hid');

			}
			// onComplete: function() {
			// 	blanket.addClass('hid');
			// },
			// update: updateBlock
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
			// cpUpdateResutsViaAjaxObj.updateResults(url);
			cpUpdateResutsViaAjaxObj.updateProductsOnly(url);
		} else {
			var selectElements = this.moduleData.moduleContainer.getElements('.cp-filter-select'),
				form = this.moduleData.moduleContainer.getElement('form');

			selectElements.each(function(selectElement) {
				// if (selectElement.value == '') selectElement.name='';
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
