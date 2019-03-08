//console.log('basicEvents loaded');
window.addEvent('domready', function() {


	$('searchBarContainer').addEvents({

		'submit:relay(#searchForm)': function(event) {
			event.preventDefault();

			var keyword = document.searchForm.q.value;
			doProductSearch(keyword);
		},

		'click:relay(#search-xbtn)': function() {
			doProductSearch('');
		}

	});


	var showRemoveProductTypeDialogTimer;

	$('productsAndNavigation').addEvents({

		'click:relay(.fs-cell-tick)': function() {
			toggleRowSelected(this);
		},

		'click:relay(.ui-namecell-pdesc)': function() {
			showProductDescriptionInPopup(this);
		},

		// 'click:relay(.ui-namecell-product-image)': function() {
		//	showProductDescriptionInPopup(this);
		// },

		'mouseenter:relay(.ui-namecell-showchildren)': function() {
			toggleShowChildrenLinkText(this);
		},

		'mouseleave:relay(.ui-namecell-showchildren)': function() {
			toggleShowChildrenLinkText(this);
		},

		'click:relay(.ui-namecell-showchildren)': function() {
			showChildrenProducts(this);
		},

		'mouseenter:relay(.fs-cell-name)': function() {
			//console.log(this);
			toggleHiddenCurtain(this, 1);
		},

		'mouseleave:relay(.fs-cell-name)': function() {
			//console.log(this);
			toggleHiddenCurtain(this, 0);
		},

		'click:relay(.fs-cell-name)': function(event) {
			// return false, if event fired on certain elements
			if (event.target.hasClass('ui-namecell-pdesc')) return;
			// if (event.target.hasClass('ui-namecell-product-image')) return;
			if (event.target.hasClass('ui-namecell-showchildren')) return;

			toggleHiddenFilters(this);
		},


		'click:relay(.pt-tab)': function() {
			showProductProductType(this);
		},

		'dblclick:relay(.pt-tab)': function(event) {
			clearTimeout(showRemoveProductTypeDialogTimer);
			showRemoveProductTypeFromProductDialog(this, event);
		},

		'mouseenter:relay(.pt-tab)': function(event) {
			var button = this;
			showRemoveProductTypeDialogTimer = setTimeout(function() {
				showRemoveProductTypeFromProductDialog(button, event)
			}, 1000);
		},

		'mouseleave:relay(.pt-tab)': function(event) {
			clearTimeout(showRemoveProductTypeDialogTimer);
		},


		'click:relay(#pt-remove-confirm)': function() {
			var activeTab = simplePopup.activeButton;
			removeProductTypeFromProduct(activeTab);
		},

		'click:relay(#pt-remove-cancel)': function() {
			// simplePopup.removeMenu();
			// simplePopup.removeBoundEvent();
			simplePopup.hidePopupMenu();
		},

		'click:relay(.pt-tab-addnew)': function() {
			processAddNewProductTypeEvent(this);
			//addNewProductType(this);
		},


		'click:relay(.pt-select-button)': function(event) {
			var menu = $('productTypeSelectMenu'),
				button = this,
				buttonActiveClass = 'active';

			simplePopup.showMenu({
				button: button,
				menu: menu,
				align: 'left',
				buttonActiveClass: buttonActiveClass,
				event: event
			});
		},

		'click:relay(.pt-select-menu-list-elem)': function() {
			//assignProductTypeToProduct(this);
			processAssignProductTypeToProductEvent(this);
		},


		'click:relay(.filter-select-button)': function(event) {
			var menu = $('filterSelectMenu'),
				button = this,
				buttonActiveClass = 'active';


			//var boundSaveParameterFilters = saveParameterFilters.bind(button);
			var boundSaveParameterFilters = processSaveParameterFiltersEvent.bind(button);

			simplePopup.showMenu({
				button: button,
				menu: menu,
				align: 'left',
				buttonActiveClass: buttonActiveClass,
				onMenuRemove: boundSaveParameterFilters,
				event: event
			});

			// order matters! these lines must be below popupMenu call
			button.setProperty('data-edited', 0);
			activeFilterButton = button;

			if (button.hasClass(buttonActiveClass)) loadFiltersForParameter(button);
		},

		'keydown:relay(#filterInputBoxInput)': function(event) {
			var key = event.code,
				semiColon = (key == 59 || key == 186);

			// console.log(event.code);

			if (key == 9) {
				//tab
				event.preventDefault();
			} else if (key == 13) {
				//enter
				event.preventDefault();
				//addEnteredFilter();
				processAddEnteredFilterEvent();
				refineAvailableFilters();
			} else if (semiColon && event.shift == false) {
				// do not let enter some characters (;)
				event.preventDefault();
			}

		},

		'keyup:relay(#filterInputBoxInput)': function(event) {
			var key = event.code;
			var blockKeys = [13, 37, 38, 39, 40];

			// if (key != 13) {
			if (blockKeys.indexOf(key) == -1) {
				adjustInputWidth();
				refineAvailableFilters();
			}
		},

		'click:relay(.filter-input-box-filter)': function() {
			processRemoveEneteredFilterEvent(this);
			//removeEneteredFilter(this);
		},

		'click:relay(#filterInputBox)': function() {
			$('filterInputBoxInput').focus();
		},

		'click:relay(.available-filters-filter)': function(event) {
			event.preventDefault();
			processAddOrRemoveClickedFilterEvent(this);
			//addOrRemoveClickedFilter(this);
		},

		'click:relay(.page-nav-element)': function() {
			setPage(this);
		},

		'click:relay(#showOnPageButton)': function(event) {
			var menu = $('showonpage-menu'),
				button = this,
				buttonActiveClass = 'glass-btn-active';

			simplePopup.showMenu({
				button: button,
				menu: menu,
				align: 'right',
				buttonActiveClass: buttonActiveClass,
				event: event
			});
		},

		'click:relay(.showonpage-menu-item)': function() {
			setShowOnPage(this);
		},

		'click:relay(.pdesc-popup-close-button)': function() {
			var popUp = $('product-description');

			closePopupWindow(popUp);
		}


	});

});


