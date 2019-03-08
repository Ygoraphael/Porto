window.addEvent('domready', function() {

	$('refinePane').addEvents({

		'click:relay(#refinePaneMutliSelectButton)': function(event) {
			var menu = $('refinePaneMutliSelectMenu'),
				button = this,
				buttonActiveClass = 'refine-pane-button-active';

			simplePopup.showMenu({
				button: button,
				menu: menu,
				buttonActiveClass: buttonActiveClass,
				event: event
			});
		},

		'click:relay(#refinePaneMutliSelectMenu .rps-menu-element)': function() {
			var select = this.getAttribute('data-select');

			switch (select) {
				case 'all':
					selectAllProducts();
					break;

				case 'none':
					deselectAllProducts();
					break;

				case 'wpt':
					selectProductsWithProductType();
					break;

				case 'wopt':
					selectProductsWithoutProductType();
					break;
			}
		},

		'click:relay(#refinePaneCategoriesButton)': function(event) {
			var menu = $('refinePaneCategoriesMenu'),
				button = this,
				buttonActiveClass = 'refine-pane-button-active';

			simplePopup.showMenu({
				button: button,
				menu: menu,
				buttonActiveClass: buttonActiveClass,
				event: event
			});

			loadCategoriesTree(button);
		},

		'click:relay(#refinePaneProductTypesButton)': function(event) {
			var menu = $('refinePaneProductTypesMenu'),
				button = this,
				buttonActiveClass = 'refine-pane-button-active';

			simplePopup.showMenu({
				button: button,
				menu: menu,
				buttonActiveClass: buttonActiveClass,
				event: event
			});

			loadProductTypesList(button);
		},

		'click:relay(#refinePaneOrderByButton)': function(event) {
			var menu = $('refinePaneOrderByMenu'),
				button = this,
				buttonActiveClass = 'refine-pane-button-active';

			simplePopup.showMenu({
				button: button,
				menu: menu,
				buttonActiveClass: buttonActiveClass,
				event: event
			});
		},

		'click:relay(#refinePaneOrderByMenu .rps-menu-element)': function() {
			applyOrderBy(this);
		},

		'click:relay(#refinePaneAscDescButton)': function() {
			applyAscDescOrder(this);
		},

		'click:relay(#refinePaneExpandCollapseButton)': function() {
			expandCollapseAllRows(this);
		},

		'click:relay(.category-tree-categories)': function() {
			loadCategoriesTree(this);
		},

		'mouseenter:relay(.category-tree-categories)': function() {
			highlightCategoryTree(this, 0);
		},

		'mouseleave:relay(.category-tree-categories)': function() {
			highlightCategoryTree(this, 0);
		},

		'mouseenter:relay(.category-tree-button-cont)': function() {
			highlightCategoryTree(this, 1);
		},

		'mouseleave:relay(.category-tree-button-cont)': function() {
			highlightCategoryTree(this, 1);
		},

		'click:relay(.category-tree-button)': function() {
			applyCategory(this);
		},

		'click:relay(#removeCategorySelection)': function() {
			applyCategory(this);
		},


		'mouseenter:relay(.pt-list-pt)': function() {
			highlightProductTypeList(this, 0);
		},

		'mouseleave:relay(.pt-list-pt)': function() {
			highlightProductTypeList(this, 0);
		},

		'mouseenter:relay(.pt-list-button-cont)': function() {
			highlightProductTypeList(this, 1);
		},

		'mouseleave:relay(.pt-list-button-cont)': function() {
			highlightProductTypeList(this, 1);
		},

		'click:relay(.pt-list-button)': function() {
			applyProductType(this);
		},

		'click:relay(#removeProductTypeSelection)': function() {
			applyProductType(this);
		},

		'click:relay(#refinePaneDeletePTFromSelected)': function(event) {
			processDeletePTFromSelectedEvent(this, event);
		},

		'click:relay(#refinePaneDeletePTFromSelectedMenu .rps-menu-element)': function() {
			var ptid = this.getAttribute('data-ptid');
			deletePTFromSelected(ptid);
		}

	});

});


function selectAllProducts() {

	var allRows = $$('.fs-row'),
		allCheckboxes = $$('.row-checkbox-img');

	allRows.addClass('rowSelected');
	allCheckboxes.addClass('row-checkbox-img-selected');

	if (currentTotalRows != 0) $('selGrpImg').setStyle('background-position','0 -26px');

	rowsSelected = allRows.length;

	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	showNotification('<b>' + rowsSelected + '</b> row(s) selected');
	toggleRemoveProductTypesFromSelectedProductsButton(rowsSelected);
}

