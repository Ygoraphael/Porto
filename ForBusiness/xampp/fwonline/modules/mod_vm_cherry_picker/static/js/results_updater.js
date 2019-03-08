function cpUpdateResutsViaAjax(_options) {

	this.options = _options;
	this.pageCache = [];
	this.modulesCache = [];
	this.registeredModules = [];
	this.everPushedHistory = false;
	this.everFiredPopstate = false;
	
	
	this.init = function() {
		
		this.virtuemartContainer = document.getElement(this.options.virtuemartContainerSelector);

		window.onpopstate = this.processBrowserStateChangeEvent.bind(this);

	}



	this.updateResults = function(locationURL) {
		this.setBrowserNewState(locationURL);
		this.createAndDispatchEvent('cpbeforeupdate');
		this.updateProductsPage(locationURL);
		this.updateModules(locationURL);
	}


	this.updateProductsOnly = function(locationURL) {
		this.setBrowserNewState(locationURL);
		this.updateProductsPage(locationURL);
	}


	this.updateProductsPage = function(url) {
		var virtuemartContainer = this.virtuemartContainer;
		// load product results from cache
		// var foundInCache = false;
		for (var i = 0, len = this.pageCache.length; i < len; i++) {
			if (url == this.pageCache[i].url) {
				virtuemartContainer.innerHTML = this.pageCache[i].html.innerHTML;
				eval(this.pageCache[i].javascript);
				// foundInCache = true;
				// break;
				this.activateVirtuemartScripts();
				return;
			}
		}

		// if (!foundInCache) {
			this.loadProductsPage(url);
		// }
	}


	this.loadProductsPage = function(url) {
		var	data = 'tmpl=component',
			virtuemartContainer = this.virtuemartContainer;


		var setProductsLoading = function() {
			var blanket = document.createElement('div');
			blanket.className = 'cp-blanket';
			var loader = document.createElement('div');
			loader.className = 'cp-dynamic-update-loader';
			virtuemartContainer.addClass('cp-position-relative');
			virtuemartContainer.appendChild(blanket);
			virtuemartContainer.appendChild(loader);
		}

		// console.log('loading page');

		var obj = this;
		new Request.HTML({
			method: 'get',
			url: url,
			data: data,
			evalScripts: false,
			onRequest: setProductsLoading,
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				// console.log(responseHTML);
				// console.log(responseTree);
				// console.log(responseJavaScript);
				// console.log(responseElements.filter(obj.options.virtuemartContainerSelector));
				var elementArray = responseElements.filter(obj.options.virtuemartContainerSelector);
				var element;
				if (elementArray) {
					element = elementArray[0];

					// inside response we need to parse all VM pagination links and remove '&tmpl' parameter
					// var tags = element.getElements('.vm-pagination a');
					var tags = element.getElements('a');
					tags.each(function(tag) {
						var uri = new URI(tag.href);
						if (uri.getData('tmpl') != null) {
							var query = uri.get('query');
							var parts = query.split('&');
							parts.splice(parts.indexOf('tmpl=component'), 1);
							uri.set('query', parts.join('&'));

							tag.setProperty('href', uri.toString());
						}
					});

					var formOptions = element.getElements('option');
					formOptions.each(function(optionElement) {
						var uri = new URI(optionElement.value);
						if (uri.getData('tmpl') != null) {
							var query = uri.get('query');
							var parts = query.split('&');
							parts.splice(parts.indexOf('tmpl=component'), 1);
							uri.set('query', parts.join('&'));

							optionElement.setProperty('value', uri.toString());
						}
					});

					virtuemartContainer.innerHTML = element.innerHTML;
					virtuemartContainer.removeClass('cp-position-relative');
					eval(responseJavaScript);
					obj.activateVirtuemartScripts();
					
					var scrolledFromTop = window.scrollY || document.html.scrollTop;
					if (obj.options.scrollToTop && virtuemartContainer.getTop() < scrolledFromTop) {
						var myFx = new Fx.Scroll(window).toElement(virtuemartContainer);
					}
				}
				

				obj.pageCache.push({"url": url, "html": element, "javascript": responseJavaScript});
			}
		}).send();
	}



	this.updateModules = function(url) {
		
		// load modules from cache
		var obj = this;
		
		this.registeredModules.each(function(module) {
		// for (var i = 0, ilen = this.registeredModules.length; i < ilen; i++) {
			var foundInCache = false;
			// var module = this.registeredModules[i];
			// var id = module.container.getAttribute('data-id'),
			var id = module.id,
				moduleCache = obj.modulesCache['id' + id];

			if (typeof moduleCache != "undefined") {

				for (var j = 0, jlen = moduleCache.length; j < jlen; j++) {
					if (url == moduleCache[j].url) {
						// module.container.innerHTML = moduleCache[j].html.innerHTML;
						module.container.innerHTML = moduleCache[j].html;
						eval(moduleCache[j].javascript);
						module.container.dispatchEvent(cpUpdateEvent);
						foundInCache = true;
						break;
					}
				}

			}

			if (!foundInCache) {
				obj.loadModule(module, url);
			}
		// }
		});
		
	}


	this.loadModules = function(locationURL, dataURL) {
		
		if (typeof dataURL == "undefined") {
			var dataURL;
			var index = locationURL.indexOf('?');
			if (index >= 0) {
				dataURL = locationURL.substr(index + 1);
				// remove params that may duplicate when SEF is OFF
				dataURL = this.removeNeedlessParameters(dataURL);
			}
		}

		// console.log('loading modules');

		var obj = this;
		this.registeredModules.each(function(module) {

			obj.loadModule(module, locationURL, dataURL);
			
		});
	}


	this.loadModule = function(module, locationURL, dataURL) {
		if (typeof dataURL == "undefined") {
			var dataURL;
			var index = locationURL.indexOf('?');
			if (index >= 0) {
				dataURL = locationURL.substr(index + 1);
				// remove params that may duplicate when SEF is OFF
				dataURL = this.removeNeedlessParameters(dataURL);
			}
		}

		var setModuleLoading = function() {
			var blanket = document.createElement('div');
			blanket.className = 'cp-blanket';
			var loader = document.createElement('div');
			loader.className = 'cp-dynamic-update-loader';
			module.container.appendChild(blanket);
			module.container.appendChild(loader);
		}

		// console.log('loading module: ', module);
		
		// and here add params back. They may or may not be in the URL, bacuase of SEF
		var data = 'action_type=load_module&option=com_virtuemart&view=category&' +
			cpEnvironmentValues.getEnvironmentValues() + '&' + module.dataURL,
			// id = module.container.getAttribute('data-id');
			id = module.id;

		if (dataURL) data += '&' + dataURL;

		// console.log(data);

		var obj = this;

		new Request.HTML({
			url: cp_fajax,
			data: data,
			method: 'get',
			evalScripts: false,
			onRequest: setModuleLoading,
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				// console.log(responseJavaScript);
				// console.log(responseElements);
				var html = '';
				if (responseElements.length) {
					html = responseElements[0].innerHTML;
				}
				module.container.innerHTML = html;
				eval(responseJavaScript);
				module.container.dispatchEvent(cpUpdateEvent);
				// var container = responseElements[0];
				// module.container.innerHTML = container.innerHTML;
				// eval(responseJavaScript);
				// module.container.dispatchEvent(cpUpdateEvent);

				if (typeof obj.modulesCache['id' + id] == "undefined") {
					obj.modulesCache['id' + id] = [];
				}
				obj.modulesCache['id' + id].push({
					"url": locationURL, 
					"html": html,
					"javascript": responseJavaScript
				});
			}
		}).send();
		
	}


	this.activateVirtuemartScripts = function() {
		// init VM's "Add to Cart" scripts
		if (typeof Virtuemart != "undefined")
			Virtuemart.product(jQuery(".product"));
	}


	this.setBrowserNewState = function(url) {
		var stateObj = {
			url: url
		}

		this.everPushedHistory = true;
		history.pushState(stateObj, "", url);
	}


	this.processBrowserStateChangeEvent = function(event) {
		
		// console.log(event);
		
		// Fix. Chrome and Safari fires onpopstate event onload.
		// Also fix browsing through history when mixed with Ajax updates and Full updates.
		if (this.everPushedHistory == false && event.state == null && this.everFiredPopstate == false)
			return;

		this.everFiredPopstate = true;
		var newURL;

		if (event.state == null) {
			newURL = window.location.href;
		} else {
			newURL = event.state.url;
		}

		
		// console.log(newURL);

		this.createAndDispatchEvent('cpbeforeupdate');
		this.updateProductsPage(newURL);
		this.updateModules(newURL);
	}


	this.registerModule = function(data) {
		this.registeredModules.push(data);
	}


	this.removeNeedlessParameters = function(url) {
		if (url == '')
			return '';

		var needlessParameters = ['option', 'view', 'Itemid',
				'virtuemart_category_id', 'virtuemart_manufacturer_id'];	// 'keyword',
		var parts = url.split('&'),
			result = [];
		
		for (var i = 0, len = parts.length; i < len; i++) {
			var name = parts[i].split('=')[0];
			var index = needlessParameters.indexOf(name);
			if (index == -1) {
				result.push(parts[i]);
			}
		}

		
		url = result.join('&');
		return url;
	}


	this.createAndDispatchEvent = function(eventType) {
		// we can't use 'new Event()' here becuase MooTools (sic!) throws error
		if (typeof CustomEvent == "function") {
			var event = new CustomEvent(eventType);
		} else {
			var event = document.createEvent('Event');
			event.initEvent(eventType, true, true);
		}
		window.dispatchEvent(event);
	}

}
