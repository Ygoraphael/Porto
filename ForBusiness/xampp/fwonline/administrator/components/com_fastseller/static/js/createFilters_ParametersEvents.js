window.addEvent('domready', function() {

	$('ptp-save-parameters-button').addEvent('click', function() {
		saveParameters();
	});

	$$('.ptp-back-button').addEvent('click', function() {
		goBackToProductTypesPage();
	});

	$('ptpParamCont').addEvents({

		'click:relay(.ptp-navTab)': function(event) {
			if (event.target.hasClass('ptp-tabUpBtn')) return;
			setActiveTab(this);
		},

		'mouseenter:relay(.ptp-navTab)': function() {
			tabHoverOnOut(this, true);
		},

		'mouseleave:relay(.ptp-navTab)': function() {
			tabHoverOnOut(this, false);
		},

		'click:relay(.ptp-tabUpBtn)': function(event) {
			moveTabUp(this);
		},

		'click:relay(.ptp-addNewTab)': function() {
			addParameter();
		},

		'click:relay(.ptp-delete-parameter-button)': function(event) {
			event.preventDefault();
			deleteParameter(this);
		},

		'keyup:relay(.ptp-parameter-name)': function() {
			setParameterNameForActiveTab(this);
		},

		'keyup:relay(.ptp-parameter-label)': function() {
			setParameterLabelForActiveTab(this);
		},

		'blur:relay(.ptp-hint-listener)': function() {
			showOrHideInputHint(this);
		},

		'focus:relay(.ptp-hint-listener)': function() {
			showOrHideInputHint(this);
		},

		// 'change:relay(.tpt-parameter-mode)': function() {
			// console.log('validate if Trackbar 2 sliders and parameter multi-filters selected at the same time.');
		// },

		'change:relay(.ptp-define-filters-manually)': function() {
			var checked = this.checked,
				containers = this.getParent('.ptp-formCont').getElements('.ptp-filters-cont-variant');

			if (checked) {
				containers[0].addClass('hid');
				containers[1].removeClass('hid');
			} else {
				containers[0].removeClass('hid');
				containers[1].addClass('hid');
			}
		},

		'keyup:relay(.ptp-parameter-predefined-filters)': function(event) {
			var skipKeyCodes=[16, 17, 18, 35, 36, 37, 38, 39, 40],
				keyPressed = event.keyCode;

			if (skipKeyCodes.indexOf(keyPressed) != -1) return;

			updateTotalFiltersCount(this);
		}



	});


});



function goBackToProductTypesPage() {
	var data = 'i=CREATE';

	window.location.hash = data;

	new Request.HTML ({
		url: url,
		data: data,
		update:$('clayout')
	}).send();
}



function setActiveTab(clickedTab) {

	if (clickedTab.hasClass('tab-selected')) return;

	var index = clickedTab.getAttribute('data-tab'),
		formToHide = document.getElementById('ptpForm' + currentTabIndex),
		formToShow=document.getElementById('ptpForm' + index);

	$$('#ptpNavTabs li').removeClass('tab-selected');
	clickedTab.addClass('tab-selected');
	if (formToHide) formToHide.addClass('hid');
	formToShow.removeClass('hid');
	currentTabIndex = index;
	//console.log(input);
}

function tabHoverOnOut(tab, hovered) {
	var upBtn = tab.getElementsByClassName('ptp-tabUpBtn')[0],
		list = document.getElementById('ptpNavTabs');

	if (tab == list.children[0]) return;

	if (hovered) {
		upBtn.addClass('opaque');
	} else {
		upBtn.removeClass('opaque');
	}
}

function moveTabUp(clickedButton) {
	var list = document.getElementById('ptpNavTabs'),
		listElements = list.getChildren(),
		currentTab = clickedButton.getParent(),
		i, j, temp, data1, data2, list_order;

	for (i = 0, j = listElements.length; i<j; i++) {
		if (currentTab == listElements[i]) {
			if (i == 0) return;

			clickedButton.removeClass('opaque');
			temp = listElements[i-1].innerHTML;
			listElements[i-1].innerHTML = listElements[i].innerHTML;
			listElements[i].innerHTML = temp;

			temp = listElements[i-1].id;
			listElements[i-1].id = listElements[i].id;
			listElements[i].id = temp;
			data1 = listElements[i-1].getAttribute('data-tab');
			data2 = listElements[i].getAttribute('data-tab');
			listElements[i-1].setProperty('data-tab', data2);
			listElements[i].setProperty('data-tab', data1);

			document.getElementById('list_order_' + data1).value = listElements[i].getAttribute('data-order');
			document.getElementById('list_order_' + data2).value = listElements[i-1].getAttribute('data-order');

			//console.log(document.getElementById('list_order_'+data1), listElements[i-1].getAttribute('data-order'));

			if (listElements[i-1].hasClass('tab-selected')) {
				listElements[i-1].removeClass('tab-selected');
				listElements[i].addClass('tab-selected');
			} else if (listElements[i].hasClass('tab-selected')) {
				listElements[i].removeClass('tab-selected');
				listElements[i-1].addClass('tab-selected');
			}
		}
	}
}


