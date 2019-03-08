window.addEvent('domready', function(){
	var hash=window.location.hash;
	if(hash!='') hash=hash.substr(1);

	new Request.HTML ({
		url: url,
		method: 'get',
		data: hash,
		evalScripts:true,
		update: $('clayout')
	}).send();

	$$('.ui-main-nav').addEvent('click', function() {
		var param=this.getAttribute('data-url'),
			status=$('cstatus');
		window.location.hash=param;

		new Request.HTML ({
			url: url,
			method:'get',
			data: param,
			evalScripts:true,
			onRequest: function(){
				status.removeClass('hid');
			},
			onComplete: function(){
				status.addClass('hid');
			},
			update: $('clayout')
		}).send();
	});

	var hideTopButton = $('hideTop');
	if (hideTopButton) {
		hideTopButton.addEvent('click',function(){
			var body = $$('body')[0],
				top = this.getTop() - body.getStyle('margin-top').toInt() - 10;
			if (body.hasClass('top-hidden')) {
				// body.setStyle('margin-top', 0);
				body.removeAttribute('style');
			} else {
				body.setStyle('margin-top', - top);
			}
			body.toggleClass('top-hidden');
		});
	}

});


function stopEventPropagation(e) {

	var event = e || window.event;
	//if(!event.cancelBubble){
	if (event.cancelBubble) {
		event.cancelBubble = true;
		return;
	}
	event.stopPropagation();
}

function squeeze(str, maxlength) {
	var len = str.length,
		dots = '<b class="threedots">..</b>';

	return (len <= maxlength) ? str : (str.substr(0, maxlength) + dots);
}


// LTrim(string) : Returns a copy of a string without leading spaces.
// borrowed from J1.5
function ltrim(str) {
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(0)) != -1) {
      var j=0, i = s.length;
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;
      s = s.substring(j, i);
   }
   return s;
}

//RTrim(string) : Returns a copy of a string without trailing spaces.
function rtrim(str) {
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      var i = s.length - 1;       // Get length of string
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;
      s = s.substring(0, i+1);
   }
   return s;
}

function trim(str) {
   return rtrim(ltrim(str));
}


/* Decod HTML entities */
var decodeEntities = (function() {
  // this prevents any overhead from creating the object each time
  var element = document.createElement('div');

  function decodeHTMLEntities (str) {
    if(str && typeof str === 'string') {
      // strip script/html tags
      str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
      str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
      element.innerHTML = str;
      str = element.textContent;
      element.textContent = '';
    }

    return str;
  }

  return decodeHTMLEntities;
})();