function deselectAllProducts() {

	var allRows = $$('.fs-row'),
		allCheckboxes = $$('.row-checkbox-img');

	allRows.removeClass('rowSelected');
	allCheckboxes.removeClass('row-checkbox-img-selected');

	$('selGrpImg').setStyle('background-position','0 0px');

	rowsSelected = 0;

	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	showNotification('Nothing selected');
	toggleRemoveProductTypesFromSelectedProductsButton(rowsSelected);
}

function selectProductsWithProductType() {

	var allRows = $$('.fs-row'),
		rowsMatched = 0;

	allRows.each(function(row) {
		var containers = row.getElements('.pt-container'),
			productHasPT = false;

		productHasPT = containers.some(function(container) {
			return container.getAttribute('data-ptid');
		});

		if (productHasPT) {
			row.addClass('rowSelected');
			row.getElement('.row-checkbox-img').addClass('row-checkbox-img-selected');
			rowsMatched++;
		} else if (row.hasClass('rowSelected')) {
			row.removeClass('rowSelected');
			row.getElement('.row-checkbox-img').removeClass('row-checkbox-img-selected');
		}

	});

	if (rowsMatched == currentTotalRows && rowsMatched != 0) {
		$('selGrpImg').setStyle('background-position','0 -26px');
	} else if (rowsMatched == 0) {
		$('selGrpImg').setStyle('background-position','0 0');
	} else {
		$('selGrpImg').setStyle('background-position','0 -65px');
	}

	rowsSelected = rowsMatched;
	showNotification('<b>' + rowsSelected + '</b> row(s) selected');
	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();
	toggleRemoveProductTypesFromSelectedProductsButton(rowsSelected);
}

function selectProductsWithoutProductType() {

	var allRows = $$('.fs-row'),
		rowsMatched = 0;

	allRows.each(function(row) {
		var containers = row.getElements('.pt-container'),
			productHasPT = false;

		productHasPT = containers.some(function(container) {
			return container.getAttribute('data-ptid');
		});

		if (productHasPT == false) {
			row.addClass('rowSelected');
			row.getElement('.row-checkbox-img').addClass('row-checkbox-img-selected');
			rowsMatched++;
		} else if (row.hasClass('rowSelected')) {
			row.removeClass('rowSelected');
			row.getElement('.row-checkbox-img').removeClass('row-checkbox-img-selected');
		}

	});

	if (rowsMatched == currentTotalRows && rowsMatched != 0) {
		$('selGrpImg').setStyle('background-position','0 -26px');
	} else if (rowsMatched == 0) {
		$('selGrpImg').setStyle('background-position','0 0');
	} else {
		$('selGrpImg').setStyle('background-position','0 -65px');
	}

	rowsSelected = rowsMatched;
	showNotification('<b>' + rowsSelected + '</b> row(s) selected');
	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();
	toggleRemoveProductTypesFromSelectedProductsButton(rowsSelected);
}



var loadedCategories = [],
	loadedProductTypes = false;

function loadCategoriesTree(clickedElement) {

	var branchId = clickedElement.getAttribute('data-branchid');

	if (loadedCategories[branchId] == 1) {
		if (branchId != 'category-branch') $(branchId).getParent().toggleClass('hid');
		return;
	}

	var	categoryId,
		loader = $(branchId + '-loader'),
		data;

	categoryId = (branchId == 'category-branch') ? 0 : clickedElement.getAttribute('data-catid');
	data = 'i=ASSIGN&action=GET_CATEGORIES_TREE&category_tree_id=' + branchId + '&cid=' + categoryId;

	loader.removeClass('hid');

	new Request.HTML({
		url: url,
		data: data,
		onComplete: function() {
			loadedCategories[branchId] = 1;
			$(loader).addClass('hid');
		},
		update: $(branchId)
	}).send();

}

function highlightCategoryTree(element, highlightFullRow){
	var tr = $(element).getParent();

	if (highlightFullRow == 0) {
		$(tr.getParent().rows[tr.rowIndex+1]).toggleClass('hov');
		element.toggleClass('hov');
		$(tr.getParent().rows[tr.rowIndex].cells[1]).getFirst().toggleClass('hid');
	} else { // higlihgt the row, when second column is hovered
		element.toggleClass('hov');
		tr.toggleClass('hov');
		element.getFirst().toggleClass('hid');
	}
}

