var cpParameterTrackbarEvents = function(_moduleData) {

	this.moduleData = _moduleData;


	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		moduleContainer.addEvents({

			'click:relay(.cp-tb-label-value)': function() {
				obj.clearTrackbarSelection(this);
			},

			'mouseenter:relay(.cp-tb-label-value)': function() {
				var hoverOn = true;
				obj.toggleClearSelectionPrompt(this, hoverOn);
			},

			'mouseleave:relay(.cp-tb-label-value)': function() {
				var hoverOut = false;
				obj.toggleClearSelectionPrompt(this, hoverOut);
			},

			'click:relay(.cp-tb-label-button)': function() {
				obj.applyTrackbarSelection();
			}
		});
	}


	this.toggleClearSelectionPrompt = function(hoveredElement, hover) {
		// var parameterTrackbar = chp[hoveredElement.getAttribute('data-paramname')],
		var id = this.moduleData.moduleID,
			parameterTrackbar = cpTrackbars[hoveredElement.getAttribute('data-paramname') + id],
			out = false,
			hoverClass = "cp-tb-label-value-clear";

		if (hover == out) {
			document.id(hoveredElement).removeClass(hoverClass);
			return;
		}

		if (parameterTrackbar.options.valueLeft == null && parameterTrackbar.options.valueRight == null) return;

		document.id(hoveredElement).addClass(hoverClass);
	}


	this.clearTrackbarSelection = function(clickedElement) {
		// var parameterTrackbar = chp[clickedElement.getAttribute('data-paramname')];
		var id = this.moduleData.moduleID,
			parameterTrackbar = cpTrackbars[clickedElement.getAttribute('data-paramname') + id];

		if (parameterTrackbar.options.valueLeft == null && parameterTrackbar.options.valueRight == null) return;

		parameterTrackbar.options.valueLeft = null;
		parameterTrackbar.options.valueRight = null;
		parameterTrackbar.update();
		this.applyTrackbarSelection();
	}


	this.applyTrackbarSelection = function() {
		if (this.moduleData.updateProducts) {
			var url = this.getAppliedRefinementsURL();
			cpUpdateResutsViaAjaxObj.updateResults(url);
		} else {
			var form = this.moduleData.moduleContainer.getElement('form');
				hiddenInputs = form.getElements("input[type='hidden']"),
				highPrice = form['high-price'],
				lowPrice = form['low-price'];

			for (i = 0, j = hiddenInputs.length; i < j; ++i) {
				if (hiddenInputs[i].value == '') document.id(hiddenInputs[i]).destroy();
			}

			if (highPrice && highPrice.value == '') highPrice.name = '';
			if (lowPrice && lowPrice.value == '') lowPrice.name='';

			// if (cpSelfUpdating) {
			// 	ChP2.updateFilters2(f);
			// } else {
				form.submit();
			// }
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


		appliedStaticFilterInputs.each(function(input) {
			if (input.value) selection.push(input.name + '=' + encodeURIComponent(input.value));
		});

		groupInputs.each(function(groupInput) {
			if (groupInput.value) selection.push(groupInput.name + '=' + encodeURIComponent(groupInput.value));
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

}
