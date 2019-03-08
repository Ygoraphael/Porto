function cpSeeMoreEvent(_moduleData) {

	this.moduleData = _moduleData;
	this.seemoreFadeEffect = null;


	this.init = function() {
		var obj = this,
			moduleContainer = obj.moduleData.moduleContainer;

		// moduleContainer.getElements('.cp-seemore').addEvent('click', function() {
		// 	obj.processSeeMoreClickEvent(this);
		// });

		moduleContainer.addEvent('click:relay(.cp-seemore)', function() {
			obj.processSeeMoreClickEvent(this);
		});
	}


	this.processSeeMoreClickEvent = function(clickedElement) {
		var triggerElement = clickedElement,
			moduleData = this.moduleData,
			list;

		list = (moduleData.seemoreAnchor) ? triggerElement.getPrevious() : triggerElement.getNext();

		if (moduleData.seemoreUseAjax) {
			if (triggerElement.getAttribute('loaded') != 1) {
				var loader = triggerElement.getElement('.cp-loader');
				// var parameters = moduleData.appliedParameters;
				var parameters = document.id('cp' + moduleData.moduleID +
					'_full_urls_params').getAttribute('data-value');

				// parameters += '&action_type=seemore&cp_loading_seemore_with_ajax=1&param_name=' +
				// 	triggerElement.getAttribute('param_name') +
				parameters += '&action_type=seemore&cp_loading_seemore_with_ajax=1&data_value=' +
					triggerElement.getAttribute('data-value') + '&data_type=' + triggerElement.getAttribute('data-type') +
					'&ptids=' + moduleData.productTypeIDs + '&module_id=' + moduleData.moduleID;

				new Request ({
					url: cp_fajax,
					method: 'get',
					data: parameters,
					onRequest: function(){
						triggerElement.setProperty('loaded', 1);
						loader.removeClass('hid');
					},
					onComplete: function(response){
						if (response) {
							loader.destroy();
							list.innerHTML = response;
						} else {
							triggerElement.destroy();
						}
					}
				}).send();
			}
		}

		if (list.hasClass('hid')) {
			triggerElement.getFirst().innerHTML = '-';
			triggerElement.getElement('.cp-seemore-text').innerHTML = moduleData.seelessText;

			if (moduleData.seemoreUseFadein) {
				if (this.seemoreFadeEffect) {
					this.seemoreFadeEffect.stop();
					this.seemoreFadeEffect = null;
				}
				list.setStyle('opacity',0);
				list.removeClass('hid');
				var fade = new Fx.Tween(list, {
					property: 'opacity',
					duration: 400,
					transition: Fx.Transitions.Quad.easeInOut
				});
				this.seemoreFadeEffect = fade;
				fade.start(0,1);
			} else {
				list.removeClass('hid');
			}
		} else {
			list.addClass('hid');
			triggerElement.getFirst().innerHTML = '+';
			triggerElement.getElement('.cp-seemore-text').innerHTML = moduleData.seemoreText;
		}

	}

}