function addParameter() {
	var list = document.getElementById('ptpNavTabs'),
		numberOfTabs = list.getChildren().length,
		formsCont = document.getElementById('ptpForms'),
		newTab = document.createElement('li'),
		newForm = document.createElement('div'),
		tabClass = 'ptp-navTab',
		lastTab,
		data = 'i=CREATE&action=GET_PARAMETER_FORM';

	if (document.getElementById('ptpParamCont').hasClass('saving')) return;

	newTab.innerHTML = '<span class="ptp-tabParamLabel ptp-newParam">[Label]</span> ' +
		'<span class="ptp-tabParamName ptp-newParam">([Name])</span><div class="ptp-tabUpBtn">&uarr;</div>';
	if (numberOfTabs == 0) {
		tabClass += ' tab-first tab-last';
		formsCont.innerHTML = '';
	} else {
		lastTab = list.children[numberOfTabs-1];
		lastTab.removeClass('tab-last');
		tabClass += ' tab-last';
		//console.log(lastTab);
	}
	newTab.id = "ptpNavTab" + generalNumberOfTabs;
	newTab.className = tabClass;
	newTab.setProperty('data-tab', generalNumberOfTabs);
	newTab.setProperty('data-order', generalNumberOfTabs);
	list.appendChild(newTab);
	newForm.id = 'ptpForm' + generalNumberOfTabs;
	newForm.className = 'ptp-formCont hid';
	newForm.innerHTML = 'loading..';
	formsCont.appendChild(newForm);

	data += '&tabno=' + generalNumberOfTabs;
	generalNumberOfTabs++;

	new Request.HTML({
		url: url,
		data: data,
		onComplete:function() {
			var inpt = newForm.getElementsByClassName('ptp-parameter-name')[0].focus();
		},
		update: newForm
	}).send();

	setActiveTab(newTab);
}

function deleteParameter(clickedButton) {

	if (document.getElementById('ptpParamCont').hasClass('saving')) return;

	var tabIndex = clickedButton.getAttribute('data-tab'),
		key = clickedButton.getAttribute('data-key'),
		form = document.getElementById('ptpForm' + tabIndex),
		tab = document.getElementById('ptpNavTab' + tabIndex),
		list = document.getElementById('ptpNavTabs'),
		listElements = list.getChildren(),
		data='&i=CREATE&action=DELETE_PARAMETER',
		tabToActivate, parameterName, i, j;

	var name = document.id('parameter_label_' + tabIndex).value;
	var msg = (name) ? "Delete parameter '" + name + "'?" : "Delete parameter (no label)?";
	if (! confirm(msg))
		return;

	for (i = 0, j = listElements.length; i<j; i++) {
		if (listElements[i] == tab) {
			if (listElements[i+1]) {
				tabToActivate = listElements[i+1];
				if (i == 0) listElements[i+1].addClass('tab-first');
				break;
			} else if (listElements[i-1]) {
				tabToActivate = listElements[i-1];
				listElements[i-1].addClass('tab-last');
				break;
			}
		}
	}
	parameterName = document.getElementById('parameter_name_active_' + key).value;
	data += '&parameter_name=' + parameterName;
	data += '&ptid=' + document.parametersForm.ptid.value;

	form.destroy();
	tab.destroy();
	if (tabToActivate) setActiveTab(tabToActivate);
	if (parameterName) {
		new Request({
			url: url,
			data: data
		}).send();
	}
}


function saveParameters() {
	var form = document.parametersForm,
		cont = document.getElementById('ptpParamCont');

	if (cont.hasClass('saving')) return;
	if (!parameterNamesAreValid() && !confirm('Some parameters will not be updated. Proceed?')) return;

	cont.addClass('saving');

	new Request({
		url: url,
		data: form,
		onComplete:function(){
			updateActiveParameterNames();
			cont.removeClass('saving');
		},
		onFailure:function(response){
			showErrorMessage(response.responseText);
		}
	}).send();
}

function updateActiveParameterNames() {
	var form = document.parametersForm,
		keys = form.elements['key[]'],
		i, j;
	if (!keys) return;
	if (!keys.length) {
		updateActiveParameterNameByKey(keys.value);
	} else {
		for (i=0, j=keys.length; i<j; i++){
			updateActiveParameterNameByKey(keys[i].value)
		}
	}
}

function updateActiveParameterNameByKey(key) {
	var name = document.getElementById('parameter_name_' + key),
		activeName = document.getElementById('parameter_name_active_'+key);
	if(name.value != activeName.value && parameterNameIsValid(name.value)) {
		activeName.value = name.value;
	}
}


