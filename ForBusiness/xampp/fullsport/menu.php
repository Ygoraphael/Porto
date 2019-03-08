<ul class="off-canvas-list">
	<li><img src='img/logo.png'/></li>
	<li style="padding:1.6rem 0 1.6rem 0; background:#262626; color:white; font-size:0.9rem;">
		<div class="row">
			<div class="left" style="width:20%; padding-left:5%;">
				<img style="width:80%;" src='img/cl/user0000001.png'/>
			</div>
			<div class="left" style="font-size:0.8rem; padding-top:1rem;">
				Carlos Pereira
			</div>
			<div class="left" style="padding-left:5px;">
				<i class="icon-sort-down"></i>
			</div>
		</div>
	</li>
	<li><a href="index.php" class="<?php if($pag=="index") echo "menunavsel"?>"><i style="margin-right:5px;" class="step fi-home size-12"></i>Inicio</a></li>
	<li>
		<a class="<?php if($pag=="node10" or $pag=="node11") echo "menunavsel"?>" href="#"><i style="margin-right:5px;" class="step fi-calendar size-12"></i>Tareas<i class="step fi-plus size-11 right"></i></a>
		<ul class="sub-menu" style="<?php if($pag=="node10" or $pag=="node11") echo "display:block;"; else echo "display:none;"; ?>">
			<li><a href="node10.php" class="<?php if($pag=="node10") echo "menuitemsel"?>">Importante</a></li>
			<li><a href="#">Mensajes</a></li>
		</ul>
	</li>
	<li>
		<a href="#"><i style="margin-right:5px;" class="step fi-euro size-12"></i>Presupuestos<i class="step fi-plus size-11 right"></i></a>
		<ul class="sub-menu" style="display:none;">
			<li><a href="#">Crear</a></li>
			<li><a href="#">Cunsultar</a></li>
		</ul>
	</li>
	<li>
		<a href="#" class="<?php if($pag=="node32") echo "menunavsel"?>"><i style="margin-right:5px;" class="step fi-pencil size-12"></i>Diseño<i class="step fi-plus size-11 right"></i></a>
		<ul class="sub-menu" style="<?php if($pag=="node31" or $pag=="node32") echo "display:block;"; else echo "display:none;"; ?>">
			<li><a href="#">Listado</a></li>
			<li><a href="#">Idea y Logotipos</a></li>
			<li><a href="node32.php" class="<?php if($pag=="node32") echo "menuitemsel"?>">Maqueta</a></li>
			<li><a href="#">Muestra en Tejido</a></li>
		</ul>
	</li>
	<li><a href="#"><i style="margin-right:5px;" class="step fi-shopping-cart size-12"></i>Pedidos<i class="step fi-plus size-11 right"></i></a></li>
	<li>
		<a href="#"><i style="margin-right:5px;" class="step fi-page size-12"></i>Facturación<i class="step fi-plus size-11 right"></i></a>
		<ul class="sub-menu" style="display:none;">
			<li><a href="#">Cunsultar</a></li>
		</ul>
	</li>
	<li><a href="#"><i style="margin-right:5px;" class="step fi-shopping-bag size-12"></i>Envios<i class="step fi-plus size-11 right"></i></a></li>
	<li>
		<a class="<?php if($pag=="node70" or $pag=="node71") echo "menunavsel"?>" href="#"><i style="margin-right:5px;" class="step fi-torsos-all size-12"></i>Clientes<i class="step fi-plus size-11 right"></i></a>
		<ul class="sub-menu" style="<?php if($pag=="node70" or $pag=="node71") echo "display:block;"; else echo "display:none;"; ?>">
			<li><a href="#">Crear</a></li>
			<li><a href="node71.php" class="<?php if($pag=="node71") echo "menuitemsel"?>">Cunsultar</a></li>
		</ul>
	</li>
	<li><a href="#"><i style="margin-right:5px;" class="step fi-wrench size-12"></i>Control Calidade<i class="step fi-plus size-11 right"></i></a></li>
</ul>