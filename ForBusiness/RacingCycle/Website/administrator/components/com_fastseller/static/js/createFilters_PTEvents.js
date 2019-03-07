window.addEvent('domready', function() {

	$('manageProducTypes').addEvents({

		'click:relay(.ptm-open-listener)': function() {
			openProductType(this);
		},

		'click:relay(.ptm-edit)': function() {
			editProductTypeInfo(this);
		},

		'click:relay(.ptm-save)': function() {
			saveProductTypeInfo(this);
		},

		'click:relay(.ptm-delete)': function() {
			deleteProductType(this);
		},

		'click:relay(.ptm-reorder)': function() {
			reorderProductTypes(this);
		},

		'click:relay(.ptm-addnew-pt)': function() {
			addNewProductType();
		}

	});

	$$('.ptm-helptips-ttl').addEvent('click', function() {
		hideOrShowPTHelp();
	});

});


function openProductType(clickedRowCell) {
	var row = clickedRowCell.getParent('.ptm-vrow'),
		ptid = row.cells[1].innerHTML,
		data = 'i=CREATE',
		statusCont = $('cstatus');

	if (row.hasClass('editing')) return;

	window.location.hash += '&ptid=' + ptid;
	data += '&ptid=' + ptid;

	statusCont.removeClass('hid');

	new Request.HTML({
		url: url,
		data: data,
		onComplete: function() {
			statusCont.addClass('hid');
		},
		update:$('clayout')
	}).send();
}


function editProductTypeInfo(clickedButton) {
	var row = clickedButton.getParent('.ptm-vrow');

	if (row.hasClass('rowsaving')) return;

	var name_cell = row.cells[2],
		desc_cell = row.cells[3],
		desc_width = desc_cell.offsetWidth-23;
		edit_btn = row.cells[5].getElementsByClassName('ptm-edit')[0],
		save_btn = row.cells[5].getElementsByClassName('ptm-save')[0];

	row.addClass('editing');
	name_cell.innerHTML = '<input type="text" name="name" value="' + name_cell.getFirst().innerHTML + '" />';
	desc_cell.innerHTML = '<textarea name="desc" rows="1" style="width:' +
		desc_width+'px">' + desc_cell.getFirst().innerHTML + '</textarea>';

	edit_btn.addClass('hid');
	save_btn.removeClass('hid');
}

function saveProductTypeInfo(clickedButton) {
	var row = clickedButton.getParent('.ptm-vrow'),
		id_cell = row.cells[1],
		name_cell = row.cells[2],
		desc_cell = row.cells[3],
		name = name_cell.getFirst().value,
		desc = desc_cell.getFirst().value,
		ptid = id_cell.innerHTML,
		order = row.getAttribute('data-order'),
		edit_btn = row.cells[5].getElementsByClassName('ptm-edit')[0],
		save_btn = row.cells[5].getElementsByClassName('ptm-save')[0],
		delete_btn = row.cells[5].getElementsByClassName('ptm-delete')[0],
		data = 'i=CREATE&action=SAVE_PT';

	name_cell.innerHTML = '<div>' + name + '</div>';
	desc_cell.innerHTML = '<div>' + desc + '</div>';
	edit_btn.removeClass('hid');
	save_btn.addClass('hid');

	data += '&name=' + name + '&desc=' + encodeURI(desc) + '&ptid=' + ptid + '&order=' + order;

	row.addClass('rowsaving');

	new Request({
		url: url,
		data: data,
		onComplete: function(response) {
			if (response != 0) {
				if (ptid == 0) id_cell.innerHTML = response;
				row.removeClass('rowsaving');
				row.removeClass('editing');
				row.setProperty('data-ptname', name);
				delete_btn.removeClass('hid');
			} else {
				alert('There was an error while updating values.');
			}
		}
	}).send();
}


