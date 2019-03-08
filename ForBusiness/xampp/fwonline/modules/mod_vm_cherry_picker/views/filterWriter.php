<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPFilterWriter {

	private $loadJavascript = true;
	private $loadSeeMoreJavascript = false;
	private $loadTrackbarJavascript = false;
	private $loadParameterTrackbarJavascript = false;
	private $loadCollapseJavascript = false;
	private $loadSimpleListJavascript = false;
	private $loadCheckboxListJavascript = false;
	private $loadSimpleDropdownJavascript = false;
	private $loadDropDownJavascript = false;
	private $loadWarningMessageJavascript = false;
	private $loadQuickrefineJavascript = false;


	public function printFilters($filtersCollection) {
		$conf = CPFactory::getConfiguration();

		if ($conf->get('ajax_request') == false) {
			$this->showWarningsIfNeeded();
		}

		switch ($conf->get('layout')) {
			case CP_LAYOUT_SIMPLE_LIST:
				$this->printSimpleList($filtersCollection);
				break;

			case CP_LAYOUT_CHECKBOX_LIST:
				$this->printCheckboxList($filtersCollection);
				break;

			case CP_LAYOUT_DROPDOWN:
				$this->printDropdown($filtersCollection);
				break;

			case CP_LAYOUT_SIMPLE_DROPDOWN:
				$this->printSimpleDropdown($filtersCollection);
				break;

			default:
				$this->printSimpleList($filtersCollection);
				break;
		}

		if ($this->loadJavascript) $this->loadJavascript();
	}


	private function printSimpleList($filtersCollection) {
		require(CP_ROOT .'views/tmpl/simplelist.php');
	}


	private function printCheckboxList($filtersCollection) {
		require(CP_ROOT .'views/tmpl/checkboxlist.php');
	}


	private function printDropdown($filtersCollection) {
		require(CP_ROOT .'views/tmpl/dropdown.php');
	}


	private function printSimpleDropdown($filtersCollection) {
		require(CP_ROOT .'views/tmpl/simpledropdown.php');
	}


	// private function printSimpleDropdownWithProgressiveLoad($filtersCollection) {
	// 	require(CP_ROOT .'views/tmpl/simpledropdown_progressive_load.php');
	// }

	private function printQuickrefineFieldForGroup($groupName, $appliedFiltersStr = '') {
		require(CP_ROOT .'views/tmpl/quickrefine.php');
	}



	public function printFormStart() {

		$filterDataModel = CPFactory::getFilterDataModel();
		$cid = $filterDataModel->categoryId();
		$mid = $filterDataModel->manufacturerId();
		$keyword = $filterDataModel->searchKeyword();

		//$itemid = JRequest::getVar('Itemid', null);
		$itemid = $filterDataModel->itemId();
		$conf = CPFactory::getConfiguration();
		$moduleID = $conf->get('module_id');

		$app = JFactory::getApplication();
		$sefOn = $app->getCfg('sef');
		$action_url = JRoute::_($filterDataModel->baseURL());

		// autocomplate attribute prevents browsers from storing inputs
		// selection state.
		echo '<form name="cpFiltersForm'. $moduleID .'" method="get"'.
			' action="'. $action_url .'" autocomplete="off">';
		if (!$sefOn) {
			echo '<input type="hidden" name="option" value="com_virtuemart" />';
			echo '<input type="hidden" name="view" value="category" />';
			if ($cid) echo '<input type="hidden" name="virtuemart_category_id" value="'. $cid .'" />';
			if ($mid) echo '<input type="hidden" name="virtuemart_manufacturer_id" value="'. $mid .'" />';
			if ($itemid) echo '<input type="hidden" name="Itemid" value="'. $itemid .'" />';
		}
		
?>
<div class="accordion-title btn btn-primary no-border-radius" style="width:100%;margin-right:5%;">
	<div class="closeIcon hvr-grow">
	<i class="fa fa-times-circle" aria-hidden="true"></i>
	</div>
<span><?= JText::_("NC_FILTERS") ?></span>
</div>
<div class="panel" style="margin-top:-4px;"></div>
<?php
		
		if ($keyword) echo '<input type="hidden" name="keyword" value="'. $keyword .'" />';
		echo '<input type="hidden" name="limitstart" value="0" />';

		$fullURL = $filterDataModel->getAllURLParameters();
		if ($keyword)
			$fullURL .= '&cp_vmlang='. CP_VMLANG;

// $link = 'index.php?option=com_virtuemart&view=category&tv_brand='. urlencode('Bang & Olufsen');
// echo '<a href="'. JRoute::_($link) .'">link</a>';


		echo '<a id="cp'. $moduleID .'_full_urls_params" class="hid" name="full_url" '.
			'data-value="'. $fullURL .'"></a>';
		//echo '<a id="cp'. $moduleID .'_base_url_with_filters" class="hid" name="base_url_with_filters" '.
		//	'data-value="'. JRoute::_($filterDataModel->getURLFor(CP_URL_FILTERS | CP_URL_MANUFACTURERS)) .
		//	'"></a>';
		echo '<a id="cp'. $moduleID .'_base_url" class="hid" name="base_url" '.
			'data-value="'. JRoute::_($filterDataModel->baseURL()) .'"></a>';


		$layout = $conf->get('layout');
		// $layoutRequiresHiddenFilters = ($layout != CP_LAYOUT_CHECKBOX_LIST && $layout != CP_LAYOUT_SIMPLE_DROPDOWN);
		$addOnlyGlobalParameters = ($layout == CP_LAYOUT_CHECKBOX_LIST || $layout == CP_LAYOUT_SIMPLE_DROPDOWN);

		// if ($layoutRequiresHiddenFilters) {
			$parametersData = $filterDataModel->getParametersData();
			foreach ($parametersData as $i => $productType) {
				if ( !$addOnlyGlobalParameters || ($addOnlyGlobalParameters && !$productType['show'])) {

					$filterDataModel->setPTIndex($i);
					foreach ($productType['parameters'] as $j => $parameter) {
						$filterDataModel->setParameterIndex($j);

						if ($parameter['applied_filters'] &&
							( !$productType['show'] ||
								$filterDataModel->currentParameterAttribute('mode') == CP_DEFAULT_PARAMETER))

							echo '<input type="hidden" name="'. $parameter['name'] .'" value="'.
							htmlentities($parameter['applied_filters'], ENT_QUOTES, "UTF-8") .
							'" class="hidden-static-filter" />';
					}

				}
			}
		// }

		$manufacturers = CPFactory::getManufacturersDataModel();
		$manufacturersData = $manufacturers->manufacturersData();
		foreach ($manufacturersData as $mf_category) {
			if ($mf_category['applied_mfs_ids'] && !$addOnlyGlobalParameters)
				echo '<input type="hidden" name="'. $mf_category['slug'] .'" value="'.
					htmlentities($manufacturers->currentMCAppliedMFsSlug(), ENT_QUOTES, "UTF-8") .
					'" class="hidden-static-filter" />';
		}
	}


	private function printTrackbarParameter($parameter) {

		require(CP_ROOT. 'views/tmpl/trackbar_parameter.php');

	}


	private function printColorPaletteParameter($parameter) {

		require(CP_ROOT. 'views/tmpl/color_palette_parameter.php');

	}


	private function printFiltersTitle() {
		// $cid = JRequest::getVar('virtuemart_category_id', null);
		$filterDataModel = CPFactory::getFilterDataModel();
		$cid = $filterDataModel->categoryId();

		$conf = CPFactory::getConfiguration();
		$title_type = $conf->get('title_type');

		if ($cid && $title_type == CP_SHOW_DYNAMIC_TITLE) {
			$cName = $filterDataModel->categoryName($cid);
			//echo '<div class="cp-maintitle">'. $conf->get('dynamic_title') .' <b>'. $cName .'</b></div>';
		} else if ($title_type != CP_DONOT_SHOW_TITLE) {
			//echo '<div class="cp-maintitle">'. $conf->get('static_title') .'</div>';
		}
	}


	private function printPriceForm() {

		require (CP_ROOT. 'views/tmpl/priceform.php');

	}


	private function printSeeMore($attributeValue = '', $attributeType = 'filter') {
		$conf = CPFactory::getConfiguration();
		$useAjax = ($conf->get('use_seemore_ajax')) ? true : false;
		$attributes = ' data-value="'. $attributeValue .'" data-type="'. $attributeType .'"';

		echo '<div class="cp-seemore"'. $attributes .'><span class="cp-seemore-indicator">+</span> '.
			'<span class="cp-seemore-text">'. $conf->get('seemore') .'</span>';

		if ($useAjax) echo '<div class="cp-loader hid"><img src="'. $conf->get('module_url')
			.'static/img/ajax-loader.gif" /></div>';

		echo '</div>';
	}


	private function printTotalProducts() {
		$conf = CPFactory::getConfiguration();
		$filterDataModel = CPFactory::getFilterDataModel();
		// id="cpTotalProducts"
		echo '<div class="cp-totalproducts"><b>'.
			$conf->get('pretext_totalproducts') .'</b> <span>'.
			$filterDataModel->getTotalProductsCount() .'</span></div>';
	}


	private function loadJavascript() {
		$doc = JFactory::getDocument();
		$conf = CPFactory::getConfiguration();

		$filterDataModel = CPFactory::getFilterDataModel();
		$cid = $filterDataModel->categoryId();
		$mid = $filterDataModel->manufacturerId();
		$itemid = $filterDataModel->itemId();
		$keyword = $filterDataModel->searchKeyword();
		$moduleID = $conf->get('module_id');
		$layout = $conf->get('layout');
		$updateResultsViaAjax = $conf->get('enable_dynamic_update');


		if ($this->loadTrackbarJavascript && !(isset($GLOBALS['trackbar_js_added']))) {
			$GLOBALS['trackbar_js_added'] = 1;

			$loadUncompressedJavascript = 0;

			if ($loadUncompressedJavascript || $conf->get('enable_debug')) {
				$js = '<script type="text/javascript" src="'.
					//$conf->get('module_url') .'static/js/cptrackbar.uncompressed.js"></script>';
					$conf->get('module_url') .'static/js/cptrackbar.js"></script>';
			} else {
				$js = '<script type="text/javascript" src="'.
					$conf->get('module_url') .'static/js/cptrackbar.js"></script>';
			}
			$doc->addCustomTag($js);
		}


		if (!(isset($GLOBALS['cp_header_js_added']))) {
			$GLOBALS['cp_header_js_added'] = 1;

			$js = "\n";
			$js .= "var cp_fajax='". $conf->get('module_url') ."ajax/ajax.php';\n";
			$js .= "var cpEnvironmentValues = {};\n";
			//$js .= "cpEnvironmentValues.fajax = '". $conf->get('module_url') ."ajax/ajax.php';\n";
			$js .= "cpEnvironmentValues.categoryID = '$cid';\n";
			$js .= "cpEnvironmentValues.manufacturerID = '$mid';\n";
			$js .= "cpEnvironmentValues.Itemid = '$itemid';\n";
			$js .= "cpEnvironmentValues.keyword = '$keyword';\n";
			$js .= "cpEnvironmentValues.vmLang = '". CP_VMLANG ."';\n";
			$js .= "cpEnvironmentValues.curLang = '". $conf->get('cur_lang') ."';\n";
			$js .= "cpEnvironmentValues.getEnvironmentValues = function() {
				var p = [];
				if (this.categoryID.toInt()) p.push('virtuemart_category_id=' + this.categoryID);
				if (this.manufacturerID.toInt()) p.push('virtuemart_manufacturer_id=' + this.manufacturerID);
				if (this.Itemid) p.push('Itemid=' + this.Itemid);
				if (this.keyword) {
					p.push('keyword=' + this.keyword);
					p.push('cp_vmlang=' + this.vmLang);
				}

				return p.join('&');
			}\n";

			$js .= "cpTrackbars = {};\n";

			$js .= "if (cpBrowserCompatibleFor(CP_DYNAMIC_UPDATE)) {
				var cpUpdateEvent = document.createEvent('Event');
				cpUpdateEvent.initEvent('cpupdate', true, true);
			}\n";

			$js .= "var cpModuleEventsStack = {

				stack: [],

				add: function(eventObj) {
					this.stack.push(eventObj);
				},

				// run: function() {
				// 	for (var i = 0, len = this.stack.length; i < len; i++) {
				// 		this.stack[i].init();
				// 	}
				// }
				run: function() {
					while(this.stack.length) {
						var item = this.stack.pop();
						item.init();
					}
				}

			}\n";

			$js .= "window.addEvent('domready', function() {
				cpModuleEventsStack.run();
			});\n";

			$js .= "var CP_DYNAMIC_UPDATE = 0;\nvar CP_QUICKREFINE=1;
			function cpBrowserCompatibleFor(actionType) {
				if (actionType == CP_DYNAMIC_UPDATE)
					return (Browser.name == 'ie') ? (Browser.version <= 9 ? false : true) : true;
				else if (actionType == CP_QUICKREFINE)
					return (Browser.name == 'ie') ? (Browser.version <= 8 ? false : true) : true;
				return true;
			}\n";


			$doc->addScriptDeclaration($js);

			$option = JRequest::getVar('option', null);
			$loadjQueryCore = ($option != 'com_virtuemart'
					&& ($updateResultsViaAjax || $this->loadCollapseJavascript));
			$loadjQueryUI = ($this->loadCollapseJavascript);


			if ($updateResultsViaAjax) {
				$jstag = '<script type="text/javascript" src="'. $conf->get('module_url') . 'static/js/results_updater.js"></script>';
				$doc->addCustomTag($jstag);
			}

			// jQuery Core is loaded with all other scripts that Virtuemart needs
			// to work properly.
			if ($loadjQueryCore) {
				JHTML::_('behavior.modal');
				if (! class_exists('VmConfig'))
					require(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR .'components'.
						DIRECTORY_SEPARATOR .'com_virtuemart'. DIRECTORY_SEPARATOR .'helpers'.
						DIRECTORY_SEPARATOR .'config.php');

				vmJsApi::jQuery();
				vmJsApi::jPrice();
				vmJsApi::cssSite();
			}

			if ($loadjQueryUI) {
				/* Discussion.
					Some version of Virtuemart do not load jQuery UI by default.
					Since we rely on UI framework, let us add it manually.
					We do not worry about double-load since js() method has checks
					which files it has already loaded and doesn't load them twice.
				*/
				if (method_exists('vmJsApi', 'js')) {
					if (VmConfig::get('google_jquery', true))
						vmJsApi::js('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16', '', true);
					else
						vmJsApi::js('jquery-ui', false, '', true);
				}
			}
		}




		echo '<script type="text/javascript">';
		// echo '"use strict";';
		echo "\n";

		$ptids = implode('|', $filterDataModel->getPTIDsToShow());
		echo "var cpModData = {};\n";
		echo "cpModData.productTypeIDs = '". $ptids ."';\n";
		echo "cpModData.moduleID='". $moduleID ."';\n";
		echo "cpModData.moduleContainer = document.id('cpFilters' + cpModData.moduleID);\n";
		// echo "cpModData.filtersForm = document[\"cpFiltersForm\" + cpModData.moduleID];\n";
		echo "cpModData.updateProducts = ";
			echo ($updateResultsViaAjax) ? 'true' : 'false';
			echo ";\n";
		echo "if (cpBrowserCompatibleFor(CP_DYNAMIC_UPDATE) == false) cpModData.updateProducts = false;\n";




		// Update results with Ajax.BETA
		if ($updateResultsViaAjax) {
			$virtuemartContainer = $conf->get('dynamic_virtuemart_container');
			$scrollToTop = ($conf->get('scroll_to_top')) ? 'true' : 'false';

			echo "if (cpBrowserCompatibleFor(CP_DYNAMIC_UPDATE) == true) {\n";
			// results updater should be initialized just once
			echo "if (typeof cpUpdateResutsViaAjaxObj == 'undefined') {
				var cpUpdateResutsViaAjaxObj = new cpUpdateResutsViaAjax({
					virtuemartContainerSelector: '". $virtuemartContainer ."',
					scrollToTop: ". $scrollToTop ."
				});
				cpModuleEventsStack.add(cpUpdateResutsViaAjaxObj);
			}\n";


			$registerModuleForSelfUpdates = true;

			/*if ($layout == CP_LAYOUT_SIMPLE_LIST) {
				// require_once(CP_ROOT .'static/js/simplelist.js');
				$this->addScript(CP_ROOT .'static/js/simplelist.js');

				echo "\n";
				echo "var cpSimpleListLayoutEventsObj = new cpSimpleListLayoutEvents(cpModData);\n";
				echo "cpModuleEventsStack.add(cpSimpleListLayoutEventsObj);\n";
			} else*/
			if ($layout == CP_LAYOUT_CHECKBOX_LIST || $layout == CP_LAYOUT_SIMPLE_DROPDOWN) {
				$registerModuleForSelfUpdates = $conf->get('update_filters');
				$updateEachStep = $conf->get('update_each_step');

				echo "cpModData.updateEachStep = ";
					echo ($updateEachStep) ? 'true' : 'false';
					echo ";\n";
			}
			// else if ($layout == CP_LAYOUT_SIMPLE_DROPDOWN) {
			// 	$registerModuleForSelfUpdates = $conf->get('update_filters');
			// 	$updateEachStep = $conf->get('update_each_step');

			// 	echo "cpModData.updateEachStep = ";
			// 		echo ($updateEachStep) ? 'true' : 'false';
			// 		echo ";\n";
			// }


			if ($registerModuleForSelfUpdates) {
				echo "cpUpdateResutsViaAjaxObj.registerModule({
					'id': ". $moduleID .",
					'container': cpModData.moduleContainer,
					'dataURL': 'ptids=". $ptids ."&module_id=". $moduleID ."'
				});\n";
			}

			echo "}\n"; // end if (cpBrowserCompatibleFor(CP_DYNAMIC_UPDATE))
		}




		if ($this->loadSeeMoreJavascript) {
			echo "cpModData.seemoreAnchor=". $conf->get('smanchor') .";\n";
			echo "cpModData.seemoreText='". $conf->get('seemore') ."';\n";
			echo "cpModData.seelessText='". $conf->get('seeless') ."';\n";
			echo "cpModData.seemoreUseFadein=". $conf->get('smfadein') .";\n";
			echo "cpModData.seemoreUseAjax=". $conf->get('use_seemore_ajax') .";\n";

			$this->addScript(CP_ROOT .'static/js/seemore.js');

			echo "\n";
			echo "var cpSeeMoreEventObj = new cpSeeMoreEvent(cpModData);\n";
			echo "cpModuleEventsStack.add(cpSeeMoreEventObj);\n";
		}

		if ($this->loadCollapseJavascript) {
			echo "\n";
			echo "cpModData.defaultStateCollapsed=". $conf->get('default_collapsed') .";\n";
			$this->addScript(CP_ROOT .'static/js/toggleCollapse.js');

			echo "\n";
			echo "var cpCollapseEventObj = new cpCollapseEvent(cpModData);\n";
			echo "cpModuleEventsStack.add(cpCollapseEventObj);\n";
		}


		if ($this->loadSimpleListJavascript) {
			$this->addScript(CP_ROOT .'static/js/simplelist.js');

			echo "\n";
			echo "var cpSimpleListLayoutEventsObj = new cpSimpleListLayoutEvents(cpModData);\n";
			echo "cpModuleEventsStack.add(cpSimpleListLayoutEventsObj);\n";
		}


		if ($this->loadCheckboxListJavascript) {
			echo "\n";
			echo "cpModData.cpBaseURL='". $filterDataModel->baseURL() ."';\n";
			echo "cpModData.showLiveResults=". $conf->get('show_liveresult_popup') .";\n";

			$this->addScript(CP_ROOT .'static/js/checkboxList.js');

			echo "\n";
			echo "var cpCheckboxListLayoutEventsObj = new cpCheckboxListLayoutEvents(cpModData);\n";
			echo "cpModuleEventsStack.add(cpCheckboxListLayoutEventsObj);\n";
		}

		if ($this->loadSimpleDropdownJavascript) {
			$simpleDropDownMode = $conf->get('simpledropdown_mode');

			if ($simpleDropDownMode == CP_SIMPLEDROPDOWN_DEFAULT) {
				$this->addScript(CP_ROOT .'static/js/simpledropdown_default.js');

				echo "\n";
				echo "var cpSimpleDropdownLayoutDefaultEventsObj = ".
					"new cpSimpleDropdownLayoutDefaultEvents(cpModData);\n";
				echo "cpModuleEventsStack.add(cpSimpleDropdownLayoutDefaultEventsObj);\n";
			} else if ($simpleDropDownMode == CP_SIMPLEDROPDOWN_SELFUPDATE) {
				$this->addScript(CP_ROOT .'static/js/simpledropdown_selfupdate.js');

				echo "\n";
				echo "var cpSimpleDropdownLayoutSelfUpdateEventsObj = ".
					"new cpSimpleDropdownLayoutSelfUpdateEvents(cpModData);\n";
				echo "cpModuleEventsStack.add(cpSimpleDropdownLayoutSelfUpdateEventsObj);\n";
			} else if ($simpleDropDownMode == CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD) {
				echo "\n";
				echo "cpModData.progressiveLoadAutosubmit=".
					$conf->get('simpledropdown_progressive_loading_autosubmit') .";\n";

				$this->addScript(CP_ROOT .'static/js/simpledropdown_progressive_load.js');

				echo "\n";
				echo "var cpSimpleDropdownLayoutProgressiveLoadEventsObj = ".
					"new cpSimpleDropdownLayoutProgressiveLoadEvents(cpModData);\n";
				echo "cpModuleEventsStack.add(cpSimpleDropdownLayoutProgressiveLoadEventsObj);\n";
			}
		}

		if ($this->loadDropDownJavascript) {
			$loadFiltersWithAjax = $conf->get('dd_load_filters_with_ajax');
			echo "\n";
			echo "cpModData.loadDropdownFiltersWithAjax=". $loadFiltersWithAjax .";\n";

			$this->addScript(CP_ROOT .'static/js/dropdown.js');

			if ($loadFiltersWithAjax) {
				echo "\n";
				echo "cpModData.removeEmptyParameters=". $conf->get('remove_empty_params') .";\n";
				echo "cpModData.noFiltersMessage='". $conf->get('nofilters_msg') ."';\n";

				$this->addScript(CP_ROOT .'static/js/dropdown_ajax.js');
			}

			echo "\n";
			echo "var cpDropdownLayoutEventsObj = new cpDropdownLayoutEvents(cpModData);\n";
			echo "cpModuleEventsStack.add(cpDropdownLayoutEventsObj);\n";
		}

		if ($this->loadTrackbarJavascript) {
			echo "var trackbarLabels = {\n".
					"from: '". htmlentities($conf->get('tb_from'), ENT_QUOTES, "UTF-8") ."',\n".
					"to: '". htmlentities($conf->get('tb_to'), ENT_QUOTES, "UTF-8") ."',\n".
					"all: '". htmlentities($conf->get('tb_all'), ENT_QUOTES, "UTF-8") ."',\n".
					"apply: '". htmlentities($conf->get('tb_apply'), ENT_QUOTES, "UTF-8") ."'\n".
				"}\n";
			// echo "var optimizeTrackbarFPS = true;\n";
		}

		if ($this->loadParameterTrackbarJavascript) {
			$this->addScript(CP_ROOT .'static/js/parameter_trackbar_events.js');
			echo "\n";
			echo "var cpParameterTrackbarEventsObj = new cpParameterTrackbarEvents(cpModData);\n";
			echo "cpModuleEventsStack.add(cpParameterTrackbarEventsObj);\n";
		}

		if ($this->loadWarningMessageJavascript) {
			$this->addScript(CP_ROOT .'static/js/warnings_events.js');

			echo "\n";
			echo "var cpWarningMessageEventsObj = new cpWarningMessageEvents(cpModData);\n";
			echo "cpModuleEventsStack.add(cpWarningMessageEventsObj);\n";
		}

		if ($this->loadQuickrefineJavascript) {
			$this->addScript(CP_ROOT .'static/js/quickrefine.js');

			echo "\n";
			echo "if (cpBrowserCompatibleFor(CP_QUICKREFINE)) {\n";
			echo "cpModData.refineStyle=". $conf->get('quickrefine_style') .";\n";
			echo "cpModData.showPopup=". $conf->get('quickrefine_show_popup') .";\n";
			echo "cpModData.resetOnSubmit=". $conf->get('quickrefine_reset_on_submit') .";\n";
			echo "cpModData.applySelectedStr='". addslashes($conf->get('quickrefine_apply_selected_str')) ."';\n";
			echo "cpModData.removeSelectedStr='". addslashes($conf->get('quickrefine_remove_selected_str')) ."';\n";
			echo "cpModData.nextFilterStr='". addslashes($conf->get('quickrefine_next_filter_str')) ."';\n";
			echo "cpModData.noMatchesStr='". addslashes($conf->get('quickrefine_no_matches_str')) ."';\n";
			echo "cpModData.clickToRemoveStr='". addslashes($conf->get('quickrefine_click_to_remove_str')) ."';\n";
			echo "var cpQuickrefineEventsObj = new cpQuickrefineEvents(cpModData);\n";
			echo "cpModuleEventsStack.add(cpQuickrefineEventsObj);\n";
			echo "} else { document.getElements('.cp-quickrefine-container').setStyle('display', 'none');}\n";
		}

		echo '</script>';
	}


	private function addScript($file) {
		ob_start();
		require_once($file);
		$contents = ob_get_contents();
		ob_end_clean();

		if ($contents) {
			$doc = JFactory::getDocument();
			$doc->addScriptDeclaration($contents);
		}
	}



	public function printDialogToRemoveFilterSelection() {
		$filterDataModel = CPFactory::getFilterDataModel();
		echo JText::_('NOVOSCANAIS_NOFILTER') . '. <a href="'. $filterDataModel->baseURL() .'">' . JText::_('NOVOSCANAIS_CLEAR') . '</a>';
	}


	private function showWarningsIfNeeded() {
		$message = null;
		$messageType = null;
		$conf = CPFactory::getConfiguration();

		if ($conf->get('disable_vm_checking'))
			return;

		$conf->initAssistOptions();
		$firstRun = $conf->getAssist('cp_first_run');

		if ($firstRun) {
			$message = 'It is a first run of Cherry Picker. Make sure you are using an edited Virtuemart\'s '.
				'<b>product.php</b> file. Otherwise, you may find results not being updated. '.
				'Check <a href="http://www.galt.md/index.php?option=com_blog&a=97&Itemid=84">this thread for more info.</a>';
			$messageType = 'first_run_confirm';

		} else {
			require_once(JPATH_ADMINISTRATOR .'/components/com_virtuemart/version.php');
			$currentVMVersion = vmVersion::$RELEASE;
			$lastVMVersion = $conf->getAssist('vm_version');

			if ($lastVMVersion != $currentVMVersion) {
				$message = 'You probably have updated Virtuemart and Virtuemart version has changed. '.
					'Do not forget to re-apply edits to <b>product.php</b> or otherwise filtering results will not be updated. '.
					'Check <a href="http://www.galt.md/index.php?option=com_blog&a=97&Itemid=84">this thread for more info.</a>';
				$messageType = 'vm_version_change';
			}
		}

		if ($message) {
			echo '<div class="cp-warn-cont" id="cpWarningMessage'. $conf->get('module_id') .'" '.
				'data-messagetype="'. $messageType .'"><table><tr>'.
				'<td>'. $message .'</td>'.
				'<td class="cp-warn-close">All is fine, hide message.</td></tr></table></div>';

			$this->loadWarningMessageJavascript = true;
		}
	}



	// -----------------------------------------------------------------------------
	// SEE MORE AJAX. When getting Product Types Data for See More.. in Ajax query,
	// we do not need full data, so we make it easier.
	// ------------------------------------------------------------------------------

	public function printSeeMoreFilters($filtersCollection) {
		if (empty($filtersCollection))
			return;

		$conf = CPFactory::getConfiguration();
		switch ($conf->get('layout')) {
			case 0:
				$this->printSeeMoreFilterForSimpleList($filtersCollection);
				break;

			case 1:
				$this->printSeeMoreFiltersCheckboxList($filtersCollection);
				break;

			default:
				$this->printSeeMoreFilterForSimpleList($filtersCollection);
				break;
		}


	}


	private function printSeeMoreFilterForSimpleList($filtersCollection) {
		$conf = CPFactory::getConfiguration();
		$filterDataModel = CPFactory::getFilterDataModel();
		$mode = $conf->get('select_mode');
		$skip = $conf->get('b4seemore');
		$parameterHiding = $filterDataModel->currentParameterAttribute('hiding_filters');
		$parameterSeeMoreSize = $filterDataModel->currentParameterAttribute('see_more_size');
		if ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE && $parameterSeeMoreSize)
			$skip = $parameterSeeMoreSize;


		$translate = $conf->get('translate');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;
		$useQuickrefine = $conf->get('use_quickrefine');


		$units = $filterDataModel->currentParameterUnits();

		// $quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterShowQuickrefine());
		$quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterAttribute('show_quickrefine'));
		if ($quickrefineParameter) {
			$qrFilterClass = ' cp-qr-filter';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		foreach ($filtersCollection as $i => $filter) {
			if ($i < $skip)
				continue;

			if ($mode == CP_SINGLE_SELECT_MODE) {
				if ($filter['count']) {
					$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
					if ($units)
						$filterName .= $units;
					$dataFilter = '';
					if ($quickrefineParameter) {
						$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
					}
					echo '<li'. $qrFilterParentClass .'><a href="'. $filter['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-filter'. $qrFilterClass .'"'. $dataFilter .'>'.
						$filterName .'</span> ';
					// echo '<li><a href="'. $filter['url'] .'" class="cp-filter-link">'.
					// 	'<span class="cp-filter-filter">'. $filterName .'</span> ';

					if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
					echo '</a></li>';
				}
			} else {

				$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
				if ($units)
					$filterName .= $units;
				$dataFilter = '';
				if ($quickrefineParameter) {
					$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
				}
				if ($filter['count']) {
					if ($filter['applied']) {
						echo '<li'. $qrFilterParentClass .'><a href="'. $filter['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected'. $qrFilterClass .'"'.
							$dataFilter .'>'. $filterName .'</span></a></li>';
					} else {
						echo '<li'. $qrFilterParentClass .'><a href="'. $filter['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter'. $qrFilterClass .'"'.
							$dataFilter .'>'. $filterName .'</span> ';
						if ($showCount)
							echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
						echo '</a></li>';
					}

					// if ($filter['applied']) {
					// 	echo '<li><a href="'. $filter['url'] .'" class="cp-filter-link">'.
					// 	'<span class="cp-filter-checkbox selected"> </span> '.
					// 	'<span class="cp-filter-filter selected">'. $filterName .'</span></a></li>';
					// } else {
					// 	echo '<li><a href="'. $filter['url'] .'" class="cp-filter-link">'.
					// 	'<span class="cp-filter-checkbox"> </span> '.
					// 	'<span class="cp-filter-filter">'. $filterName .'</span> ';
					// 	if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
					// 	echo '</a></li>';
					// }
				} else if ($filter['applied']) {
					echo '<li><span class="cp-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $filterName .'</span></li>';
				}
			}
		}
	}


	private function printSeeMoreFiltersCheckboxList($filtersCollection) {
		$conf = CPFactory::getConfiguration();
		$filterDataModel = CPFactory::getFilterDataModel();

		$skip = $conf->get('b4seemore');
		$parameterHiding = $filterDataModel->currentParameterAttribute('hiding_filters');
		$parameterSeeMoreSize = $filterDataModel->currentParameterAttribute('see_more_size');
		if ($parameterHiding == CP_PARAMETER_HIDE_USING_SEEMORE && $parameterSeeMoreSize)
			$skip = $parameterSeeMoreSize;

		$keys_shift_amount = ($conf->get('order_applied_filters')) ?
			$filterDataModel->currentParameterAppliedFiltersCount() : 0;


		$translate = $conf->get('translate');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;
		//$filtersSkipped = 0;

		$parameterName = $filterDataModel->currentParameterName();
		$units = $filterDataModel->currentParameterUnits();
		$moduleID = $conf->get('module_id');

		$useQuickrefine = $conf->get('use_quickrefine');
		// $quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterShowQuickrefine());
		$quickrefineParameter = ($useQuickrefine && $filterDataModel->currentParameterAttribute('show_quickrefine'));
		if ($quickrefineParameter) {
			$qrFilterClass = ' class="cp-qr-filter"';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		foreach ($filtersCollection as $i => $filter) {
			if ($i < $skip)
				continue;

			$index = $i + $keys_shift_amount;

			$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
			if ($units)
				$filterName .= $units;

			$dataFilter = '';
			if ($quickrefineParameter) {
				$dataFilter = ' data-filter="'. htmlentities($filterName, ENT_QUOTES, "UTF-8") .'"';
			}

			$checked = ($filter['applied']) ? ' checked' : '';

			echo '<li'. $qrFilterParentClass .'><input id="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $index .
				'" type="checkbox" value="'. htmlentities($filter['name'], ENT_QUOTES, "UTF-8") .
				'" class="cp-filter-input" style="font-size:12px;" data-groupname="'. $parameterName .'"'. $checked .' />';
			echo '<label for="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $index .'" class="cp-filter-label">'.
				'<span'. $qrFilterClass . $dataFilter .'>'. $filterName .'</span>';
			if ($showCount)
				echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
			echo '</label>';
			echo '</li>';

			// echo '<li><input id="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $i .'" type="checkbox" value="'.
			// 	htmlentities($filter['name'], ENT_QUOTES, "UTF-8") .'" class="cp-filter-input" data-groupname="'.
			// 	$parameterName .'"'. $checked .' />';
			// echo '<label for="cp'. $moduleID .'_inpt_'. $parameterName .'_'. $i .'" class="cp-filter-label">'. $filterName;
			// if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
			// echo '</label>';
			// echo '</li>';

		}
	}



	// -----------------------------------------------------------------------------
	// SEE MORE AJAX for MANUFACTURERS
	// ------------------------------------------------------------------------------


	public function printSeeMoreManufacturers($manufacturersCollection) {

		if (empty($manufacturersCollection))
			return;

		$conf = CPFactory::getConfiguration();
		switch ($conf->get('layout')) {
			case 0:
				$this->printSeeMoreManufacturersForSimpleList($manufacturersCollection);
				break;

			case 1:
				$this->printSeeMoreManufacturersCheckboxList($manufacturersCollection);
				break;

			default:
				$this->printSeeMoreManufacturersForSimpleList($manufacturersCollection);
				break;
		}


	}

	private function printSeeMoreManufacturersForSimpleList($manufacturersCollection) {
		$conf = CPFactory::getConfiguration();
		$mode = $conf->get('select_mode');
		$skip = $conf->get('b4seemore');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;

		/* These dedicated class names will be used for filters quickrefine feature,
			so they must be in place */
		$useQuickrefine = $conf->get('use_quickrefine');
		$quickrefineManufacturers = ($useQuickrefine && $conf->get('quickrefine_manufacturers'));
		if ($quickrefineManufacturers) {
			$qrFilterClass = ' cp-qr-filter';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		foreach ($manufacturersCollection[0]['mfs'] as $i => $mf) {
			if ($i < $skip)
				continue;

			if ($quickrefineManufacturers)
				$dataFilter = ' data-filter="'. htmlentities($mf['name'], ENT_QUOTES, "UTF-8") .'"';
			else
				$dataFilter = '';

			if ($mode == CP_SINGLE_SELECT_MODE) {
				if ($mf['count']) {
					// echo '<li><a href="'. $mf['url'] .'" class="cp-filter-link">'.
					// 	'<span class="cp-filter-filter">'. $mf['name'] .'</span> ';
					// if ($showCount)
					// 	echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
					// echo '</a></li>';



					echo '<li'. $qrFilterParentClass .'><a href="'. $mf['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-filter'. $qrFilterClass .'"'. $dataFilter .'>'. $mf['name'] .'</span> ';
					if ($showCount)
						echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
					echo '</a></li>';


				}

			} else {
				if ($mf['count']) {
					// if ($mf['applied']) {
					// 	echo '<li><a href="'. $mf['url'] .'" class="cp-filter-link">'.
					// 	'<span class="cp-filter-checkbox selected"> </span> '.
					// 	'<span class="cp-filter-filter selected">'. $mf['name'] .'</span></a></li>';
					// } else {
					// 	echo '<li><a href="'. $mf['url'] .'" class="cp-filter-link">'.
					// 	'<span class="cp-filter-checkbox"> </span> '.
					// 	'<span class="cp-filter-filter">'. $mf['name'] .'</span> ';
					// 	if ($showCount)
					// 		echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
					// 	echo '</a></li>';
					// }


					if ($mf['applied']) {
						echo '<li'. $qrFilterParentClass .'><a href="'. $mf['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected'. $qrFilterClass .'"'. $dataFilter .'>'.
						$mf['name'] .'</span></a></li>';
					} else {
						echo '<li'. $qrFilterParentClass .'><a href="'. $mf['url'] .'" class="cp-filter-link">'.
						'<span class="cp-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter'. $qrFilterClass .'"'. $dataFilter .'>'.
						$mf['name'] .'</span> ';
						if ($showCount)
							echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
						echo '</a></li>';
					}


				} else if ($mf['applied']) {
					echo '<li><span class="cp-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $mf['name'] .'</span></li>';
				}
			}
		}
	}


	private function printSeeMoreManufacturersCheckboxList($manufacturersCollection) {
		$conf = CPFactory::getConfiguration();
		$skip = $conf->get('b4seemore');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;

		$manufacturers = CPFactory::getManufacturersDataModel();
		$manufacturerCategorySlug = $manufacturers->currentManufacturerCategorySlug();
		$moduleID = $conf->get('module_id');

		$keys_shift_amount = ($conf->get('order_applied_filters')) ?
			$manufacturers->currentMFCategoryAppliedManufacturersCount() : 0;

		/* These dedicated class names will be used for filters quickrefine feature,
			so they must be in place */
		$useQuickrefine = $conf->get('use_quickrefine');
		$quickrefineManufacturers = ($useQuickrefine && $conf->get('quickrefine_manufacturers'));
		if ($quickrefineManufacturers) {
			$qrFilterClass = ' class="cp-qr-filter"';
			$qrFilterParentClass = ' class="cp-qr-filter-parent"';
		} else {
			$qrFilterClass = '';
			$qrFilterParentClass = '';
		}

		foreach ($manufacturersCollection[0]['mfs'] as $i => $mf) {
			if ($i < $skip)
				continue;

			$checked = ($mf['applied']) ? ' checked' : '';

			if ($quickrefineManufacturers)
				$dataFilter = ' data-filter="'. htmlentities($mf['name'], ENT_QUOTES, "UTF-8") .'"';
			else
				$dataFilter = '';

			$index = $i + $keys_shift_amount;

			// echo '<li><input id="cp'. $moduleID .'_inpt_'. $manufacturerCategorySlug .'_'. $i .'" type="checkbox" value="'.
			// 	htmlentities($mf['slug'], ENT_QUOTES, "UTF-8") . $dataFilter .
			// 	'" class="cp-filter-input" data-groupname="'. $manufacturerCategorySlug .'"'. $checked .' />';
			// echo '<label for="cp'. $moduleID .'_inpt_'. $manufacturerCategorySlug .'_'. $i .'" class="cp-filter-label">'.
			// 	$mf['name'];
			// if ($showCount)
			// 	echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
			// echo '</label>';
			// echo '</li>';

			echo '<li'. $qrFilterParentClass .'><input id="cp'. $moduleID .'_inpt_'.
				$manufacturerCategorySlug .'_'. $index .
				'" type="checkbox" value="'. htmlentities($mf['slug'], ENT_QUOTES, "UTF-8") .'"'. $dataFilter .
				' class="cp-filter-input" style="font-size:12px;" data-groupname="'. $manufacturerCategorySlug .'"'. $checked .' />';
			echo '<label for="cp'. $moduleID .'_inpt_'. $manufacturerCategorySlug .'_'. $index .
				'" class="cp-filter-label">'.
				'<span'. $qrFilterClass . $dataFilter .'>'. $mf['name'] .'</span>';
			if ($showCount)
				echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
			echo '</label>';
			echo '</li>';

		}
	}




	// -----------------------------------------------------------------------------
	// Methods for AJAX queries for different Layouts like Drop-down or
	// Simple Drop-down.
	// Originally, we could have shown just emply boxes without filters.
	// ------------------------------------------------------------------------------


	public function printParameterFilters($filtersCollection) {
		$conf = CPFactory::getConfiguration();
		switch ($conf->get('layout')) {
			case 2:
				$this->printParameterFiltersForDropdownList($filtersCollection);
				break;

			case 3:
				$this->printParameterFiltersForSimpleDropdownList($filtersCollection);
				break;

			default:
				$this->printParameterFiltersForDropdownList($filtersCollection);
				break;
		}
	}


	private function printParameterFiltersForDropdownList($filtersCollection) {
		//print_r($filtersCollection);

		$conf = CPFactory::getConfiguration();
		$mode = $conf->get('select_mode');
		$show_clearlink = $conf->get('show_clearlink');
		$translate = $conf->get('translate');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;
		$filtersPerColumn = $conf->get('filters_per_column');

		$filterDataModel = CPFactory::getFilterDataModel();
		$units = $filterDataModel->currentParameterUnits();

		if (empty($filtersCollection))
			return;

		if ($mode == CP_SINGLE_SELECT_MODE) {
			echo '<ul class="cp-dd-list">';
			foreach ($filtersCollection['filters'] as $k => $filter) {

				if ($filtersPerColumn && ($k % $filtersPerColumn) == 0) echo '</ul><ul class="cp-dd-list">';

				if ($filter['count']) {
					$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
					if ($units) $filterName .= $units;

					echo '<li><a href="'. $filter['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-filter-filter">'. $filterName .'</span> ';
					if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
					echo '</a></li>';
				}
			}

			echo '</ul>';

		} else {
			if ($show_clearlink && isset($filtersCollection['xurl']) && !empty($filtersCollection['xurl'])) {
				echo '<div><a href="'. $filtersCollection['xurl'] .'" class="cp-clearlink">'. $conf->get('clear') .'</a></div>';
				echo '<div class="clear"></div>';
			}

			echo '<ul class="cp-dd-list">';

			foreach ($filtersCollection['filters'] as $k => $filter) {

				if ($filtersPerColumn && ($k % $filtersPerColumn) == 0) echo '</ul><ul class="cp-dd-list">';

				$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
				if ($units) $filterName .= $units;

				if ($filter['count']) {
					if ($filter['applied']) {
						echo '<li><a href="'. $filter['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected">'. $filterName .'</span></a></li>';
					} else {
						echo '<li><a href="'. $filter['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter">'. $filterName .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $filter['count'] .')</span>';
						echo '</a></li>';
					}
				} else if ($filter['applied']) {
					echo '<li><span class="cp-dd-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $filterName .'</span></li>';
				}
			}
		}


	}


	private function printParameterFiltersForSimpleDropdownList($filtersCollection) {

		$conf = CPFactory::getConfiguration();
		$chooseLabel = $conf->get('simpledropdown_choose');
		$translate = $conf->get('translate');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;
		$filterDataModel = CPFactory::getFilterDataModel();
		$parameterTitle = $filterDataModel->currentParameterTitle();
		$units = $filterDataModel->currentParameterUnits();

		$firstOptionLabel = $chooseLabel .' '. $parameterTitle;

		echo '<option value="" class="cp-filter-option">'. $firstOptionLabel .'</option>';

		foreach ($filtersCollection['filters'] as $k => $filter) {
			if ($filter['count']) {
				$filterName = ($translate) ? JText::_($filter['name']) : $filter['name'];
				if ($units) $filterName .= $units;

				$selected = ($filter['applied']) ? ' selected' : '';

				echo '<option value="'. htmlentities($filter['name'], ENT_QUOTES, "UTF-8") .'"'.
					$selected .' class="cp-filter-option">'. $filterName;

				if ($showCount && !$selected) echo ' ('. $filter['count'] .')';

				echo '</option>';

			}
		}
	}



	// -----------------------------------------------------------------------------
	// Methods for AJAX queries for MANUFACTURERS for different Layouts
	// like Drop-down or Simple Drop-down.
	// Originally, we could have shown just emply boxes without filters.
	// ------------------------------------------------------------------------------


	public function printMCManufacturers($manufacturersCollection) {
		$conf = CPFactory::getConfiguration();
		switch ($conf->get('layout')) {
			case 2:
				$this->printManufacturersForDropdownList($manufacturersCollection);
				break;

			case 3:
				$this->printManufacturersForSimpleDropdownList($manufacturersCollection);
				break;

			default:
				$this->printManufacturersForDropdownList($manufacturersCollection);
				break;
		}
	}


	private function printManufacturersForDropdownList($manufacturersCollection) {
		$conf = CPFactory::getConfiguration();
		$mode = $conf->get('select_mode');
		$show_clearlink = $conf->get('show_clearlink');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;
		$filtersPerColumn = $conf->get('filters_per_column');

		if (empty($manufacturersCollection) || !($mf_category = $manufacturersCollection[0]))
			return;


		if ($mode == CP_SINGLE_SELECT_MODE) {
			echo '<ul class="cp-dd-list">';
			foreach ($mf_category['mfs'] as $k => $mf) {
				if ($filtersPerColumn && ($k % $filtersPerColumn) == 0)
					echo '</ul><ul class="cp-dd-list">';

				if ($mf['count']) {
					echo '<li><a href="'. $mf['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-filter-filter">'. $mf['name'] .'</span> ';
					if ($showCount) echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
					echo '</a></li>';
				}
			}

			echo '</ul>';

		} else {
			if ($show_clearlink && isset($mf_category['xurl']) && !empty($mf_category['xurl'])) {
				echo '<div><a href="'. $mf_category['xurl'] .'" class="cp-clearlink">'.
					$conf->get('clear') .'</a></div>';
				echo '<div class="clear"></div>';
			}

			echo '<ul class="cp-dd-list">';

			foreach ($mf_category['mfs'] as $k => $mf) {
				if ($filtersPerColumn && ($k % $filtersPerColumn) == 0)
					echo '</ul><ul class="cp-dd-list">';

				if ($mf['count']) {
					if ($mf['applied']) {
						echo '<li><a href="'. $mf['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox selected"> </span> '.
						'<span class="cp-filter-filter selected">'. $mf['name'] .'</span></a></li>';
					} else {
						echo '<li><a href="'. $mf['url'] .'" class="cp-dd-filter-link">'.
						'<span class="cp-dd-filter-checkbox"> </span> '.
						'<span class="cp-filter-filter">'. $mf['name'] .'</span> ';
						if ($showCount) echo '<span class="cp-filter-count">('. $mf['count'] .')</span>';
						echo '</a></li>';
					}
				} else if ($mf['applied']) {
					echo '<li><span class="cp-dd-filter-checkbox unavailable"> </span> '.
					'<span class="cp-filter-filter unavailable">'. $mf['name'] .'</span></li>';
				}
			}
		}
	}


	private function printManufacturersForSimpleDropdownList($manufacturersCollection) {
		$conf = CPFactory::getConfiguration();
		$manufacturers = CPFactory::getManufacturersDataModel();
		$chooseLabel = $conf->get('simpledropdown_choose');
		$showCount = ($conf->get('filter_count') == PROD_COUNT_SHOW) ? true : false;

		$mf_category = $manufacturersCollection[0];
		$firstOptionLabel = $chooseLabel .' '. $mf_category['mfc_name'];

		echo '<option value="" class="cp-filter-option">'. $firstOptionLabel .'</option>';

		foreach ($mf_category['mfs'] as $k => $mf) {
			if ($mf['count']) {
				$selected = ($mf['applied']) ? ' selected' : '';

				echo '<option value="'. htmlentities($mf['name'], ENT_QUOTES, "UTF-8") .'"'.
					$selected .' class="cp-filter-option">'. $mf['name'];

				if ($showCount && !$selected) echo ' ('. $mf['count'] .')';

				echo '</option>';

			}
		}
	}

}

?>
