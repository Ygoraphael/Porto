<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $cur_url = $this->uri->segment(1).'/'.$this->uri->segment(2); ?>

<!DOCTYPE html>
<?php $this->load->view('admin/header_admin'); ?>
	<body>
	<div class="loading-overlay">
		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div>
	<div class="am-wrapper">
		<!-- Fixed navbar -->
		<nav class="navbar navbar-default navbar-fixed-top am-top-header">
			<?php $this->load->view('admin/admin_menu_top'); ?>
		</nav>
		<div class="am-left-sidebar">
			<?php $this->load->view('admin/admin_menu_left'); ?>
		</div>
		<!-- *****************************************************************************************************************
			MIDDLE CONTENT
			***************************************************************************************************************** -->
		<div class="am-content">
			<div class="page-head col-md-12">
				<div class="col-md-6 col-sm-12">
					<h2><?php echo $title."".$pagina."";?></h2>
					<ol class="breadcrumb">
					
					<?php 
					$breabcrumb = $this->uri->segment_array();
					$total = count($breabcrumb);
					$baseurl = base_url();
					$baseurlaux = "";
					$aux =1;
					foreach ($breabcrumb as $value) {
						$baseurlaux= $baseurlaux.''.$value.'/';
						if($value == "admin" && $aux != $total){
							echo '<li><a href="'.$baseurl.'admin">Home</a></li>';
						}else if($value == "admin" && $aux == $total){
							echo '<li class="active">Home</li>';
						}else if($aux == $total){
							echo '<li class="active">'.$value.'</li>';
						}else if($aux != $total){
							echo '<li><a href="'.$baseurl.''.$baseurlaux.'">'.$value.'</a></li>';	
						}
						$aux++;
					}
					?>
					
					</ol>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class=" btn-space">
						<?php $cur_url = $this->uri->segment(1).'/'.$this->uri->segment(2); 
						if( $buttons == '1'){?>
						
							<button onclick="update_menuitem();"type="button" class="btn btn-default btn-lg"><i class="icon s7-diskette"></i> SAVE</button>
							<button type="button" class="btn btn-default btn-lg"><i class="icon s7-copy-file"></i> COPY</button>
							<button type="button" class="btn btn-default btn-lg"><i class="icon s7-trash"></i> TRASH</button>
							<button onclick="location.href ='<?php echo base_url().$url; ?>';" type="button" class="btn btn-default btn-lg"><i class="icon s7-close-circle"> </i>CLOSE</button>
						<?php }elseif( $buttons == '2'){?>
							<button onclick="location.href ='<?php echo base_url().$url; ?>';"type="button" class="btn btn-default btn-lg"><i class="icon s7-diskette"></i> NEW</button>
							<button type="button" class="btn btn-default btn-lg"><i class="icon s7-copy-file"></i> COPY</button>
							<button id="delete" type="button" class="btn btn-default btn-lg"><i class="icon s7-trash"></i> TRASH</button>	
						<?php } if( $buttons == '3'){ ?>
						<button onclick="criar_menuitem();" type="button" class="btn btn-default btn-lg"><i class="icon s7-diskette"></i> SAVE</button>
							<button type="button" class="btn btn-default btn-lg"><i class="icon s7-copy-file"></i> COPY</button>
							<button type="button" class="btn btn-default btn-lg"><i class="icon s7-trash"></i> TRASH</button>
							<button onclick="window.history.back();" type="button" class="btn btn-default btn-lg"><i class="icon s7-close-circle"> </i>CLOSE</button>
						<?php }						
						?>
					</div>
				</div>
			</div>
			
			<div class="main-content col-sm-12">
				<div class="row" id="debug_message">
					<?php 
					if (isset($error)) {
						echo $error; 
					}
					?>
				</div>
			
				<?php
					// This is the main content partial
					echo $this->template->content;
				?>
			</div>
		</div>
		<nav class="am-right-sidebar">
			<?php //$this->load->view('admin/admin_menu_right'); ?>
		</nav>
		<!-- *****************************************************************************************************************
			FOOTER
			***************************************************************************************************************** -->
		
	</body>
	<!-- Modal -->
	<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<?php $this->load->view('admin/footer_admin'); ?>