function applyCategory(clickedButton) {

	var categoryId = clickedButton.getAttribute('data-catid'),
		categoryName = clickedButton.getAttribute('data-catname'),
		categoryNameForButton = squeeze(categoryName, 18),
		categoryNameForMenu = squeeze(categoryName, 21),
		menuTitle = $('refinePaneCategoriesMenu').getFirst().getFirst();

	setProductDetailsLoading();
	resetRefinePaneState();

	menuTitle.innerHTML = categoryNameForMenu;

	var clearCategoryElement = $('refinePaneCategoriesMenu').getFirst().getLast(),
		categoryButtonTitle = simplePopup.activeButton.getFirst();
	if (categoryId == '') {
		clearCategoryElement.addClass('hid');
		//categoryButtonTitle.innerHTML = categoryNameForButton;
	} else {
		clearCategoryElement.removeClass('hid');
		//categoryButtonTitle.innerHTML = categoryNameForButton;
	}

	categoryButtonTitle.innerHTML = categoryNameForButton;

	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	var form = document.searchForm;

	form.cid.value = categoryId;
	form.skip.value = '';

	var data = getParametersToString(0);

	window.location.hash = '#' + data;
	data += '&action=DETAILS_AND_NAV';

	new Request.HTML({
		url: url,
		data: data,
		update: $('productsAndNavigation')
	}).send();

}


function loadProductTypesList() {
	if (loadedProductTypes) return;

	var data = 'i=ASSIGN&action=GET_PT_LIST';

	new Request.HTML({
		url: url,
		data: data,
		onComplete: function() {
			loadedProductTypes = true;
		},
		update: $('product-type-branch')
	}).send();
}

function highlightProductTypeList(element, highlightFullRow){
	var tr = $(element).getParent();

	if (highlightFullRow == 0) {
		element.toggleClass('hov');
		var td = tr.getLast();
		td.toggleClass('hov');
		td.getFirst().toggleClass('hid');
	} else {
		element.toggleClass('hov');
		tr.getFirst().toggleClass('hov');
		element.getFirst().toggleClass('hid');
	}
}

function applyProductType(clickedButton) {

	var ptid = clickedButton.getAttribute('data-ptid'),
		ptName = clickedButton.getAttribute('data-ptname'),
		ptNameForButton = squeeze(ptName, 18),
		ptNameForMenu = squeeze(ptName, 21),
		menuTitleCont = $('refinePaneProductTypesMenu').getFirst(),
		ptButtonTitle = simplePopup.activeButton.getFirst();

	setProductDetailsLoading();
	resetRefinePaneState();

	menuTitleCont.getFirst().innerHTML = ptNameForMenu;
	if (ptid == '') {
		menuTitleCont.getLast().addClass('hid');
	} else {
		menuTitleCont.getLast().removeClass('hid');
	}

	ptButtonTitle.innerHTML = ptNameForButton;
	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	var form = document.searchForm;
	form.ptid.value = ptid;
	form.skip.value = '';

	var data = getParametersToString(false);

	window.location.hash = '#' + data;
	data += '&action=DETAILS_AND_NAV';

	new Request.HTML({
		url: url,
		data: data,
		update: $('productsAndNavigation')
	}).send();

}

function applyOrderBy(clickedElement) {
	var order = clickedElement.getAttribute('data-order'),
		form = document.searchForm;

	form.orderby.value = order;

	setProductDetailsLoading();
	resetRefinePaneState();

	// simplePopup.removeMenu();
	// simplePopup.removeBoundEvent();
	simplePopup.hidePopupMenu();

	clickedElement.getParent().getChildren().each(function(menuElement) {
		var _order = menuElement.getAttribute('data-order'),
			str = menuElement.innerHTML;
		//if(order==ord){
		if (menuElement == clickedElement) {
			str += '*';
		} else {
			str = str.replace('*', '');
		}
		menuElement.innerHTML = str;
	});

	var data = getParametersToString(1);

	window.location.hash = '#' + data;
	data += '&action=DETAILS_AND_NAV';

	new Request.HTML({
		url: url,
		data: data,
		update: $('productsAndNavigation')
	}).send();

}

function applyAscDescOrder(clickedButton) {
	var form = document.searchForm,
		scending = form.sc.value;

	setProductDetailsLoading();
	resetRefinePaneState();

	if (scending == '') {
		scending = 'Desc';
	} else {
		scending = (scending == 'Asc') ? 'Desc' : 'Asc';
	}

	form.sc.value = scending;
	clickedButton.innerHTML = scending;

	clickedButton.setProperty('title', 'Current ordering: ' + scending);

	var data = getParametersToString(1);

	window.location.hash = '#' + data;
	data += '&action=DETAILS_AND_NAV';

	new Request.HTML({
		url: url,
		data: data,
		update: $('productsAndNavigation')
	}).send();
}


