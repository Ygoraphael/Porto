<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//var_dump($ptData);


?>
<div id="manageProducTypes" class="ptm-main">
	<h2>Product Types</h2>
	<table id="ptList" class="ptm-list" data-nopts="<?php if (!$ptData) echo '1' ?>">
		<tr class="ptm-ttl">
			<td>No.</td>
			<td>Id</td>
			<td class="ptm-name">Name</td>
			<td class="ptm-desc">Description</td>
			<td>Parameters</td>
			<td>Edit</td>
			<td>Order</td>
		</tr>
<?php
	
	if (!$ptData) {
		echo '<tr><td colspan="7" align="center"><i>You do not have Product Types yet.</i></td></tr>';
	} else {
		foreach ($ptData as $i => $pt) {
?>
		<tr class="ptm-vrow" data-ptname="<?php echo $pt['product_type_name'] ?>" data-rownum="<?php echo ($i + 1) ?>"
			data-order="<?php echo $i ?>">
			<td class="ptm-no ptm-open-listener"><?php echo ($i + 1) ?></td>
			<td class="ptm-id ptm-open-listener"><?php echo $pt['product_type_id'] ?></td>
			<td class="ptm-name ptm-open-listener">
				<div><?php echo $pt['product_type_name'] ?></div></td>
			<td class="ptm-desc"><div><?php echo $pt['product_type_description'] ?></div></td>
			<td align="center"><?php echo $pt['count'] ?></td>
			<td><button class="default-button-type-0 ptm-edit">Edit</button>
				<button class="default-button-type-0 ptm-save hid">Save</button> &nbsp;
				<button class="default-button-type-0 ptm-delete">Delete</button></td>
			<td><button class="ptm-reorder" title="Move Up"><span class="ptm-reorder-uparrow"></span></button></td>
		</tr>
<?php
		}
	}
?>
	</table>
	
	<div style="margin-top:15px">
		<button class="default-button-type-0 ptm-addnew-pt">
			<img src="<?php echo FS_URL ?>static/img/plus.png" width="8" height="8" />
			New Product Type
		</button>
	</div>
</div>
	
<div class="ptm-helptips-main">
	<div class="ptm-helptips-ttl">Help &amp; Tips</div>
	<div class="ptm-helptips-cont">What is a <b>Product Type</b>? And why do I need them?
	<br/>
	<br/>
	The main idea behind Product Types lies in dividing a variety of products you have on the site into groups 
	with similar characteristics. 
	These "similar characteristics" are called <i>Parameters</i>.
	<br/>
	<br/>
	Let's have an example for best illustration.
	<br/>For example we have a site that sells various products like <b>Books</b>, <b>Movies</b>, <b>Music</b>, 
	<b>Games</b> etc. 
	Now, if we wanted to create filters for them what Parameters should we create to fit all products? 
	Hardly that would be possible. 
	Even though there may be some parameters that will suit all of them, like <i>Genre</i>, <i>Release Date</i>, 
	there are still quite a lot of 
	differences unique to each type of products, like <b>Books</b> would have <i>Author</i>, <i>Number of Pages</i>, 
	<i>Format</i>; <b>Music</b> might have <i>Duration</i>; <b>Games</b> -- <i>Platform</i> and so on.
	That is why it is a very good idea to create for each type of products a Product Type with Parameters 
	that you wish you customers to filter by:
	<table class="ptm-helptips-table">
		<tr><td><b>Product Type</b></td><td><b>Parameters</b></td></tr>
		<tr><td>Books</td><td>Author<br/>Number of Pages<br/>Genre<br/>Format (Hardcover, Paperback ..)<br/>Release date</td></tr>
		<tr><td>Music</td><td>Duration<br/>Genre<br/>Release date<br/></td></tr>
		<tr><td>Games</td><td>Genre<br/>Platform (PC, Mac, Xbox360, PS3, Wii ..)<br/>Release date<br/>Developer</td></tr>
		<tr><td>...</td><td></td></tr>
	</table>
	</div>
</div>