function reorderProductTypes(clickedButton) {
	var activeRow = clickedButton.getParent('.ptm-vrow'),
		activeRowIndex = activeRow.rowIndex,
		parentNode = activeRow.parentNode,
		interactingRow, tempNo, order1, order2, id1, id2,
		data = 'i=CREATE&action=REORDER_PT';

	if (activeRowIndex <= 1) return;

	interactingRow = activeRow.getPrevious();

	if (activeRow.hasClass('editing') || interactingRow.hasClass('editing')) return;

	parentNode.removeChild(activeRow);
	parentNode.insertBefore(activeRow, interactingRow);

	tempNo = activeRow.getElement('.ptm-no').innerHTML;
	order1 = activeRow.getAttribute('data-order');

	activeRow.getElement('.ptm-no').innerHTML = interactingRow.getElement('.ptm-no').innerHTML;
	order2 = interactingRow.getAttribute('data-order');
	activeRow.setProperty('data-order', order2);

	interactingRow.getElement('.ptm-no').innerHTML = tempNo;
	interactingRow.setProperty('data-order', order1);

	id1 = interactingRow.getElement('.ptm-id').innerHTML;
	id2 = activeRow.getElement('.ptm-id').innerHTML;

	data += '&id1=' + id1 + '&order1=' + order1 + '&id2=' + id2 + '&order2=' + order2;

	new Request({
		url: url,
		data: data
	}).send();

	//console.log(interactingRow);
}



function addNewProductType() {
	var table = document.getElementById('ptList'),
		noPTs = table.getAttribute('data-nopts'),
		orderNumber = productTypesCount,
		rowcount, newrow, td1, td2, td3, td4, td5, td6;

	productTypesCount++;

	if (noPTs == 1) {
		table.deleteRow(1);
		table.removeProperty('data-nopts');
	}

	rowcount = table.rows.length;
	newrow = table.insertRow(rowcount);
	td1 = newrow.insertCell(0);
	td2 = newrow.insertCell(1);
	td3 = newrow.insertCell(2);
	td4 = newrow.insertCell(3);
	td5 = newrow.insertCell(4);
	td6 = newrow.insertCell(5);
	td7 = newrow.insertCell(6);



	td1.innerHTML = rowcount;
	td3.innerHTML = '<input type="text" name="name" value="" />';
	td4.innerHTML = '<textarea name="desc" rows="1"></textarea>';
	td5.innerHTML = '0';
	td6.innerHTML = '<button class="default-button-type-0 ptm-edit hid">Edit</button>' +
		'<button class="default-button-type-0 ptm-save" >Save</button> &nbsp;' +
		'<button class="default-button-type-0 ptm-delete hid">Delete</button>';
	td7.innerHTML = '<button class="ptm-reorder" title="Move Up">' +
		'<span class="ptm-reorder-uparrow"></span></button>';
	newrow.className = 'ptm-vrow editing';
	newrow.setProperty('data-order', orderNumber);
	td1.className = 'ptm-no ptm-open-listener';
	td2.className = 'ptm-id ptm-open-listener';
	td3.className = 'ptm-name ptm-open-listener';
	td4.className = 'ptm-desc';
	td5.align = 'center';
	td3.getFirst().focus();
}


function deleteProductType(clickedButton) {
	var table = document.getElementById('ptList'),
		row = clickedButton.parentNode.parentNode,
		rowIndex = row.rowIndex;
		ptid = row.cells[1].innerHTML,
		confirmDelete = confirm('Delete product type: "' + row.getAttribute('data-ptname') + '"?'),
		data = 'i=CREATE&action=DELETE_PT';

	if (confirmDelete) {
		table.deleteRow(rowIndex);
		data += '&ptid=' + ptid;

		new Request({
			url: url,
			data: data
		}).send();
	}
}


function hideOrShowPTHelp() {
	var helpContainer = document.getElementsByClassName('ptm-helptips-cont')[0];
	helpContainer.toggleClass('ptm-helptips-cont-show');
}
