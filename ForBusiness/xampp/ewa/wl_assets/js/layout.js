$(document).ready(function() {
	$('#list').click(function(event){
		event.preventDefault();
		$('#products .item').removeClass('grid-group-item');
		$('#products .item').addClass('list-group-item');
		
		$('#products .item .thumbnail .img_bg').addClass('col-lg-6');
		$('#products .item .thumbnail .caption').addClass('col-lg-6');
	});
	$('#grid').click(function(event){
		event.preventDefault();
		$('#products .item').removeClass('list-group-item');
		$('#products .item').addClass('grid-group-item');
		
		$('#products .item .thumbnail .img_bg').removeClass('col-lg-6');
		$('#products .item .thumbnail .caption').removeClass('col-lg-6');
	});
});