<script>
$(function() {
	var mglass = $('.magnifying-glass');
	var form = $('.header-search-box');
	mglass.click(function() {
		if (form.is(':hidden')) {
			form.css("display", "inline");
			form.show().focus()
			form.animate({
				'width': '15rem'
			}, 'fast', function() {
				if (form.width() == 0) {
					form.hide();
				}
			});
		}
		else {
			form.animate({
				'width': '0px'
			}, 'fast', function() {
				if (form.width() == 0) {
					form.hide();
					form.css("display", "none");
				}
			});
		}
	});
});

$("a").on("click", function(){
	$(this).siblings(".sub-menu").slideToggle();
});

$('.off-canvas-wrap').foundation('offcanvas', 'show', 'move-right');
$('.off-canvas-wrap').foundation('offcanvas', 'hide', 'move-right');
$('.off-canvas-wrap').foundation('offcanvas', 'toggle', 'move-right');
</script>