var activeFilterButton = null,
	PARAM_BUTTON_MAXCHAR_LEN = 18,
	PARAM_BUTTON_EDITED_CLASS = 'fsb-edited',
	loadFiltersForParameterAjax = null,
	newProductTypeTabText = '[New Product Type]',
	showChildrenProductsTextDefault = 'Parent',
	showChildrenProductsTextHovered = 'Show Children',
	// showChildrenProductsTextBack = '&larr; Back',
	selectedParameterAvailableFilters = [],
	rowsSelected = 0;

var NO_AVAIL_FILTERS_MSG = '<div style="font:italic 11px Arial, Tahoma;color:#777777;' +
	'margin:10px 0 0 0;text-align:center;">None yet.<br/> Start assigning filters by typing ' +
	'a filter name and pressing <b>Enter</b> on the keyboard.</div>';

var NO_MATCH_MSG = '<div style="font:italic 11px Arial, Tahoma;color:#777777;' +
	'margin:10px 0 15px 0;text-align:center;">No match.</div>';


function doProductSearch(keyword) {
	var form = document.searchForm,
		clearSearch = $('search-xbtn'),
		data;

	setProductDetailsLoading();
	resetRefinePaneState();

	if (keyword == '') {
		clearSearch.addClass('hid');
		form.q.value = '';
		form.q.focus();
	} else {
		clearSearch.removeClass('hid');
	}

	form.skip.value = '';
	data = getParametersToString(false);

	window.location.hash = '#' + data;
	data += '&action=DETAILS_AND_NAV';

	new Request.HTML({
		url: url,
		data: data,
		onComplete: function() {
			//removeTableLoading();
			form.q.focus();
		},
		update: $('productsAndNavigation')
	}).send();
}


function toggleRowSelected(clickedCheckbox) {
	var row = clickedCheckbox.getParent(),
		checkboxImage = clickedCheckbox.getElement('.row-checkbox-img'),
		refinePaneMultiSelectButtonImage = $('selGrpImg');

	if (row.hasClass('rowSelected')) {
		row.removeClass('rowSelected');
		checkboxImage.removeClass('row-checkbox-img-selected');
		rowsSelected--;
	} else {
		row.addClass('rowSelected');
		checkboxImage.addClass('row-checkbox-img-selected');
		rowsSelected++;
	}

	if (rowsSelected == 0) {
		refinePaneMultiSelectButtonImage.setStyle('background-position', '0 0');
	} else if (rowsSelected == currentTotalRows) {
		refinePaneMultiSelectButtonImage.setStyle('background-position', '0 -26px');
	} else {
		refinePaneMultiSelectButtonImage.setStyle('background-position', '0 -65px');
	}

	if ($('notificationBox').hasClass('hid') == false) showNotification('<b>' + rowsSelected + '</b> row(s) selected');
	toggleRemoveProductTypesFromSelectedProductsButton(rowsSelected);
}


function showProductDescriptionInPopup(clickedButton) {
	var pid = clickedButton.getAttribute('data-pid'),
		descriptionCont = $('product-description'),
		descriptionContInner = $('product-description-inner'),
		loaderHTML = '<div class="pdesc-preload">' +
			'<img src="' + fsBaseURL + '/static/img/desc-loader.gif" ' +
			'width="28" height="28" border="0" /></div>';


	if (descriptionCont.hasClass('hid')) descriptionCont.setStyles({
		top: window.getScrollTop() + 70,
		opacity: 1,
		left: 7
	});

	descriptionCont.removeClass('hid');
	var data='i=ASSIGN&action=GET_PRODUCT_DESCRIPTION&pid=' + pid;

	new Request.HTML({
		url: url,
		data: data,
		onRequest: function(){
			descriptionContInner.innerHTML = loaderHTML;
		},
		update: descriptionContInner
	}).send();
}


function toggleShowChildrenLinkText(hoveredElement) {
	if (document.searchForm.ppid.value) {
		return;
	}

	var isHovered = hoveredElement.getAttribute('data-hovered');
	if (isHovered == 1) {
		hoveredElement.innerHTML = showChildrenProductsTextDefault;
		hoveredElement.setProperty('data-hovered', 0);
	} else {
		hoveredElement.innerHTML = showChildrenProductsTextHovered;
		hoveredElement.setProperty('data-hovered', 1);
	}
}


function showChildrenProducts(clickedElement) {
	setProductDetailsLoading();
	resetRefinePaneState();

	var form = document.searchForm;

	if (form.ppid.value) { // back
		form.ppid.value = '';
		form.skip.value = form.old_skip.value;
		form.old_skip.value = '';
		var data = getParametersToString(true);
	} else {
		form.ppid.value = clickedElement.getAttribute('data-pid');
		form.old_skip.value = clickedElement.getAttribute('data-skip');
		form.skip.value = '';
		var data = getParametersToString(false);
	}

	window.location.hash = '#' + data;
	data += '&action=DETAILS_AND_NAV';

	// new Ajax (url,{
	//	method:'get',
	//	data: parameters,
	//	evalScripts:true,
	//	update: $('cmid')
	// }).request();

	new Request.HTML({
		url: url,
		data: data,
		update: $('productsAndNavigation')
	}).send();
}


