<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class FSAssignFiltersView {

	private $pid;
	private $ptid;

	static private $currentRowId;
	static private $currentNewProductTypeIndex = 0;

	static private $addPopupMenuHandlerJavascript = false;
	static private $addBasicEventsHandlerJavascript = false;
	static private $addProductDetailsSupportJavascript = false;
	static private $addOnLoadEventJavascript = false;


	static public function printFiltersAssignPage() {

		self::printSearchBar();
		self::printRefinePane();


		self::$addPopupMenuHandlerJavascript = true;
		self::$addBasicEventsHandlerJavascript = true;

		echo '<div id="productsAndNavigation">';

		self::printProductDetailsAndPageNavigation();

		echo '</div>';

		//self::loadJavascript();
	}


	static private function printSearchBar() {

		require(FS_PATH .'views/FSAssignFilters/tmpl/searchBar.php');

	}


	static private function printRefinePane() {

		require(FS_PATH .'views/FSAssignFilters/tmpl/refinePane.php');

	}


	static public function printProductDetailsAndPageNavigation() {

		$productsData = FSAssignFiltersModel::getProductsData();

		self::printProductsCountUpdateScript();
		self::printProductsDetails($productsData);


		echo '<div id="pageNavigation">';

		self::printPageNavigation();

		echo '<div style="margin-top:5px;color:#CCCCCC;font-size:11px;">Executed in: '.
			round(FSAssignFiltersModel::getExecuteTime(), 5) .' seconds</div>';
		echo '</div>';

		self::$addProductDetailsSupportJavascript = true;
		self::$addOnLoadEventJavascript = true;
		self::loadJavascript();
	}


	static private function printProductsDetails($productsData) {

		require(FS_PATH .'views/FSAssignFilters/tmpl/productDetails.php');

	}


	static private function printPageNavigation() {

		require(FS_PATH .'views/FSAssignFilters/tmpl/pageNavigation.php');

	}


	static private function printProductsCountUpdateScript() {

		$productsCount = FSAssignFiltersModel::getProductsCount();

		$content = ($productsCount==0) ? "'Matches nothing'" :
			( ($productsCount == 1) ? "'Matches 1 product'" : "'Matches $productsCount products'" );

		echo '<script type="text/javascript">';
		echo "$('productsFound').innerHTML=". $content .";";
		echo '</script>';

	}


	static public function getProductFilterData($assignedFilters) {

		require(FS_PATH .'views/FSAssignFilters/tmpl/productFilterData.php');

		return $cont;
	}


	static public function getProductTypesSelectContainer() {

		require(FS_PATH .'views/FSAssignFilters/tmpl/productTypesData.php');

		return $cont;
	}



	static private function loadJavascript() {

		$pts = FSAssignFiltersModel::getAvailableProductTypes();
		$ptDataJs = "var productTypesData = []\n";
		foreach ($pts as $pt) {
			$ptDataJs .= "productTypesData[". $pt['id'] ."] = '".
				htmlentities($pt['name'], ENT_QUOTES, "UTF-8") ."';\n";
		}

		echo '<script type="text/javascript">';
		echo "var fsBaseURL = '". FS_URL ."';\n";
		echo "var filterInputBoxDefaultMaxWidth = 340;\n";
		echo "var showProductDescriptionButton=". FSConf::get('show_pdesc_button') .";\n";
		echo $ptDataJs;


		if (self::$addPopupMenuHandlerJavascript) {
			echo "\n";
			require(FS_PATH .'static/js/popupMenuHandler.js');
			echo "var simplePopup = new popMenuHandler();\n";
			//echo "var activeParamButton = null;\n";
		}


		if (self::$addBasicEventsHandlerJavascript) {
			echo "\n";
			require(FS_PATH .'static/js/refinePaneEvents.js');
			require(FS_PATH .'static/js/assignPage_basicEvents.js');
		}


		if (self::$addProductDetailsSupportJavascript) {
			echo "\n";
			echo "var currentNewProductTypeIndex = ". self::$currentNewProductTypeIndex .";\n";
			echo "var newPTContHTML = '". self::getProductTypesSelectContainer() ."';\n";
			echo "var currentTotalRows = $$('.fs-row').length;\n";
		}

		if (self::$addOnLoadEventJavascript) {
			require(FS_PATH .'static/js/assignPage_onloadEvents.js');
		}


		echo '</script>';

	}


	static public function printAvailableFiltersForParameter($filtersStr) {
		// return just the string of filters. Do the work on client site for better performance
		echo $filtersStr;
		return;

		// if (!$filtersStr) {
		//	echo '<div style="font:italic 11px Arial, Tahoma;color:#777777;margin:10px 0 0 0;text-align:center;">None yet.<br/> '.
		//		'Start assigning filters by typing a filter name and hitting <b>Enter</b> on the keyboard.</div>';

		//	return;
		// }

		// require(FS_PATH .'views/FSAssignFilters/tmpl/availableFiltersForParameter.php');

	}


	static public function printCategoriesTree($categoriesData) {

		require(FS_PATH .'views/FSAssignFilters/tmpl/categoriesTree.php');

	}


	static public function printProductTypesList($ptsData) {

		require(FS_PATH .'views/FSAssignFilters/tmpl/productTypesList.php');

	}


	static public function printProductDescription($productData) {

		require(FS_PATH .'views/FSAssignFilters/tmpl/productDescriptionInPopup.php');

	}


	static public function squeeze($string, $characters = 24) {

		if (function_exists('mb_strlen')) {
			$len = mb_strlen($string, 'UTF-8');
		} else {
			$len = strlen($string);
		}

		if ($len > $characters) {

			if (function_exists('mb_substr')) {
				$substring = mb_substr($string, 0, $characters, 'UTF-8');
			} else {
				$substring = substr($string, 0, $characters);
			}

			$string = $substring .'<b class="threedots">..</b>';
		}

		return $string;
	}



	//

	static public function setCurrentRow($id) {
		self::$currentRowId = $id;
	}

	static public function getCurrentRow() {
		return self::$currentRowId;
	}

	static public function getNextNewProductTypeIndex() {
		self::$currentNewProductTypeIndex++;
		return self::$currentNewProductTypeIndex;
	}

	static public function getCurrentNewProductTypeIndex() {
		return self::$currentNewProductTypeIndex;
	}


}
