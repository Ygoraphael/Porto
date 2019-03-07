document.searchForm.q.focus();

if (showProductDescriptionButton) {
	var descriptionCont = $('product-description'),
		descriptionContInner = $('product-description-inner'),
		dragHandle = $('pdesc-draghandle'),
		resizeHandle = $('pdesc-resizehandle');

	descriptionCont.makeDraggable({
		handle: dragHandle
	});

	descriptionContInner.makeResizable({
		handle: resizeHandle,
		limit: {x:[150,800], y:[100,1000]}
	});
}