function toggleHiddenCurtain(nameCell, showCurtain) {
	var rowId = nameCell.getAttribute('data-row'),
		curtain = $(rowId + '-filters-cell').getElement('.pt-curtain'),
		outerCont = $(rowId + '-filters-cell').getElement('.pt-cont-outer'),
		innerCont = $(rowId + '-filters-cell').getElement('.pt-cont-inner');

	if (innerCont.getHeight() > outerCont.getHeight()) {
		if (showCurtain) curtain.addClass('pt-curtain-transparent');
			else curtain.removeClass('pt-curtain-transparent');
	} else if (showCurtain == 0 && curtain.hasClass('pt-curtain-transparent')) {
		// case when MOUSELEAVE from expanded container, curtain remains transparent => collapse all => curtain still transp.
		curtain.removeClass('pt-curtain-transparent');
	}
}

function toggleHiddenFilters(nameCell) {
	var rowId = nameCell.getAttribute('data-row'),
		outerCont = $(rowId + '-filters-cell').getElement('.pt-cont-outer'),
		curtain = $(rowId + '-filters-cell').getElement('.pt-curtain');

	if (outerCont.hasClass('expanded')) {
		outerCont.removeClass('expanded');
		curtain.removeClass('hid');

		toggleHiddenCurtain(nameCell, 1);
	} else {
		outerCont.addClass('expanded');
		curtain.addClass('hid');
	}
}


function showProductProductType(clickedTab) {
	var parentOfTabs = clickedTab.getParent(),
		rowId = parentOfTabs.getAttribute('data-row'),
		allTabs = parentOfTabs.getElements('.pt-tab'),
		containerId = clickedTab.getAttribute('data-contid'),
		ptContainers = $$('#ptContInner_' + rowId + ' .pt-container');

	if (containerId == 'all') {
		ptContainers.removeClass('hid');
	} else {
		ptContainers.addClass('hid');
		var ptContToShow = $(containerId);
		ptContToShow.removeClass('hid');
	}

	allTabs.removeClass('pt-tab-selected');
	clickedTab.addClass('pt-tab-selected');
}


function processAddNewProductTypeEvent(clickedTab) {
	var rowId = clickedTab.getParent().getAttribute('data-row'),
		rowElement = $(rowId + '-row'),
		rowSelected = rowElement.hasClass('rowSelected');

	if (rowSelected) {
		var allSelectedRows = $$('.fs-row.rowSelected');

		allSelectedRows.each(function(row) {
			if (row != rowElement) {
				//console.log(row);
				var addNewTab = row.getElement('.pt-tab-addnew');
				addNewProductType(addNewTab);
			}
		});
	}

	addNewProductType(clickedTab);

}

function addNewProductType(clickedTab) {
	var parentOfTabs = clickedTab.getParent(),
		rowId = parentOfTabs.getAttribute('data-row'),
		allTabs = parentOfTabs.getElements('.pt-tab'),
		selectedTab = parentOfTabs.getElement('.pt-tab-selected'),
		nextNewPTIndex = getNextNewProductTypeIndex(),
		ptContInner = $('ptContInner_' + rowId);

	var div = document.createElement('div');
	div.innerHTML = newPTContHTML;
	var innerDiv = div.getFirst();
	innerDiv.setProperty('id', 'ptCont_ptNew_' + nextNewPTIndex);
	//innerDiv.addClass('hid');
	innerDiv.getElement('.pt-select-button').setProperty('data-row', rowId);

	innerDiv.inject(ptContInner.getElement('.pt-curtain'), 'before');
	div.destroy();

	var newTab = document.createElement('span');
	newTab.id = 'tab_ptCont_ptNew_' + nextNewPTIndex
	newTab.className = 'pt-tab';
	newTab.setProperty('data-contid', 'ptCont_ptNew_' + nextNewPTIndex);
	newTab.innerHTML = newProductTypeTabText;
	newTab.inject(clickedTab, 'before');

	if (selectedTab != null && selectedTab.getAttribute('data-contid') != 'all')
		showProductProductType(newTab);

	return newTab;
}


function processAssignProductTypeToProductEvent(clickedElem) {
	var activeButton = simplePopup.activeButton,
		rowId = activeButton.getAttribute('data-row'),
		rowElement = $(rowId + '-row'),
		rowSelected = rowElement.hasClass('rowSelected');

	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	assignProductTypeToProduct(clickedElem, activeButton);

	if (rowSelected) {
		var allSelectedRows = $$('.fs-row.rowSelected');

		allSelectedRows.each(function(row) {
			if (row != rowElement) {
				var productTypeButton = row.getElement('.pt-select-button ');
				if (productTypeButton) assignProductTypeToProduct(clickedElem, productTypeButton);

			}
		});
	}
}

function assignProductTypeToProduct(clickedElem, productTypeButton) {
	var ptid = clickedElem.getAttribute('data-ptid'),
	//	activeButton = simplePopup.activeButton,
		rowId = productTypeButton.getAttribute('data-row'),
		pid = document[rowId + '-form']['pid'].value,
	//	parentOfTabs = $('ptTabs_' + rowId),
	//	selectedTab = parentOfTabs.getElement('.pt-tab-selected'),
		parentPTCont = productTypeButton.getParent('.pt-container'),
		correspondingTab = $('tab_' + parentPTCont.id);

	//console.log(selectedTab.innerHTML, clickedElem.innerHTML);

	correspondingTab.innerHTML = clickedElem.innerHTML;

//	simplePopup.removeMenu();
//	simplePopup.removeBoundEvent();

	var data = 'i=ASSIGN&action=ASSIGN_PT&pid=' + pid + '&ptid=' + ptid + '&current_row=' + rowId;

	new Request.HTML({
		url: url,
		data: data,
		onComplete: function(responseTree, responseElements) {
			// console.log(responseTree);
			// console.log(responseElements[0]);
			// var div = document.createElement('div');
			// div.adopt(responseTree);
			// var newCont = div.getFirst();
			var newCont = responseElements[0];
			newCont.replaces(parentPTCont);
			correspondingTab.setProperty('data-contid', newCont.id);
			correspondingTab.setProperty('id', 'tab_' + newCont.id);
			// div.destroy();
		}
	}).send();

}


