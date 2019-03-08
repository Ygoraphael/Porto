<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class CPFactory {

	private static $_moduleController = null;
	private static $_filterDataModel = null;
	private static $_filterModel = null;
	private static $_filterWriter = null;
	private static $_filterConfiguration = null;
	private static $_manufacturersDataModel = null;


	// public static function initFactory() {
	// 	self::$_filterDataModel = null;
	// 	self::$_filterModel = null;
	// 	self::$_filterWriter = null;
	// 	self::$_filterConfiguration = null;
	// }


	public static function getModuleController() {
		require_once(CP_ROOT .'controllers/CPModuleController.php');
		
		if (self::$_moduleController) {
			return self::$_moduleController;
		} else {
			$instance = new CPModuleController();
			self::$_moduleController = $instance;
			return $instance;
		}
	}


	public static function getFilterDataModel() {
		require_once(CP_ROOT .'models/filterData.php');

		if (self::$_filterDataModel) {
			return self::$_filterDataModel;
		} else {
			$instance = new CPFilterData();
			self::$_filterDataModel = $instance;
			return $instance;
		}
	}


	public static function getFilterModel() {
		require_once(CP_ROOT .'models/filterModel.php');

		if (self::$_filterModel) {
			return self::$_filterModel;
		} else {
			$instance = new CPFilterModel();
			self::$_filterModel = $instance;
			return $instance;
		}
	}


	public static function getFilterWriter() {
		require_once(CP_ROOT .'views/filterWriter.php');

		if (self::$_filterWriter) {
			return self::$_filterWriter;
		} else {
			$instance = new CPFilterWriter();
			self::$_filterWriter = $instance;
			return $instance;
		}
	}


	public static function getConfiguration() {
		require_once(CP_ROOT .'models/filterConfiguration.php');

		if (self::$_filterConfiguration) {
			return self::$_filterConfiguration;
		} else {
			$instance = new CPFilterConfiguration();
			self::$_filterConfiguration = $instance;
			return $instance;
		}
	}


	public static function getManufacturersDataModel() {
		require_once(CP_ROOT .'models/manufacturersData.php');

		if (self::$_manufacturersDataModel) {
			return self::$_manufacturersDataModel;
		} else {
			$instance = new CPManufacturersData();
			self::$_manufacturersDataModel = $instance;
			return $instance;
		}
	}


	public static function releaseObjects() {
		self::$_moduleController = null;
		self::$_filterDataModel = null;
		self::$_filterModel = null;
		self::$_filterWriter = null;
		self::$_filterConfiguration = null;
		self::$_manufacturersDataModel = null;
	}

}