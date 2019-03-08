var popMenuHandler = new Class({

	options: {
		button: null,
		menu: null,
		align: 'left',
		valign: 'bottom',
		buttonActiveClass: '',
		event: null,
		onMenuRemove: null
	},

	currentOptions: {},

	initialize: function() {
		this.boundHandler = this.menuAutoRemove.bind(this);
		//this.clickedButton = null;
		this.activeButton = null;
		this.activeMenu = null;
		//this.menuType = null;

	},

	setOptions: function(options) {
		//console.log(this.options);
		for (option in this.options) {
			var value = options[option];
			this.currentOptions[option] = (value) ? value : this.options[option];
		//	this.options[option] = options[option];
			//console.log(option);
			//console.log(options[option]);
		}

		//console.log(this.currentOptions);
	},

	// @param type: for diff types of buttons: 1,2--Glass btn, 3,4--Plain btn. 1,3--position menu relative to right corner, 2,4--left
	//showmenu: function(button, menu, type, event) {
	showMenu: function(options) {
		//this.setOptions(options);

		//stopEventPropagation(this.options.event);
		stopEventPropagation(options.event);

		//console.log(options);
		//clickedButton = this.options.button;
		clickedButton = options.button;


		if (this.activeButton == clickedButton) {
			//console.log('same button');
			this.removeMenu();
			document.removeEvent('click', this.boundHandler);
		} else if (this.activeButton) {
			//console.log('change button');
			this.removeMenu();

			this.setOptions(options);

			this.drawMenu();
			this.activeButton = clickedButton;
			//this.activeMenu = this.options.menu;
			this.activeMenu = this.currentOptions.menu;
		} else {
			//console.log('create event to remove', this.clickedButton);
			this.setOptions(options);
			this.activeButton = clickedButton;
			//this.activeMenu = this.options.menu;
			this.activeMenu = this.currentOptions.menu;
			this.drawMenu();
			document.addEvent('click', this.boundHandler);
		//	window.addEvent('click', this.boundHandler);
		}
	},

	drawMenu: function() {

		//var clickedButton = $(this.options.button),
		var clickedButton = $(this.currentOptions.button),
			//menu = $(this.options.menu),
			menu = $(this.currentOptions.menu),
			butpos = clickedButton.getPosition(),
			butsize = butsize = clickedButton.getSize(),
			menusize,
			viewportWidth = document.body.getWidth(),
			left, top;

		//var menu = $(this.clickedButton.getAttribute('data'));

		//if (this.menuType == 1 || this.menuType == 2){
		//	$(this.clickedButton).addClass('glass-btn-active');
		//} else if (this.menuType == 3 || this.menuType == 4) {
//			$(this.clickedButton).addClass('prodparam-btn-active');
//		} else {
//			$(this.clickedButton).addClass('tabletop-btn-active');
//		}

		//clickedButton.addClass(this.options.buttonActiveClass);
		var activeClass = this.currentOptions.buttonActiveClass;
		if (activeClass) clickedButton.addClass(activeClass);


		menu.removeClass('hid');

		menusize = menu.getSize();

		//switch (this.options.align) {
		switch (this.currentOptions.align) {
			case 'left':
				left = butpos.x;
				break;

			case 'right':
				left = butpos.x + butsize.x - menusize.x;
				break;

			case 'center':
				left = butpos.x + butsize.x / 2 - menusize.x / 2;
		}

		var rightMargin = left + menusize.x;
		if (rightMargin > viewportWidth) left -= rightMargin - viewportWidth;

		switch (this.currentOptions.valign) {
			case 'top':
				top = butpos.y - menusize.y;
				break;

			case 'bottom':
				top = butpos.y + butsize.y;
		}



	/*
		if (this.menuType==1) {
			var left=butpos.x+butsize.x-menusize.x;
		} else if (this.menuType==3) {
			var left=butpos.x+butsize.x/2-menusize.x/2;
			if(left<0) left=10;
		} else {
			var left=butpos.x;
		}

		if(this.menuType==5){
			var top=butpos.y+butsize.y-1;
		} else {
			var top=butpos.y+butsize.y+1;
		}
	*/



		menu.setStyles({top:top, left:left});
	},

	// sometimes the content of popup menu is loaded dynamically,
	// and we wish to make sure the menu fits in browser viewport
	repositionMenuIfNeeded: function() {
		var menu = $(this.activeMenu),
			menusize = menu.getSize(),
			menupos = menu.getPosition(),
			viewportWidth = document.body.getWidth();

		if ((menupos.x + menusize.x) > viewportWidth)
			menu.setStyle('left', viewportWidth - menusize.x);

	},

	removeMenu: function() {

		$(this.activeMenu).addClass('hid');

		//$(this.activeButton).removeClass(this.options.buttonActiveClass);
		var activeClass = this.currentOptions.buttonActiveClass;
		if (activeClass) $(this.activeButton).removeClass(activeClass);

		/*
		$(this.activeButton.getAttribute('data')).addClass('hid');

		if ($(this.activeButton).hasClass('glass-btn')) {
			$(this.activeButton).removeClass('glass-btn-active');
		} else if ($(this.activeButton).hasClass('prodparam-btn')) {
			$(this.activeButton).removeClass('prodparam-btn-active');
		} else if ($(this.activeButton).hasClass('ui-tabletop-btn')) {
			$(this.activeButton).removeClass('tabletop-btn-active');
		}
		*/

		this.activeButton = null;
		this.activeMenu = null;

		//if (this.options.onMenuRemove) this.options.onMenuRemove();
		if (this.currentOptions.onMenuRemove) this.currentOptions.onMenuRemove();
	},

	removeBoundEvent: function() {
		document.removeEvent('click',this.boundHandler);
	},

	hidePopupMenu: function() {
		this.removeMenu();
		this.removeBoundEvent();
	},

	menuAutoRemove: function(event) {

	/*
		var menu = $(this.activeMenu),
			left = menu.offsetLeft,
			top = menu.offsetTop,
			bottom = top + menu.offsetHeight - 1,
			right = left + menu.offsetWidth - 1,
			clickedOnMenu = false,
			marginX = event.page.x || event.x,
			marginY = event.page.y || event.y;
	*/

	//	if (marginX >= left && marginX <= right && marginY >= top && marginY <= bottom) clickedOnMenu = true;

	//	console.log('on menu: ', clickedOnMenu);
	//	console.log('on menu event: ', event);


		var menu = $(this.activeMenu),
			clickedOnMenu = false,
			parentElement = event.target;

		while (parentElement) {
			//console.log(parentElement);
			if (menu == parentElement) {
				clickedOnMenu = true;
				break;
			}
			parentElement = parentElement.parentNode;
		}

		//if(clickedonmenu) console.log('On menu');

		if (!clickedOnMenu) {
			this.removeMenu();
			document.removeEvent('click', this.boundHandler);
		}
	}
});