function removeProductTypeFromProduct(activeTab) {
	var //activeTab = simplePopup.activeButton,
		parentOfTabs = activeTab.getParent(),
		containerId = activeTab.getAttribute('data-contid'),
		data = 'i=ASSIGN&action=DELETE_PT_FROM_PRODUCT',
		collectedData = '',
		pid, nextTabToShow;

	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	if (containerId == 'all') {
		var allTabs = parentOfTabs.getElements('.pt-tab');

		for (var i = 1, len = allTabs.length; i < len; i++) {
			var contId = allTabs[i].getAttribute('data-contid'),
				_cont = $(contId),
				_ptid = _cont.getAttribute('data-ptid');

			if (_ptid) {
				collectedData += '&ptid[]=' + _ptid;
				if (pid == null) {
					var _rowId = _cont.getAttribute('data-row');
					pid = document[_rowId + '-form']['pid'].value;
					collectedData += '&pid=' + pid;
				}
			}

			allTabs[i].destroy();
			_cont.destroy();
		}


	} else {

		var container = $(containerId),
			ptid = container.getAttribute('data-ptid');

		if (parentOfTabs.getElement('.pt-tab-selected').getAttribute('data-contid') != 'all') {
			nextTabToShow = activeTab.getNext();
			if (nextTabToShow.hasClass('pt-tab-addnew')) {
				nextTabToShow = activeTab.getPrevious();
				if (nextTabToShow.getAttribute('data-contid') == 'all') nextTabToShow = null;
			}
		}

		if (ptid == null) { // [New Product Type] tab
			activeTab.destroy();
			container.destroy();
		} else {
			var recordId = container.getAttribute('data-recordid'),
				rowId = container.getAttribute('data-row');

			pid = document[rowId + '-form']['pid'].value;
			collectedData = '&ptid[]=' + ptid + '&record_id=' + recordId + '&pid=' + pid;

			activeTab.destroy();
			container.destroy();
		}
	}

	if (collectedData) {
		data += collectedData;
		//console.log('send ajax:' + data);

		new Request({
			url: url,
			data: data
		}).send();
	}


	// we could have deleted all tabs (except 'All' tab). Check whether we need to add empty Tab.
	if (parentOfTabs.getElements('.pt-tab').length < 2) {
		var addNewPTTab = parentOfTabs.getElement('.pt-tab-addnew');
		var newTab = addNewProductType(addNewPTTab);

		showProductProductType(newTab);
		//console.log(newTab);
	} else if (nextTabToShow) {
		showProductProductType(nextTabToShow);
	}


}


function showRemoveProductTypeFromProductDialog(button, event) {
	var allTabs = button.getParent().getElements('.pt-tab ');
		tabsCount = allTabs.length,
		container = $(allTabs[tabsCount - 1].getAttribute('data-contid'));

	// do not delete the only [New Product Type] tab
	if (tabsCount < 3 && container.getAttribute('data-ptid') == null) return;

	var menu = $('productTypeRemoveMenu');

	$('pt-remove-confirm').innerHTML = "Delete " + button.innerHTML;

	simplePopup.showMenu({
		button: button,
		menu: menu,
		align: 'center',
		valign: 'top',
		event: event
	});
}



// parameter filters implementation

function loadFiltersForParameter(button) {
	var uniqueId = $(button).getAttribute('data-uniqueid'),
		paramInput = $('paramInput_' + uniqueId),
		valuesStr = paramInput.value,
		list = $('filterInputBox'),
		listElements = list.getChildren(),
		inputBox = $('filterInputBoxInput');


	for (var i = 0, len = listElements.length - 1; i < len; i++) {
		listElements[i].destroy();
	}


	if (valuesStr) {
		var values = valuesStr.split(';');

		var len = values.length;
		while (len--) {
			if (trim(values[len]) == '') continue;

			var li = document.createElement('li');
			li.className = 'filter-input-box-elem';
			li.innerHTML = '<span class="filter-input-box-filter" title="Click to remove">' + values[len] + '</span>';
			li.inject(list, 'top');
		}
	}

	inputBox.value = '';
	adjustInputWidth();
	inputBox.focus();

	var paramName = paramInput.getAttribute('data-name'),
		parentCont = button.getParent('.pt-container'),
		rowId = parentCont.getAttribute('data-row'),
		ptid = parentCont.getAttribute('data-ptid'),
		data = 'i=ASSIGN&action=GET_FILTERS_FOR_PARAM';

	data += '&param_name=' + paramName + '&ptid=' + ptid + '&filters=' +
		encodeURIComponent(valuesStr) + '&uniqueid=' + uniqueId;

	if (loadFiltersForParameterAjax) {
		loadFiltersForParameterAjax.cancel();
		loadFiltersForParameterAjax = null;
	}

	var availableFiltersCont = $('availableFilters');
	loadFiltersForParameterAjax = new Request({
		url: url,
		data: data,
		onRequest: function() {
			var c = availableFiltersCont.getElement('.param-filters');
			if (c) c.addClass('semi-transparent');
		},
		onComplete: function(r) {
			// availableFiltersCont.innerHTML = r;
			// build table of filters from response string
			var updateMenu = function() {
				var heightOuter = availableFiltersCont.getHeight(),
					heightInner = availableFiltersCont.getFirst().getHeight(),
					widthOuter = availableFiltersCont.getWidth();

				if (heightOuter < heightInner) availableFiltersCont.addClass('available-filters-scroll')
					else availableFiltersCont.removeClass('available-filters-scroll');

				var maxWidth = (widthOuter > filterInputBoxDefaultMaxWidth) ? widthOuter : filterInputBoxDefaultMaxWidth;
				list.setStyle('max-width', maxWidth);

				simplePopup.repositionMenuIfNeeded();
			}

			var array = (r) ? r.split(';') : [];
			selectedParameterAvailableFilters = array;
			buildTableOfAvailableFilters(array, updateMenu);
		}
	}).send();


	// set parameter label title
	var parameterTitleCont = $('filterParameterLabel'),
		paramLabel = button.getAttribute('data-label'),
		title = (paramLabel == '') ? paramName : paramLabel;

	parameterTitleCont.innerHTML = title + "'s filters:"; //' [' + paramName + ']'

}


