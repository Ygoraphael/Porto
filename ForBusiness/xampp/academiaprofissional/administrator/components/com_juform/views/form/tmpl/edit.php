<?php
/**
 * ------------------------------------------------------------------------
 * JUForm for Joomla 3.x
 * ------------------------------------------------------------------------
 *
 * @copyright      Copyright (C) 2010-2016 JoomUltra Co., Ltd. All Rights Reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @author         JoomUltra Co., Ltd
 * @website        http://www.joomultra.com
 * @----------------------------------------------------------------------@
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.tabstate');
?>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		var spinOpts = {
			lines    : 12, 
			length   : 8, 
			width    : 6, 
			radius   : 25, 
			corners  : 1, 
			rotate   : 0, 
			direction: 1, 
			color    : '#999', 
			speed    : 1.5, 
			trail    : 80, 
			shadow   : false, 
			hwaccel  : false, 
			className: 'spinner', 
			zIndex   : 2e9, 
			top      : 'auto', 
			left     : 'auto', 
			display  : 'none'
		};

		var form = $('#adminForm');
		var spinner = new jQuerySpinner(spinOpts).spin(form[0]);

		
		triggerScreenResize();
		
		$('ul.nav-tabs li a[href=\"#field_config\"], ul.nav-tabs li a[href=\"#design\"], ul.nav-tabs li a[href=\"#script\"]').on('click', function(){
			triggerScreenResize();
		});
	});

	function triggerScreenResize(){
		jQuery(window).trigger('resize');
		var evt = document.createEvent('UIEvents');
		evt.initUIEvent('resize', true, false, window, 0);
		window.dispatchEvent(evt);
	}

	function showSpinner(){
		$ = jQuery.noConflict();
		var spinnerDiv = $('#adminForm .spinner');
		var topPosition = $(window).height() / 2;
		var leftPosition = $(window).width() / 2;
		spinnerDiv.css({'top': topPosition + 'px', 'left': leftPosition + 'px'}).stop().fadeIn();
	}

	function hideSpinner(){
		$ = jQuery.noConflict();
		var spinnerDiv = $('#adminForm .spinner');
		spinnerDiv.stop().fadeOut();
	}

	Joomla.submitbutton = function (task) {
		if (task == 'form.cancel') {
			Joomla.submitform(task, document.getElementById('adminForm'));
		}else if(task == 'form.preview'){
			window.open('<?php echo JRoute::_(JUri::root(true).'/index.php?option=com_juform&view=form&id='.$this->item->id); ?>', '_blank');
		}else if(task == 'form.submissions'){
			window.open('<?php echo JRoute::_(JUri::base(true).'/index.php?option=com_juform&view=submissions&list[form_id]='.$this->item->id); ?>', '_blank');
		}else if(document.formvalidator.isValid(document.getElementById("adminForm"))) {
			$ = jQuery.noConflict();
			var templateId = $('#jform_template_id').val();
			if($('#jform_template_type').val() == 1){
				var formData = $('#adminForm :not(#task, #jform_template_code)').serialize();
				$.ajax({
					url: 'index.php?option=com_juform&task=form.generateTemplate',
					data: formData,
					type: 'POST',
					dataType: 'html',
					beforeSend: function () {
						showSpinner();
					}
				}).done(function(data) {
					if(data){
						if(Joomla.editors.instances['jform_template_code'])
						{
							Joomla.editors.instances['jform_template_code'].setValue(data);
						}
						else
						{
							$('#jform_template_code').val(data);
						}
						
						Joomla.submitform(task, document.getElementById('adminForm'));
					}

					hideSpinner();
				});
			}else{
				Joomla.submitform(task, document.getElementById('adminForm'));
			}
		}
	};
</script>

<div id="iframe-help"></div>

<form action="<?php echo JRoute::_('index.php?option=com_juform&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="form-inline form-inline-header">
		<?php
		echo $this->form->getControlGroup('title');
		echo $this->form->getControlGroup('alias');
		$this->form->removeField('title');
		$this->form->removeField('alias');
		?>
	</div>

	<div class="form-horizontal">
		<div class="row-fluid">
			<?php echo JHtml::_('bootstrap.startTabSet', 'formtab', array('active' => 'details')); ?>
			<?php
                
                                        
                    $db = JFactory::getDbo();
                    
                    $query = $db->getQuery(true);
                    $query->select('*');
                    $query->from($db->quoteName('cursos'));
                   

                    $db->setQuery($query);
                    $results = $db->loadAssocList();
            
                    ///////////////////////////////
                    
                    $query = $db->getQuery(true);
                    $query->select('*');
                    $query->from($db->quoteName('w2auh_juform_forms'));
                   

                    $db->setQuery($query);
                    $resultsIsSelected = $db->loadAssocList();
            
            
                    /////////////////////////////////////
            
                    $query = $db->getQuery(true);
                    $query->select('*');
                    $query->from($db->quoteName('w2auh_menu'));
                    $query->where($db->quoteName('menutype') . ' = ' . $db->quote('newPage'). 'AND published = 1');

                    $db->setQuery($query);
                    $resultsPagina = $db->loadAssocList();
                    ////////////////////////////////////////
                    
            
                    $query = $db->getQuery(true);
                    $query->select('*');
                    $query->from($db->quoteName('w2auh_content'));
                    $query->where($db->quoteName('catid') . ' = 89');

                    $db->setQuery($query);
                    $resultsAfter = $db->loadAssocList();
            
                    ////////////////////////////////////////
            
            
                
				$fields = $this->form->getFieldSet('details');
				if ($fields)
				{
					echo JHtml::_('bootstrap.addTab', 'formtab', 'details', JText::_('COM_JUFORM_FIELD_SET_DETAILS'));
					foreach ($fields AS $field)
					{
                      
                         if($field->fieldname == 'curso'){
                                
                               echo '<div class="control-group">
							<div class="control-label">
								<label title="' . JText::_('Curso') . '" class="hasTooltip" for="jform_shortcode" id="jform_shortcode-lbl" data-original-title="">
									' . JText::_('Curso') . '
								</label>
							</div>
							<div class="controls">
                                <select id="jform_curso" name="jform[curso]">';
                             
                                  echo '<option value=""> </option>';
                       
                                  foreach ($results as $linha) {
                                    
                                      foreach ($resultsIsSelected as $rowCurso){
                                
                                          
                                          if($_GET['id']==$rowCurso['id']){
                                              
                                              if($rowCurso['curso']==$linha['ID'] ){
                                              
                                                echo '<option selected value="'.$linha['ID'].'">'.$linha['NomeCurso'].'</option>';
                                              
                                             }else{
                                              
                                                echo '<option value="'.$linha['ID'].'">'.$linha['NomeCurso'].'</option>';
                                              
                                             }
                                              
                                          }
        
                                      }
                                   
                                  }
                                 
                                echo'</select>
                            </div>
						</div>';
                               
                            }else if($field->fieldname == 'pagina'){
                                
                               echo '<div class="control-group">
							<div class="control-label">
								<label title="' . JText::_('Pagina') . '" class="hasTooltip" for="jform_shortcode" id="jform_shortcode-lbl" data-original-title="">
									' . JText::_('Pagina') . '
								</label>
							</div>
							<div class="controls">
                                <select id="jform_pagina" name="jform[pagina]">';
                             
                                  echo '<option value=""> </option>';
                             
                                  foreach ($resultsPagina as $linhaPagina) {
                                    
                                      foreach ($resultsIsSelected as $rowPagina){
                                       
                                          if($_GET['id']==$rowPagina['id']){
                                          
                                              if($linhaPagina['id']==$rowPagina['pagina']){

                                                  echo '<option selected value="'.$linhaPagina['id'].'">'.$linhaPagina['title'].'</option>';

                                              }else{

                                                  echo '<option value="'.$linhaPagina['id'].'">'.$linhaPagina['title'].'</option>';

                                              }
                                          }
                                      }
                                     
                                  }
                                 
                                 
                                echo'</select>
                            </div>
						</div>';
                               
                            }else if ($field->fieldname == 'modified' || $field->fieldname == 'modified_by'){
                            

                                if ($this->item->modified_by)
                                    
                                {
                                    echo $field->getControlGroup();
                                }

                                 }
                                 else{
                                      echo $field->getControlGroup();
                                 }
					        }

                    
					echo '<div class="control-group">
							<div class="control-label">
								<label title="' . JText::_('COM_JUFORM_FIELD_SHORT_CODE_DESC') . '" class="hasTooltip" for="jform_shortcode" id="jform_shortcode-lbl" data-original-title="">
									' . JText::_('COM_JUFORM_FIELD_SHORT_CODE_LABEL') . '
								</label>
							</div>
							<div class="controls">{juform id="' . $this->item->id . '"}</div>
						</div>';

					echo JHtml::_('bootstrap.endTab');
                    
                    
                    
				}
			?>

			<?php echo JHtml::_('bootstrap.addTab', 'formtab', 'field_config', JText::_('COM_JUFORM_FIELD_SET_FIELDS')); ?>
			<?php
			$fields = $this->form->getFieldSet('field_config');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
						echo $field->input;
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php /*echo JHtml::_('bootstrap.addTab', 'formtab', 'design', JText::_('COM_JUFORM_FIELD_SET_DESIGN')); ?>
			<div class="row-fluid">
				<div class="span9">
					<?php
					$fields = $this->form->getFieldSet('design');
					if ($fields)
					{
						foreach ($fields AS $field)
						{
							if($field->fieldname != 'template_code')
							{
								echo $field->getControlGroup();
							}
							else
							{
								echo '<div class="template_code">';
								echo $field->input;
								echo '</div>';
							}

						}
					}
					?>
				</div>
				<div class="span3 form-vertical">
					<?php
					$templates = JUFormFrontHelper::getTemplates();
					foreach($templates AS $template)
					{
						$fieldSets = $this->form->getFieldsets("template_params.".$template->folder);
						if ($fieldSets)
						{
							echo '<div id="template-'.$template->id.'" class="template-params">';
							echo JHtml::_('bootstrap.startAccordion', 'template-'.$template->folder.'-sliders', array('active' => reset($fieldSets)->name));

							foreach ($fieldSets AS $fieldSet)
							{
								$label = (isset($fieldSet->label) && $fieldSet->label) ? JText::_($fieldSet->label) : JText::_('COM_JUFORM_FIELD_SET_'.strtoupper($fieldSet->name));
								echo JHtml::_('bootstrap.addSlide', 'template-'.$template->folder.'-sliders', $label, $fieldSet->name, $fieldSet->name);

								$fields = $this->form->getFieldSet($fieldSet->name);
								foreach($fields AS $field)
								{
									echo $field->getControlGroup();
								}
								echo JHtml::_('bootstrap.endSlide');
							}

							echo JHtml::_('bootstrap.endAccordion');
							echo '</div>';
						}
					}
					?>
				</div>
			</div>
			<?php //echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'formtab', 'script', JText::_('COM_JUFORM_FIELD_SET_SCRIPT')); ?>
			<fieldset>
				<legend><?php echo JText::_('COM_JUFORM_STYLESHEET'); ?></legend>
				<?php
				$fields = $this->form->getFieldSet('stylesheet');
				if ($fields)
				{
					foreach ($fields AS $field)
					{
						echo $field->getControlGroup();
					}
				}
				?>
			</fieldset>

			<fieldset>
				<legend><?php echo JText::_('COM_JUFORM_JAVASCRIPT'); ?></legend>
				<?php
				$fields = $this->form->getFieldSet('javascript');
				if ($fields)
				{
					foreach ($fields AS $field)
					{
						echo $field->getControlGroup();
					}
				}
				?>
			</fieldset>

			<fieldset>
				<legend><?php echo JText::_('COM_JUFORM_PHP_SCRIPT'); ?></legend>
				<?php
				$fields = $this->form->getFieldSet('php');
				if ($fields)
				{
					foreach ($fields AS $field)
					{
						echo $field->getControlGroup();
					}
				}
				?>
			</fieldset>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php */echo JHtml::_('bootstrap.addTab', 'formtab', 'aftersubmit', JText::_('COM_JUFORM_FIELD_SET_AFTER_SUBMISSION')); ?>
				<?php
				
				if ($fields)
				{
					echo '<div class="control-group">
							<div class="control-label">
								<label title="' . JText::_('Redirecionar') . '" class="hasTooltip" for="jform_shortcode" id="jform_shortcode-lbl" data-original-title="">
									' . JText::_('Redirecionar') . '
								</label>
							</div>
							<div class="controls">
                                <select id="jform_afterprocess_action" name="jform[afterprocess_action]">';
                             
                                $getID=0;
                    
                                  echo '<option value=""> </option>';
                             
                                  foreach ($resultsAfter as $linha) {
                                    
                                      foreach ($resultsIsSelected as $s){
                                        
                                            if($_GET['id']==$s['id']){// Form correcto

                                                 if($s['afterprocess_action']==$linha['id']){// Verificar se o afterprocess_action está preenchido

                                                      echo '<option selected value="'.$linha['id'].'">'.$linha['title'].'</option>';
                                                      $getID=$linha['id'];
                                                     
                                                  }else{

                                                      echo '<option value="'.$linha['id'].'">'.$linha['title'].'</option>';

                                                  }

                                            }  
                                      } 
                                       
                                  }
                    
                                echo'</select>';
                    
                             echo '   
                            </div>
						</div>';
                             
				}
				?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php /*echo JHtml::_('bootstrap.addTab', 'formtab', 'notification', JText::_('COM_JUFORM_FIELD_SET_NOTIFICATIONS')); ?>
			<?php
			$fields = $this->form->getFieldSet('notification');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					echo $field->input;
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'formtab', 'fieldaction', JText::_('COM_JUFORM_FIELD_SET_FIELDACTIONS')); ?>
			<?php
			$fields = $this->form->getFieldSet('field_action');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					echo $field->input;
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'formtab', 'calculation', JText::_('COM_JUFORM_FIELD_SET_CALCULATIONS')); ?>
			<?php
			$fields = $this->form->getFieldSet('calculation');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					echo $field->input;
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'formtab', 'posttolocation', JText::_('COM_JUFORM_FIELD_SET_POST_TO_LOCATION')); ?>
			<?php
			$fields = $this->form->getFieldSet('posttolocation');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					echo $field->getControlGroup();
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php */echo JHtml::_('bootstrap.addTab', 'formtab', 'publishing', JText::_('COM_JUFORM_FIELD_SET_PUBLISHING')); ?>
			<?php
			$fields = $this->form->getFieldSet('publishing');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					 if ($field->fieldname == "modified" || $field->fieldname == "modified_by")
					{
						if ($this->item->modified_by)
						{
							echo $field->getControlGroup();
						}
					}
					else
					{
						echo $field->getControlGroup();
					}
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php /* echo JHtml::_('bootstrap.addTab', 'formtab', 'metadata', JText::_('COM_JUFORM_FIELD_SET_METADATA')); ?>
			<?php
			$fields = $this->form->getFieldSet('metadata');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					echo $field->getControlGroup();
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.endTabSet');	*/?>
		</div>

		<div>
			<input type="hidden" name="task" value="" id="task" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>