function setParameterNameForActiveTab(paramNameInput) {
	var index = paramNameInput.getAttribute('data-tab'),
		name = paramNameInput.value,
		nameNode=document.getElementById('ptpNavTab'+index).getElementsByClassName('ptp-tabParamName')[0];

	name = trim(name);
	nameNode.innerHTML = '('+name+')';
	if (nameNode.hasClass('ptp-newParam')) nameNode.removeClass('ptp-newParam');

	checkParamNameIsValid(paramNameInput);
}

function checkParamNameIsValid(paramNameInput) {
	var index = paramNameInput.getAttribute('data-tab'),
		name = paramNameInput.value,
		goodName = true,
		nameNode = document.getElementById('ptpNavTab'+index).getLast(),
		allNames = document.getElementsByClassName('ptp-parameter-name');

	name = trim(name);
	name = name.toLowerCase();

	if (name == '' || !parameterNameIsValid(name)) {
		paramNameInput.addClass('paramNameBad');
		nameNode.addClass('tabParamNameBad');
		return;
	}

	if (inArray(name, otherParameterNames)) {
		paramNameInput.addClass('paramNameBad');
		nameNode.addClass('tabParamNameBad');
		return;
	}

	for (i = 0, j = allNames.length; i<j; i++) {
		if ((paramNameInput != allNames[i]) && (name == allNames[i].value.toLowerCase())) {
			goodName = false;
			paramNameInput.addClass('paramNameBad');
			nameNode.addClass('tabParamNameBad');
			break;
		}
	}

	if (goodName && paramNameInput.hasClass('paramNameBad')) {
		paramNameInput.removeClass('paramNameBad');
		nameNode.removeClass('tabParamNameBad');
	}
}

function parameterNameIsValid(name) {
	var res;
	if (name=="") return false;
	res = name.match(/[^a-zA-z0-9_]/);
	return (res === null) ? true : false;
}

function parameterNamesAreValid() {
	var allNames = document.getElementsByClassName('ptp-parameter-name'),
		ok = true,
		i, j;

	for (i = 0, j = allNames.length; i<j; i++) {
		if (allNames[i].hasClass('paramNameBad') || allNames[i].value == '') {
			ok = false;
			break;
		}
	}

	if (ok && inArray(name, otherParameterNames)) ok = false;

	return ok;
}

function setParameterLabelForActiveTab(paramLabelInput) {
	var index = paramLabelInput.getAttribute('data-tab'),
		label = paramLabelInput.value,
		labelNode = document.getElementById('ptpNavTab' + index).getFirst();

	if (label == '') {
		labelNode.innerHTML='[Label]';
		if (!labelNode.hasClass('ptp-newParam')) labelNode.addClass('ptp-newParam');
	} else {
		labelNode.innerHTML = label;
		if (labelNode.hasClass('ptp-newParam')) labelNode.removeClass('ptp-newParam');
	}
}


function showOrHideInputHint(input) {
	var node = document.getElementById(input.id + '_hint');

	if (node.hasClass('show')) {
		node.removeClass('show');
	} else {
		node.addClass('show');
	}
}


function updateTotalFiltersCount(textareaElement){
	var string = textareaElement.value,
		filters = [],
		count = 0,
		index = textareaElement.getAttribute('data-tab'),
		fcountElement = document.getElementById('numberOfFilters_'+index).getLast();

	if (string) {
		filters = string.split(";");
		count = filters.length;
		if (filters[count - 1].replace(/\s/g,"") == "") count -= 1;
	}
	fcountElement.innerHTML = count;
}


function showErrorMessage(message){
	var div, temp, msg, left,
		cont = document.getElementById('clayout');

	temp = document.createElement('div');
	temp.innerHTML = message;
	msg = temp.getElementsByTagName('table')[0].innerHTML;
	msg += '<div style="margin:30px 0 0 0;text-align:center"><button onclick="removeErrorMessage()">Close</button></div>';
	div = document.createElement('div');
	div.className = 'errorMessage';
	div.innerHTML = msg;
	left = (window.getScrollWidth() - 400) / 2;
	div.style.left = left+'px';
	cont.appendChild(div);
	div.addClass('opaque');
}

function removeErrorMessage() {
	var cont = document.getElementsByClassName('errorMessage')[0],
		parent = document.getElementById('clayout'),
		ptp = document.getElementById('ptpParamCont');

	cont.removeClass('opaque');
	setTimeout(function() {
		parent.removeChild(cont);
		ptp.removeClass('saving');
	}, 200);
}

function inArray(needle, haystack) {
	var length = haystack.length;
	for(var i = 0; i < length; i++) {
		if(haystack[i] == needle) return true;
	}
	return false;
}
