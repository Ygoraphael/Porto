<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPModuleController {

	public function run() {

		$conf = CPFactory::getConfiguration();
		$this->shouldRunInLegacyMode();
		$conf->set('legacy_mode', $this->shouldRunInLegacyMode());

		// Checkbox List layout always works in Multi select mode
		if ($conf->get('layout') == CP_LAYOUT_CHECKBOX_LIST) $conf->set('select_mode', CP_MULTI_SELECT_MODE);

		// Force Simple Drop-down layout to work always in Multi select mode
		if ($conf->get('layout') == CP_LAYOUT_SIMPLE_DROPDOWN) $conf->set('select_mode', CP_MULTI_SELECT_MODE);
		
		// $productTypeIds = ($conf->get('display_mode') == CP_SHOW_SPECIFIC_PTS) ? $conf->get('ptids') : '';
		$filterDataModel = CPFactory::getFilterDataModel();
		$filterDataModel->initFiltersData();
		
		if (!$filterDataModel->thereAreFiltersToShow()) {
			if ($filterDataModel->checkThereAreFiltersApplied()) {
				$filterDataModel->showDialogToRemoveFilterSelection();
			}

			if ($conf->get('do_not_show_up_if_no_filters')) return;
			$totalProducts = $filterDataModel->getTotalProductsCount();
			if ($totalProducts == 0) return;
		}

		$filterModel = CPFactory::getFilterModel();
		$filtersCollection = $filterModel->getFiltersCollection();

		if (empty($filtersCollection) && $conf->get('do_not_show_up_if_no_filters')) return;


		$filterWriter = CPFactory::getFilterWriter();
		$filterWriter->printFilters($filtersCollection);


		if ($conf->get('fill_metatitle')) $filterModel->fillMetaTitle();
		if ($conf->get('add_robots_noindex')) $filterModel->addNoindexMeta();


		
		// unset($filtersCollection);

	}


	public function shouldRunInLegacyMode() {
		$db = JFactory::getDBO();

		$q = "SHOW TABLES LIKE '%_vm_product_type_parameter%'";
		$db->setQuery($q);
		$tableExists = $db->loadResult();

		return $tableExists ? true : false;

//		$config = JFactory::getConfig();
//
//		$q = "SELECT * FROM INFORMATION_SCHEMA.TABLES
//			WHERE table_name = '". $config->getValue('config.dbprefix') ."vm_product_type'
//			AND table_schema = '". $config->getValue('config.db') ."'";
//		$db->setQuery($q);
//		$exists = $db->loadResult();
//
//		return $exists ? true : false;
	}


}
