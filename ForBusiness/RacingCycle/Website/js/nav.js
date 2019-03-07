
jQuery.extend( jQuery.easing,
{

	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},

});

(function(jQuery){
     jQuery.fn.extend({
         accordion: function() {       
            return this.each(function() {
		
				function activate(el,effect){
					
					
					jQuery(el).siblings( panelSelector )[(effect || activationEffect)](((effect == "show")?activationEffectSpeed:false),function(){
jQuery(el).parents().show();
					
					});
					
				}
				
            });
        }
    }); 
})(jQuery);

jQuery(function($) {
	$('.accordion').accordion();
	
	$('.accordion').each(function(index){
		var activeItems = $(this).find('li.active');
		activeItems.each(function(i){
			$(this).children('ul').css('display', 'block');
			if (i == activeItems.length - 1)
			{
				$(this).addClass("current");
			}
		});
	});
	
});

(function($) {
	$.fn.listsplit = function(options){			
			var settings = $.extend({
				// These are the defaults.
				columns: 3,
				list_class:'split',
				list_item:'li',
			}, options );			
		
			this.each(function() {
				  var items_per_col = Math.ceil($(this).children('li').length / settings.columns),
				  group;
				  while((group = $(this).children('li:lt(' + items_per_col + ')').remove()).length){
					var ul = $('<ul/>');
					ul.addClass(settings.list_class);
					$(this).parent().append(ul.append(group));
				  }
				  $(this).remove();
			});		
		
		
	};
    
})(jQuery);

/*-------- End Nav js -------------------*/	