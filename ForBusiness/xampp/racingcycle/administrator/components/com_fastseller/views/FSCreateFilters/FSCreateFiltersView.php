<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSCreateFiltersView {

	static private $addPTManagePageJavascript = false;
	static private $addParametersManagePageJavascript = false;

	
	static public function printProductTypesPage($ptData) {

		require(FS_PATH .'views/FSCreateFilters/tmpl/productTypesPage.php');

		self::$addPTManagePageJavascript = true;
		self::loadJavascript();
	}


	static public function printSelectedProductTypeParameters() {

		require(FS_PATH .'views/FSCreateFilters/tmpl/ptParametersPage.php');

		self::$addParametersManagePageJavascript = true;
		self::loadJavascript();
	}


	static public function printParameterForm($parameter = null, $tabIndex = null) {
		require(FS_PATH .'views/FSCreateFilters/tmpl/parameterForm.php');		
	}


	static private function loadJavascript() {

		echo '<script type="text/javascript">';

		if (self::$addPTManagePageJavascript) {
			echo "var productTypesCount=". FSCreateFiltersModel::productTypesCount() .";\n";
			require(FS_PATH .'static/js/createFilters_PTEvents.js');
		}

		if (self::$addParametersManagePageJavascript) {
			$otherParameterNames = FSCreateFiltersModel::getOtherParameterNames();
			$otherParameterNamesStr = '';
			if ($otherParameterNames) {
				$otherParameterNamesStr = '"'. implode('", "', $otherParameterNames) .'"';
			}
			
			echo "var currentTabIndex=0;\n";
			echo "var generalNumberOfTabs=document.getElementById('ptpNavTabs').getChildren().length;\n";
			echo "var otherParameterNames = [". $otherParameterNamesStr ."]\n";
	
			require(FS_PATH .'static/js/createFilters_ParametersEvents.js');
		}

		echo '</script>';

	}

}

?>