function buildTableOfAvailableFilters(filters_array, callback) {

	var mainCont = $('availableFilters');
	var	filters_count = filters_array.length,
		columns_num = 3,
		filters_per_column,
		remaining_filters;

	if (filters_count == 0) {
		if (selectedParameterAvailableFilters.length == 0)
			mainCont.innerHTML = '<div class="param-filters">' + NO_AVAIL_FILTERS_MSG + '</div>';
		else
			mainCont.innerHTML = '<div class="param-filters">' + NO_MATCH_MSG + '</div>';
		return;
	}

	var uniqueId = $(simplePopup.activeButton).getAttribute('data-uniqueid'),
		selected_filters_str = $('paramInput_' + uniqueId).value,
		selected_filters = selected_filters_str.split(';');

	filters_per_column = Math.floor(filters_count / columns_num);
	remaining_filters = filters_count % columns_num;
	// if filters count less then columns number
	if (filters_per_column == 0) {
		filters_per_column = 1;
		remaining_filters = 0;
	}

	// clean previous data
	mainCont.innerHTML = '';
	var innerCont = document.createElement('div');
	innerCont.className = 'param-filters';

	var curr_filter = 0;
	for (var i = 0; i < columns_num && curr_filter < filters_count; ++i) {

		var columnElement = document.createElement('div');
		columnElement.className = 'available-filters-column';

		for (var j = 0; j < filters_per_column; ++j, ++curr_filter) {
			var selected = (selected_filters.indexOf(filters_array[curr_filter]) != -1) ? ' selected' : '';
			var filterElement = document.createElement('a');
			filterElement.setProperty('href', '#');
			filterElement.className = 'available-filters-filter' +  selected;
			filterElement.innerHTML = '<span class="available-filters-tick' + selected + '"></span>' +
				'<span class="available-filters-value">' + filters_array[curr_filter] + '</span>';
			columnElement.appendChild(filterElement);
		}

		if (remaining_filters) {
			var next_filter_index = curr_filter++;
			var selected = (selected_filters.indexOf(filters_array[next_filter_index]) != -1) ? ' selected' : '';
			var filterElement = document.createElement('a');
			filterElement.setProperty('href', '#');
			filterElement.className = 'available-filters-filter' +  selected;
			filterElement.innerHTML = '<span class="available-filters-tick' + selected + '"></span>' +
				'<span class="available-filters-value">' + filters_array[next_filter_index] + '</span>';
			columnElement.appendChild(filterElement);
			--remaining_filters;
		}

		innerCont.appendChild(columnElement);
	}

	mainCont.appendChild(innerCont);
	if (callback) callback();
}


function adjustInputWidth() {
	var input = $('filterInputBoxInput'),
		inputBox = $('filterInputBox'),
		//maxWidth = inputBox.getWidth() - 8,
		maxWidth = inputBox.getStyle('max-width').toInt() - 8,
		width;

	var style_block = "position:absolute;left:-1000px;top:-1000px;";
	var styles = ['font-size', 'font-style', 'font-weight', 'font-family', 'line-height', 'text-transform', 'letter-spacing'];
	for (var _i = 0, _len = styles.length; _i < _len; _i++) {
		style = styles[_i];
		style_block += style + ":" + input.getStyle(style) + ";";
	}

	var div = document.createElement('div');
	div.setProperty('style', style_block);
	div.innerHTML = input.value;
	document.body.appendChild(div);
	width = div.getWidth();

//	console.log(width, maxWidth);

	div.destroy();

	width += 25;
	if (width > maxWidth) width = maxWidth;

	input.setStyle('width', width);
}

/*
function refineAvailableFilters() {
	var input = $('filterInputBoxInput'),
		keyword = trim(input.value),
		filtersCont = $('availableFilters'),
		filtersList = filtersCont.getElements('.available-filters-value');

	if (filtersCont.getFirst().hasClass('semi-transparent')) return;

	console.log('refining..');
	var time_start = +new Date(),
		stop;

	if (keyword == '') {
		for (var i = 0, len = filtersList.length; i < len; i++) {
			filtersList[i].getParent().removeClass('hid');
		}
		return;
	};

	keyword = keyword.toLowerCase();
	var matchAtLeastOne = false;

	// for (var i = 0, len = filtersList.length; i < len; i++) {
	for (var i = filtersList.length; i--; ) {

		var filtersParent = filtersList[i].getParent();

		// if (filtersParent.hasClass('selected')) {
		//	filtersParent.addClass('hid');
		//	continue;
		// }

		var match = filtersList[i].innerHTML.toLowerCase().indexOf(keyword);
		if (match == -1) {
			filtersParent.addClass('hid');
			//console.log(filtersList[i], match);
		} else {
			matchAtLeastOne = true;
			filtersParent.removeClass('hid');
		}
	}

	if (!matchAtLeastOne) {
		// for (var i = 0, len = filtersList.length; i < len; i++) {
		for (var i = filtersList.length; i--; ) {
			filtersList[i].getParent().removeClass('hid');
		}
	}

	time_stop = +new Date();
	console.log("Took: " + (time_stop - time_start) + " milliseconds");

	//console.log(keyword);
}
*/


