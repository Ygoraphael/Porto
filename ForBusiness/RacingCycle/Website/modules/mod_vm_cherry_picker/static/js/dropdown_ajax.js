cpDropdownLayoutEvents.prototype.loadFilters = function(_filtersContainer) {

	var filtersContainer = document.id(_filtersContainer),
		groupName = filtersContainer.getAttribute('data-groupname'),
		parameters;

	// parameters = this.moduleData.appliedParameters;
	parameters = document.id('cp' + this.moduleData.moduleID +
		'_full_urls_params').getAttribute('data-value');
	// parameters += '&action_type=get_dd_filters&param_name=' + groupName + '&ptids=' +
	// 	this.moduleData.productTypeIDs + '&module_id=' + this.moduleData.moduleID;
	parameters += '&action_type=get_dd_filters&data_value=' + groupName +
		'&data_type=' + filtersContainer.getAttribute('data-type') + '&ptids=' +
		this.moduleData.productTypeIDs + '&module_id=' + this.moduleData.moduleID;

	var obj = this;
	new Request ({
		url: cp_fajax,
		method: 'get',
		data: parameters,
		onRequest: function(){
			filtersContainer.setProperty('data-loaded', 1);
		},
		onComplete: function(response){
			if (response == '') {
				if (obj.moduleData.removeEmptyParameters) {
					filtersContainer.getPrevious().destroy();
					filtersContainer.destroy();
				} else {
					filtersContainer.innerHTML = '<div style="opacity:0.5;padding:10px 20px">' +
						obj.moduleData.noFiltersMessage + '</div>';
					filtersContainer.getPrevious().addClass('transparent');
				}
			} else {
				filtersContainer.firstChild.innerHTML = response;
			}
		}
	}).send();
}
