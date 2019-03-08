<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


?>
<div class="pth-main">
	<h2>How-to create filters using Fast Seller</h2>
	<br/><br/>
	<a href="#" data-el="anchor1" class="hot-links">1. Creating filters</a>
	<br/>
	<a href="#" data-el="anchor2" class="hot-links">2. Assigning filters</a>
	<br/>
	<span id="anchor1"></span>
	<br/><br/>
	You start creating filters by creating a Product Type on <b>Create Filters</b> tab.
	<br/><br/>
	Click <b>New Product Type</b>, specify the name and click <b>Save</b>.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/01.png" height="214" />
	<br/><br/><br/>
	Now click on the name of the newly created Product Type to open it's Parameters.
	<br/><br/>
	Here you would create your Parameters.
	<br/>
	Click <b>Add new parameter</b> to do what it says. Specify the <b>Name</b> and <b>Label</b>.
	Leave <b>Mode</b> to <i>Default</i> or choose an appropriate option if you want a parameter to work as a
	trackbar with one or two sliders or as a color palette.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/02.png" height="417" />
	<br/><br/><br/>
	Please note, <b>Name</b> is a necessary field and it should be unique among all Parameters of all Product Types
	that you create.
	<br/>
	This field will be used in URL so name it nicely.
	<br/><br/><br/>
	Add as many parameters as you wish. And finally, click <b>Save all changes</b>.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/03.png" height="413" />
	<br/><br/>
	<br/><br/><br/>
	<span id="anchor2"></span>
	<br/><br/>
	Now we proceed to assigning filters. Go to <b>Assign Filters</b> tab.
	<br/>
	Here you'll see all your products which you can refine by <i>Category</i>, <i>Product Type</i>,
	using <i>Search</i> field, sort Ascending or Descending order.
	<br/><br/>
	Opposite to product names click on the button to choose and assign appropriate Product Type.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/04.png" height="182" />
	<br/><br/><br/>
	You can select multiple products to make mass-assignement.
	<br/><br/>
	Parameters of the selected Product Type will be loaded.
	<br/>
	Click on the parameter button and start typing filter name into the inputbox.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/05.png" height="139" />
	<br/><br/><br/>
	Press <b>Enter</b> on the keyboard to make entered text an actual filter.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/06.png" height="139" />
	<br/><br/><br/>
	If you wish to assign more then one filter to a produt, just repeat the process: enter text and press Enter.
	<br/><br/>
	You will notice that the button has a <b>light blue glow</b> around its borders. It means that you have made changes
	to data and it is ready to be updated in Database.
	<br/>
	Once you click elsewhere on a page and the pop-up menu is closed Data is being sent to DB.
	<br/>
	When updating is complete the glow will fade away.
	<br/><br/>
	To remove assigned filter from the product either deselect the filter from the Filter List
	or simply click on the gray filter box:
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/09.png" height="107" />

	<br/>
	<br/><br/><br/>
	If you wish to assign more then one Product Type to the same product, just click <b>Add New</b>.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/07.png" height="116" />
	<br/><br/><br/>
	To <b>Delete</b> a Product Type from certain product either double click on the Product Type Name or
	hover your mouse for 1 second for a menu to appear. Click <i>Delete</i>.
	<br/><br/><br/>
	<img src="<?php echo FS_URL ?>static/img/help/08.png" height="123" />
	<br/><br/><br/>
	<br/>
	Now you have a comprehensive knowledge of how to set up filters in your Store.
	<br/><br/><br/>
</div>
<script type="text/javascript">
$$('.hot-links').addEvent('click', function(event) {

	var scrollToElement = $(this.getAttribute('data-el')),
		top;

	event.preventDefault();

	if (scrollToElement) {
		top = scrollToElement.getTop();
		console.log(top);
		window.scrollTo(0, top);
	}

});
</script>
