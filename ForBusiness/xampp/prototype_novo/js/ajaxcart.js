var ajaxcart = {
    g: new Growler(),
    initialize: function() {
        this.g = new Growler();		
        this.bindEvents();
    },
    bindEvents: function () {
        this.addSubmitEvent();

        $$('a[href*="/checkout/cart/delete/"]').each(function(e){
            $(e).observe('click', function(event){
                setLocation($(e).readAttribute('href'), this);
                Event.stop(event);
            });
        });        
    },
    ajaxCartSubmit: function (obj, context) {
        var _this = this;
        if(Modalbox !== 'undefined' && Modalbox.initialized)Modalbox.hide();

        try {
            if(typeof obj == 'string') {
                var url = obj;

                new Ajax.Request(url, {

                    onCreate	: function() {
                    	$(context).addClassName('loading');
                        /*_this.g.warn("Please wait...", {
                            life: 5
                        });
                        */
                    },
                    onComplete : function(resposne){
                    	$(context).removeClassName('loading');
                    },
                    onSuccess	: function(response) {
                        // Handle the response content...
                        try{
                            var res = response.responseText.evalJSON();
                            if(res) {
                                //check for group product's option
                                if(res.configurable_options_block) {
                                    if(res.r == 'success') {
                                        //show group product options block
                                        _this.showPopup(res.configurable_options_block);
                                    	_this.refreshUi(url, res);                                    	
                                    } else {
                                        if(typeof res.messages != 'undefined') {
                                            _this.showError(res.messages);
                                        } else {
                                            _this.showError("Something bad happened");
                                        }
                                    }
                                } else {
                                    if(res.r == 'success') {
                                        if(res.message) {											                                        	
                                            _this.showSuccess(res.message);
											_this.refreshUi(url, res);
                                        } else {
                                            _this.showSuccess('Item was added into cart.');
                                        }

                                        //update all blocks here
                                        _this.updateBlocks(res.update_blocks);

                                    } else {
                                        if(typeof res.messages != 'undefined') {
                                            _this.showError(res.messages);
                                        } else {
                                            _this.showError("Something bad happened");
                                        }
                                    }
                                }
                            } else {
                                document.location.reload(true);
                            }
                        } catch(e) {
                        //window.location.href = url;
                        //document.location.reload(true);
                        }
                    }
                });
            } else {
                if(typeof obj.form.down('input[type=file]') != 'undefined') {

                    //use iframe

                    obj.form.insert('<iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>');

                    var iframe = $('upload_target');
                    iframe.observe('load', function(){
                        // Handle the response content...
                        try{
                            var doc = iframe.contentDocument ? iframe.contentDocument : (iframe.contentWindow.document || iframe.document);
                            console.log(doc);
                            var res = doc.body.innerText ? doc.body.innerText : doc.body.textContent;
                            res = res.evalJSON();

                            if(res) {
                                if(res.r == 'success') {
                                    if(res.message) {
                                        _this.showSuccess(res.message);
                                    } else {
                                        _this.showSuccess('Item was added into cart.');
                                    }

                                    //update all blocks here
                                    _this.updateBlocks(res.update_blocks);

                                } else {
                                    if(typeof res.messages != 'undefined') {
                                        _this.showError(res.messages);
                                    } else {
                                        _this.showError("Something bad happened");
                                    }
                                }
                            } else {
                                _this.showError("Something bad happened");
                            }
                        } catch(e) {
                            console.log(e);
                            _this.showError("Something bad happened");
                        }
                    });

                    obj.form.target = 'upload_target';

                    //show loading
                    _this.g.warn("Please wait...", {
                        life: 5
                    });

                    obj.form.submit();
                    return true;

                } else {
                    //use ajax

                    var url	 = 	obj.form.action,
                    data =	obj.form.serialize();
					
					var btn = $(obj.form).down('button.btn-cart');
                    new Ajax.Request(url, {
                        method		: 'post',
                        postBody	: data,
                        onCreate	: function() {
                        	btn.addClassName('loading');
                        },
                        onComplete	: function() {
                        	btn.removeClassName('loading');
                        },                        
                        onSuccess	: function(response) {
                            // Handle the response content...
                            try{
                                var res = response.responseText.evalJSON();

                                if(res) {
                                    if(res.r == 'success') {
                                        if(res.message) {
                                            _this.showSuccess(res.message);
                                            _this.refreshUi('', res);
                                        } else {
                                            _this.showSuccess('Item was added into cart.');
                                        }

                                        //update all blocks here
                                        _this.updateBlocks(res.update_blocks);										if (url.indexOf('updateItemOptions/') > -1){											window.location.href = url.split('updateItemOptions/').shift();										}

                                    } else {
                                        if(typeof res.messages != 'undefined') {
                                            _this.showError(res.messages);
                                        } else {
                                            _this.showError("Something bad happened");
                                        }
                                    }
                                } else {
                                    _this.showError("Something bad happened");
                                }
                            } catch(e) {
                                console.log(e);
                                _this.showError("Something bad happened");
                            }
                        }
                    });
                }
            }
        } catch(e) {
            console.log(e);
            if(typeof obj == 'string') {
                window.location.href = obj;
            } else {
                document.location.reload(true);
            }
        }
    },
    
    getConfigurableOptions: function(url) {
        var _this = this;
        new Ajax.Request(url, {
            onCreate	: function() {
                _this.g.warn("Please wait...", {
                    life: 5
                });
            },
            onSuccess	: function(response) {
                // Handle the response content...
                try{
                    var res = response.responseText.evalJSON();
                    if(res) {
                        if(res.r == 'success') {
                            
                            //show configurable options popup
                            _this.showPopup(res.configurable_options_block);

                        } else {
                            if(typeof res.messages != 'undefined') {
                                _this.showError(res.messages);
                            } else {
                                _this.showError("Something bad happened");
                            }
                        }
                    } else {
                        document.location.reload(true);
                    }
                } catch(e) {
                window.location.href = url;
                //document.location.reload(true);
                }
            }
        });
    },

    showSuccess: function(message) {
        this.g.info(message, {
            life: 5
        });
    },

    showError: function (error) {
        var _this = this;

        if(typeof error == 'string') {
            _this.g.error(error, {
                life: 5
            });
        } else {
            error.each(function(message){
                _this.g.error(message, {
                    life: 5
                });
            });
        }
    },

    addSubmitEvent: function () {

        if(typeof productAddToCartForm != 'undefined') {
            var _this = this;
            productAddToCartForm.submit = function(url){
                if(this.validator && this.validator.validate()){
                    _this.ajaxCartSubmit(this, this);
                }
                return false;
            }

            productAddToCartForm.form.onsubmit = function() {
                productAddToCartForm.submit();
                return false;
            };
        }
    },
    
    refreshUi:function(url, res){
    	var pattern = 'product/' + res.product_id + '/';
        if( url.search('checkout/cart/delete') != -1 ) {
        	//Product list page
        	$$('button.in-cart').each(function(el){
				if($(el).readAttribute('onclick').indexOf(pattern) != -1){
					$(el).removeClassName('in-cart');
					$(el).down('span').update(res.label_update);
				}
			});
			
			//Product view page
			$$('form').each(function(el){
				var btn = $(el).down('button.in-cart');				
				if(($(el).readAttribute('action').indexOf(pattern) != -1) && btn){
					btn.removeClassName('in-cart');
					btn.down('span').update(res.label_update);
				}
			});

        } else {
        	//Product list page
			$$('button.btn-cart').each(function(el){
				if($(el).readAttribute('onclick').indexOf(pattern) != -1){
					$(el).addClassName('in-cart');
					$(el).down('span').update(res.label_update);
				}
			});
			//Product view page
			$$('form').each(function(el){
				var btn = $(el).down('button.btn-cart');				
				if(($(el).readAttribute('action').indexOf(pattern) != -1) && btn){
					btn.addClassName('in-cart');
					btn.down('span').update(res.label_update);
				}
			});			
        }
    },

    updateBlocks: function(blocks) {
        var _this = this;

        if(blocks) {
            try{
                blocks.each(function(block){
                    if(block.key) {
                        var dom_selector = block.key;
                        if($$(dom_selector)) {
                            $$(dom_selector).each(function(e){
                                $(e).update(block.value);
                            });
                        }
                    }
                });
                _this.bindEvents();
                _this.bindNewEvents();

                // show details tooltip
                truncateOptions();
            } catch(e) {
                console.log(e);
            }
        }

    },
    
    bindNewEvents: function() {
        // =============================================
        // Skip Links (for Magento 1.9)
        // =============================================
        
        // Avoid PrototypeJS conflicts, assign jQuery to $j instead of $
        if (typeof(jQuery) != undefined) {

            var $j = jQuery.noConflict();
            var skipContents = $j('.skip-content');
            var skipLinks = $j('.skip-link');

            if (typeof(skipContents) != undefined && typeof(skipLinks) != undefined) {
                
                skipLinks.on('click', function (e) {
                    e.preventDefault();

                    var self = $j(this);
                    var target = self.attr('href');

                    // Get target element
                    var elem = $j(target);

                    // Check if stub is open
                    var isSkipContentOpen = elem.hasClass('skip-active') ? 1 : 0;

                    // Hide all stubs
                    skipLinks.removeClass('skip-active');
                    skipContents.removeClass('skip-active');

                    // Toggle stubs
                    if (isSkipContentOpen) {
                        self.removeClass('skip-active');
                    } else {
                        self.addClass('skip-active');
                        elem.addClass('skip-active');
                    }
                });

                $j('#header-cart').on('click', '.skip-link-close', function(e) {
                    var parent = $j(this).parents('.skip-content');
                    var link = parent.siblings('.skip-link');

                    parent.removeClass('skip-active');
                    link.removeClass('skip-active');

                    e.preventDefault();
                });
            }
        }
    },
    
    showPopup: function(block) {
        try {
            var _this = this;
            //$$('body')[0].insert({bottom: new Element('div', {id: 'modalboxOptions'}).update(block)});
            var element = new Element('div', {
                id: 'modalboxOptions',
                class: 'product-view'
            }).update(block);
            
            var viewport = document.viewport.getDimensions();
            Modalbox.show(element,
            {
                title: 'Please Select Options', 
                width: 510,
                height: viewport.height,
                afterLoad: function() {
                    _this.extractScripts(block);
                    _this.bindEvents();
                }
            });
        } catch(e) {
            console.log(e)
        }
    },
    
    extractScripts: function(strings) {
        var scripts = strings.extractScripts();
        scripts.each(function(script){
            try {
                eval(script.replace(/var /gi, ""));
            }
            catch(e){
                console.log(e);
            }
        });
    }

};

var oldSetLocation = setLocation;
var setLocation = (function() {
    return function(url, context){
    	$j = jQuery.noConflict();
        if( url.search('checkout/cart/add') != -1 ) {
            //its simple/group/downloadable product
            var params = '?qty=' + $j(context).parent().find('input[name="qty"]').val();
            ajaxcart.ajaxCartSubmit(url + params, context);
        } else if( url.search('checkout/cart/delete') != -1 ) {
            ajaxcart.ajaxCartSubmit(url, context);
        } else if( url.search('options=cart') != -1 ) {
            //its configurable/bundle product
            url += '&ajax=true';
            ajaxcart.getConfigurableOptions(url);
        } else {
            oldSetLocation(url);
        }
    };
})();

setPLocation = setLocation;

document.observe("dom:loaded", function() {
    ajaxcart.initialize();
});