function refineAvailableFilters() {
	var haystack = selectedParameterAvailableFilters,
		filters_count = haystack.length;

	// Really? Don't refine filters if there are not much of them.
	if (filters_count < 4)
		return;

	// var time_start = +new Date(),
	//	time_stop;

	var input = $('filterInputBoxInput'),
		needle = trim(input.value).toLowerCase();

	if (needle == '') {
		buildTableOfAvailableFilters(haystack, null);
		return;
	};

	var matched_filters = [];
	for (var i = 0; i < filters_count; ++i) {
		var pos = haystack[i].toLowerCase().indexOf(needle);
		if (pos != -1)
			matched_filters.push(haystack[i]);
	}

// time_stop = +new Date();
// console.log("Took: " + (time_stop - time_start) + " milliseconds");
// console.log(matched_filters);

	buildTableOfAvailableFilters(matched_filters, null);
}


function processAddEnteredFilterEvent() {
	var input = $('filterInputBoxInput'),
		filter = input.value,
		//inputBox = $('filterInputBox'),
		newFilterElement = document.createElement('li'),
		parameterButton = $(simplePopup.activeButton),
		parameterName = parameterButton.getAttribute('data-name'),
		parentPTCont = parameterButton.getParent('.pt-container'),
		ptid = parentPTCont.getAttribute('data-ptid'),
		rowElement = parameterButton.getParent('.fs-row'),
		rowSelected = rowElement.hasClass('rowSelected');


	if (trim(filter) == '') return;

	input.value = '';
	adjustInputWidth();

	newFilterElement.className = 'filter-input-box-elem';
	newFilterElement.innerHTML = '<span class="filter-input-box-filter" title="Click to remove">' + filter + '</span></li>';

	newFilterElement.inject(input.getParent(), 'before');

	addEnteredFilter(parameterButton, filter);

	if (rowSelected) {
		 var allSelectedRows = $$('.fs-row.rowSelected');

		 allSelectedRows.each(function(row) {
			if (row != rowElement) {
				//var ptContainers = row.getElements('.pt-container');
				var ptContainers = row.getElements('.pt-container[data-ptid="' + ptid + '"]');

				//console.log(ptContainers);

				ptContainers.each(function(ptContainer) {
					var contParamButton = ptContainer.getElement('.filter-select-button[data-name="' + parameterName + '"]');

					addEnteredFilter(contParamButton, filter);
				});
			}
		 });

	}

}

function addEnteredFilter(parameterButton, filter) {
	var uniqueId = parameterButton.getAttribute('data-uniqueid'),
		paramInput = $('paramInput_' + uniqueId),
		appliedFilters = [],
		appliedFiltersCount = 0;

	if (paramInput.value) appliedFilters = paramInput.value.split(';');
	var matchIndex = appliedFilters.indexOf(filter);

	if (matchIndex == -1) {
		appliedFilters.push(filter);
		appliedFiltersCount = appliedFilters.length;

		if (appliedFiltersCount > 1) {
			var countElem = parameterButton.getElement('.filter-select-button-count');
			if (countElem) {
				countElem.innerHTML = appliedFiltersCount;
			} else {
				countElem = document.createElement('sup');
				countElem.className = 'filter-select-button-count';
				countElem.innerHTML = appliedFiltersCount;

				countElem.inject(parameterButton, 'top');

			}
		}

		paramInput.value = appliedFilters.join(';');
		parameterButton.getElement('.filter-select-button-value').innerHTML =
			squeeze(appliedFilters.join(';'), PARAM_BUTTON_MAXCHAR_LEN);
		parameterButton.setProperty('data-edited', 1);
		parameterButton.addClass(PARAM_BUTTON_EDITED_CLASS);
	}
}


function processRemoveEneteredFilterEvent(clickedSpan) {
	var li = clickedSpan.getParent(),
		filterName = clickedSpan.innerHTML,
		parameterButton = simplePopup.activeButton,
		parameterName = parameterButton.getAttribute('data-name'),
		availableFilterElements = $$('#availableFilters .available-filters-value'),
		parentPTCont = parameterButton.getParent('.pt-container'),
		ptid = parentPTCont.getAttribute('data-ptid'),
		rowElement = parameterButton.getParent('.fs-row'),
		rowSelected = rowElement.hasClass('rowSelected');

	//li.destroy();
	li.addClass('hid');

	for (var i = 0, len = availableFilterElements.length; i < len; i++) {
		if (availableFilterElements[i].innerHTML == filterName) {
			availableFilterElements[i].getPrevious().removeClass('selected');
			availableFilterElements[i].getParent().removeClass('selected');
			break;
		}
	}

	removeEneteredFilter(parameterButton, filterName);

	if (rowSelected) {
		 var allSelectedRows = $$('.fs-row.rowSelected');

		 allSelectedRows.each(function(row) {
			if (row != rowElement) {
				//var ptContainers = row.getElements('.pt-container');
				var ptContainers = row.getElements('.pt-container[data-ptid="' + ptid + '"]');

				//console.log(ptContainers);

				ptContainers.each(function(ptContainer) {
					var contParamButton = ptContainer.getElement('.filter-select-button[data-name="' + parameterName + '"]');

					removeEneteredFilter(contParamButton, filterName);
				});
			}
		 });

	}
}