function expandCollapseAllRows(clickedButton) {
	var nowExpanded = clickedButton.getAttribute('data-expanded'),
		statusExpanded = 0,
		buttonTitle = 'Expand',
		allRows = $$('.fs-row');

		//if (outerCont.hasClass('expanded')) {
		if (nowExpanded == 0) {
			allRows.each(function(row) {
				var outerCont = row.getElement('.pt-cont-outer'),
					curtain = row.getElement('.pt-curtain');

				outerCont.addClass('expanded');
				curtain.addClass('hid');
			});

			statusExpanded = 1;
			buttonTitle = 'Collapse';
		} else {
			allRows.each(function(row) {
				var outerCont = row.getElement('.pt-cont-outer'),
					curtain = row.getElement('.pt-curtain');

				outerCont.removeClass('expanded');
				curtain.removeClass('hid');
			});
		}

		clickedButton.setProperty('data-expanded', statusExpanded);
		clickedButton.innerHTML = buttonTitle;

		Cookie.write('rows-expanded', statusExpanded, {path: '/', duration: false});

}


function toggleRemoveProductTypesFromSelectedProductsButton(rowsSelected) {
	var button = document.id('refinePaneDeletePTFromSelected');
	if (rowsSelected == 0) {
		button.addClass('hid');
	} else {
		button.removeClass('hid');
	}
}

function processDeletePTFromSelectedEvent(clickedButton, event) {
	var selectedRows = document.id('fsProductListTable').getElements('.fs-row.rowSelected'),
		ptids = [];

	for (var i = 0, rlen = selectedRows.length; i < rlen; i++) {
		var ptContainers = selectedRows[i].getElements('.pt-container');
		for (var j = 0, clen = ptContainers.length; j < clen; j++) {
			var ptid = ptContainers[j].getAttribute('data-ptid');
			if (ptid != null && ptids.indexOf(ptid) == -1) ptids.push(ptid);
		}

	}

	// console.log(ptids);

	var ptids_len = ptids.length;
	if (ptids_len) {
		var menu = $('refinePaneDeletePTFromSelectedMenu'),
			buttonActiveClass = 'refine-pane-button-active',
			menuContentHTML;

		menuContentHTML = '<div class="rps-menu-element" data-ptid="all">All</div>';
		for (var i = 0, len = ptids_len; i < ptids_len; i++) {
			menuContentHTML += '<div class="rps-menu-element" data-ptid="' + ptids[i] + '"><i>Just <b>' +
				productTypesData[ptids[i]] + '</b></i></div>';
		}
		menu.innerHTML = menuContentHTML;

		simplePopup.showMenu({
			button: clickedButton,
			menu: menu,
			buttonActiveClass: buttonActiveClass,
			event: event
		});
	}
}

function deletePTFromSelected(ptid) {
	var selectedRows = document.id('fsProductListTable').getElements('.fs-row.rowSelected'),
		pids = [];

	simplePopup.hidePopupMenu();

	for (var i = 0, rlen = selectedRows.length; i < rlen; i++) {
		var form = selectedRows[i].getElement('form'),
			pid = form['pid'].value,
			nextTabToShow = null,
			activeTab;

		pids.push(pid);
		activeTab = selectedRows[i].getElement('.pt-tab-selected');
		if (activeTab.getAttribute('data-contid') == 'all')
			nextTabToShow = activeTab;

		if (ptid == 'all') {
			var allTabs = selectedRows[i].getElements('.pt-tab');

			for (var t = 1, tlen = allTabs.length; t < tlen; t++) {
				var contId = allTabs[t].getAttribute('data-contid'),
					_cont = $(contId);

				allTabs[t].destroy();
				_cont.destroy();
			}
		} else {
			var ptContainers = selectedRows[i].getElements('.pt-container');
			for (var j = 0, clen = ptContainers.length; j < clen; j++) {
				if (ptid == ptContainers[j].getAttribute('data-ptid')) {
					var tab = selectedRows[i].getElement('#tab_' + ptContainers[j].id);

					tab.destroy();
					ptContainers[j].destroy();
				} else if (nextTabToShow == null) {
					nextTabToShow = selectedRows[i].getElement('#tab_' + ptContainers[j].id);
				}
			}
		}

		// we could have deleted all tabs (except 'All' tab). Check whether we need to add empty Tab.
		if (selectedRows[i].getElements('.pt-tab').length < 2) {
			var addNewPTTab = selectedRows[i].getElement('.pt-tab-addnew');
			var newTab = addNewProductType(addNewPTTab);

			showProductProductType(newTab);
		} else if (nextTabToShow) {
			showProductProductType(nextTabToShow);
		}
	}

	var data = 'i=ASSIGN&action=DELETE_PT_FROM_SELECTED_PRODUCTS';
	data += '&pids=' + pids.join('|');
	if (ptid != 'all') data += '&ptid=' + ptid;
	new Request({
		url: url,
		data: data
	}).send();
}