function removeEneteredFilter(parameterButton, filterName) {
	var uniqueId = parameterButton.getAttribute('data-uniqueid'),
		parameterInput = $('paramInput_' + uniqueId),
		appliedFilters = parameterInput.value.split(';'),
		remainedFiltersCount = 0;

	filterName = decodeEntities(filterName);
	var matchIndex = appliedFilters.indexOf(filterName);

	if (matchIndex != -1) {
		appliedFilters.splice(matchIndex, 1);
		remainedFiltersCount = appliedFilters.length;

		if (remainedFiltersCount) {
			parameterInput.value = appliedFilters.join(';');
			if (remainedFiltersCount > 1) {
				parameterButton.getElement('.filter-select-button-count').innerHTML = remainedFiltersCount;
			} else {
				parameterButton.getElement('.filter-select-button-count').destroy();
			}
			parameterButton.getElement('.filter-select-button-value').innerHTML = squeeze(appliedFilters.join(';'), PARAM_BUTTON_MAXCHAR_LEN);
		} else {
			parameterInput.value = '';
			var label = parameterButton.getAttribute('data-label');
			parameterButton.innerHTML = '<span class="filter-select-button-value"><span class="fsb-value-unavail">[' + label + ']</span></span>';
		}

		parameterButton.setProperty('data-edited', 1);
		parameterButton.addClass(PARAM_BUTTON_EDITED_CLASS);
	}
}


function processSaveParameterFiltersEvent() {
	var button = this,
		parentPTCont = button.getParent('.pt-container'),
		ptid = parentPTCont.getAttribute('data-ptid'),
		parameterName = button.getAttribute('data-name'),
		rowElement = button.getParent('.fs-row'),
		rowSelected = rowElement.hasClass('rowSelected');

	// Note. By removing avilable filters immediately we make the interface more responsive
	$('availableFilters').innerHTML = '';

	saveParameterFilters(button);

	if (rowSelected) {
		 var allSelectedRows = $$('.fs-row.rowSelected');

		 allSelectedRows.each(function(row) {
			if (row != rowElement) {
				//var ptContainers = row.getElements('.pt-container');
				var ptContainers = row.getElements('.pt-container[data-ptid="' + ptid + '"]');

				//console.log(ptContainers);

				ptContainers.each(function(ptContainer) {
					var contParamButton = ptContainer.getElement('.filter-select-button[data-name="' + parameterName + '"]');

					saveParameterFilters(contParamButton);
				});
			}
		 });

	}
}


function saveParameterFilters(button) {
	var //button = this,
		parentCont = button.getParent('.pt-container'),
		rowId = parentCont.getAttribute('data-row'),
		pid = document[rowId + '-form']['pid'].value,
		ptid = parentCont.getAttribute('data-ptid'),
		recordId = parentCont.getAttribute('data-recordid'),
		uniqueId = button.getAttribute('data-uniqueid'),
		paramInput = $('paramInput_' + uniqueId),
		paramName = paramInput.getAttribute('data-name'),
		filters = paramInput.value,
		data = 'i=ASSIGN&action=SAVE_PARAM';

	data += '&pid=' + pid + '&ptid=' + ptid + '&record_id=' + recordId + '&param_name=' + paramName + '&filters='
		+ encodeURIComponent(filters);

	var edited = button.getAttribute('data-edited');

	if (edited == 1) {
		new Request({
			url: url,
			data: data,
			onComplete: function(resp) {
				//console.log(resp);
				button.removeClass(PARAM_BUTTON_EDITED_CLASS);
			}
		}).send();
	} else {
		//button.removeClass(PARAM_BUTTON_EDITED_CLASS);
	}

/* */
	//console.log(data);
}


function processAddOrRemoveClickedFilterEvent(_filterCont) {
	var filterCont = $(_filterCont),
		tick = filterCont.getFirst(),
		filterName = filterCont.getLast().innerHTML,
		addFilter = filterCont.hasClass('selected') ? false : true,
		parameterButton = simplePopup.activeButton,
		list = $('filterInputBox'),
		listElements = list.getChildren(),
		listElementsCount = listElements.length,
		//paramButton = $('paramButton_' + uniqueId),
		inputBox = $('filterInputBoxInput'),
		parentPTCont = parameterButton.getParent('.pt-container'),
		ptid = parentPTCont.getAttribute('data-ptid'),
		parameterName = parameterButton.getAttribute('data-name'),
		rowElement = parameterButton.getParent('.fs-row'),
		rowSelected = rowElement.hasClass('rowSelected');

	//inputBox.value = '';
	inputBox.focus();

	if (addFilter) {
		filterCont.addClass('selected');
		tick.addClass('selected');

		var newFilterElement = document.createElement('li');
		newFilterElement.className = 'filter-input-box-elem';
		newFilterElement.innerHTML = '<span class="filter-input-box-filter" title="Click to remove">' +
			filterName + '</span></li>';
		newFilterElement.inject(listElements[listElementsCount - 1], 'before');

		//appliedFilters.push(filterName);
	} else {
		filterCont.removeClass('selected');
		tick.removeClass('selected');

		for (var i = 0, len = listElementsCount - 1; i < len; i++) {
			var listFilter = listElements[i].getElement('.filter-input-box-filter').innerHTML;
			if (listFilter == filterName) {
				listElements[i].destroy();
				break;
			}
		}

		//appliedFilters.splice(appliedFilters.indexOf(filterName), 1);
	}

	addOrRemoveClickedFilter(parameterButton, filterName, addFilter);


	if (rowSelected) {
		 var allSelectedRows = $$('.fs-row.rowSelected');

		 allSelectedRows.each(function(row) {
			if (row != rowElement) {
				//var ptContainers = row.getElements('.pt-container');
				var ptContainers = row.getElements('.pt-container[data-ptid="' + ptid + '"]');

				//console.log(ptContainers);

				ptContainers.each(function(ptContainer) {
					var contParamButton = ptContainer.getElement('.filter-select-button[data-name="' + parameterName + '"]');

					addOrRemoveClickedFilter(contParamButton, filterName, addFilter);
				});
			}
		 });

	}

}


function addOrRemoveClickedFilter(parameterButton, filterName, addFilter) {
	var uniqueId = parameterButton.getAttribute('data-uniqueid'),
		parameterInput = $('paramInput_' + uniqueId),
		appliedFilters = (parameterInput.value) ? parameterInput.value.split(';') : [],
		appliedFiltersCount = 0,
		changedFilters = false;

	filterName = decodeEntities(filterName);
	var matchIndex = appliedFilters.indexOf(filterName);

	if (addFilter) {
		if (matchIndex == -1) {
			appliedFilters.push(filterName);
			changedFilters = true;
		}
	} else {
		if (matchIndex != -1) {
			appliedFilters.splice(matchIndex, 1);
			changedFilters = true;
		}
	}

	appliedFiltersCount = appliedFilters.length;

	var countElem = parameterButton.getElement('.filter-select-button-count');
	if (appliedFiltersCount > 1) {
		if (countElem) {
			countElem.innerHTML = appliedFiltersCount;
		} else {
			countElem = document.createElement('sup');
			countElem.className = 'filter-select-button-count';
			countElem.innerHTML = appliedFiltersCount;

			countElem.inject(parameterButton, 'top');
		}
	} else if (countElem) {
		countElem.destroy();
	}

	var newFiltersStr = appliedFilters.join(';');
	parameterInput.value = newFiltersStr;

	if (newFiltersStr) {
		parameterButton.getElement('.filter-select-button-value').innerHTML = squeeze(newFiltersStr, PARAM_BUTTON_MAXCHAR_LEN);
	} else {
		var label = parameterButton.getAttribute('data-label');
		parameterButton.innerHTML = '<span class="filter-select-button-value"><span class="fsb-value-unavail">[' +
			label + ']</span></span>';
	}

	if (changedFilters) {
		parameterButton.setProperty('data-edited', 1);
		parameterButton.addClass(PARAM_BUTTON_EDITED_CLASS);
	}

}



// Page Navigation

function setPage(clickedButton) {

	if (clickedButton.hasClass('selected')) return;

	var data = clickedButton.getAttribute('data-href'),
		skip = clickedButton.getAttribute('data-skip');

	$$('#pageNavigation .page-nav-element.selected').addClass('notbold');

	clickedButton.addClass('selected');

	document.searchForm.skip.value = skip;
	window.location.hash = '#' + data;

	data += '&action=DETAILS_AND_NAV';

	resetRefinePaneState();

	new Request.HTML({
		url: url,
		method: 'get',
		data: data,
		onRequest: function() {
			setProductDetailsLoading();
			var h = $('searchBarContainer').offsetTop - 10;
			window.scroll(0, h);
		},
		update: $('productsAndNavigation')
	}).send();
}

function setShowOnPage(clickedElem) {
	var showCount = clickedElem.innerHTML;

	simplePopup.activeButton.getFirst().innerHTML = showCount;
	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	var form = document.searchForm;
	form.showonpage.value = showCount;
	form.skip.value = '';

	var hash = clickedElem.href;
	var data = hash.substr(hash.indexOf('#') + 1);

	window.location.hash = '#' + data;

	data += '&action=DETAILS_AND_NAV';
	resetRefinePaneState();

	Cookie.write('onpage', showCount, {path: '/', duration: false});

	new Request.HTML({
		url: url,
		method: 'get',
		data: data,
		onRequest: function(){
			setProductDetailsLoading();
			var h = $('searchBarContainer').offsetTop - 10;
			window.scroll(0, h);
		},
		update: $('productsAndNavigation')
	}).send();
}




// get all Parameters into string:
function getParametersToString(addSkipParameter){
	var form = document.searchForm,
		parameters = 'i=ASSIGN';
		q = form.q.value,
		showonpage = form.showonpage.value,
		cid = form.cid.value,
		ptid = form.ptid.value,
		orderby = form.orderby.value,
		sc = form.sc.value,
		ppid = form.ppid.value;

	//if(q)parameters+='&q='+escape(q);
	if (q) parameters += '&q=' + encodeURIComponent(q);
	if (showonpage) parameters += '&showonpage=' + showonpage;
	if (cid) parameters += '&cid=' + cid;
	if (ptid) parameters += '&ptid=' + ptid;
	if (orderby) parameters += '&orderby=' + orderby;
	if (sc) parameters += '&sc=' + sc;
	if (ppid) parameters += '&ppid=' + ppid;

	if (addSkipParameter) {
		var skip = form.skip.value;
		if (skip) parameters += '&skip=' + skip;
	}

	return parameters;
}

function setProductDetailsLoading() {
	$('productDetailsList').setStyle('position', 'relative');
	$('blanket').removeClass('hid');
}

function resetRefinePaneState() {
	rowsSelected = 0;
	$('selGrpImg').setStyle('background-position', '0 0');
	$('refinePaneDeletePTFromSelected').addClass('hid');
}



function getNextNewProductTypeIndex() {
	currentNewProductTypeIndex++
	return currentNewProductTypeIndex;
}



var notificationTimeout;

function showNotification(message) {
	var notificationBox = $('notificationBox');
	var top = $('refinePane').offsetTop;
	notificationBox.innerHTML = message;
	notificationBox.removeClass('hid');
	var height = notificationBox.offsetHeight;
	notificationBox.setStyle('top', top - height);
	clearTimeout(notificationTimeout);
	notificationTimeout = setTimeout("removeNotification()",5000);
}

function removeNotification() {
	$('notificationBox').addClass('hid');
}



function closePopupWindow(popUp) {

	if (popUp.hasClass('active')) return;
	popUp.addClass('active');

	var fadeOut = new Fx.Tween(popUp, {
		duration: 150,
		transition: Fx.Transitions.Quad.easeOut,
		property: 'opacity',
		onComplete: function() {
			popUp.removeClass('active');
			popUp.addClass('hid');
		}
	});

	fadeOut.start(1, 0);
}
