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

jimport('joomla.application.component.modeladmin');

class JUFormModelCsvprocess extends JModelAdmin
{
	public $messages = array();

	public $ignoredFields = array('checked_out', 'checked_out_time');

	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		
		$form = $this->loadForm('com_juform.csvexport', 'csvexport', array('control' => 'jform', 'load_data' => $loadData), true);
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	public function getFields()
	{
		$app    = JFactory::getApplication();
		$formId = $app->getUserState('csv.exportFormId', '');
		if (!$formId)
		{
			return null;
		}

		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select('field.*, plg.folder');
		$query->from('#__juform_fields AS field');
		$query->join('', '#__juform_plugins AS plg ON plg.id = field.plugin_id');
		$query->where('field.form_id = ' . $formId);
		$query->order('field.ordering');

		$db->setQuery($query);

		$_fields = $db->loadObjectList();
		$fields  = array();
		if ($_fields)
		{
			foreach ($_fields AS $field)
			{
				$fieldClass = JUFormFrontHelperField::getField($field);
				if ($fieldClass)
				{
					$fields[] = $fieldClass;
				}
			}
		}

		$submissionTable = JTable::getInstance('Submission', 'JUFormTable');
		$fieldNames      = $submissionTable->getProperties();
		foreach ($fieldNames AS $fieldName => $value)
		{
			if (in_array($fieldName, $this->ignoredFields))
			{
				continue;
			}

			$fields[] = $fieldName;
		}

		return $fields;
	}

	
	public function export()
	{
		
		$app               = JFactory::getApplication();
		$filter            = $app->input->post->get('jform', array(), 'array');
		$filter['form_id'] = $app->getUserState('csv.exportFormId');
		$exportColumns     = $app->input->post->get('col', array(), 'array');
		$file_name         = $filter['csv_export_file_name'] ? $filter['csv_export_file_name'] : "export_submissions";
		
		$data = $this->getExportData($exportColumns, $filter);

		
		JUFormHelper::obCleanData();
		$file_name = str_replace(' ', '_', $file_name) . "-" . date("Y-m-d") . ".csv";
		$this->downloadSendHeaders($file_name);

		echo chr(239) . chr(187) . chr(191); 
		$csv_data = $this->array2csv($data);
		echo $csv_data;
		exit;
	}

	
	public function getExportData($exportColumns, $filter)
	{
		$exportData = array();
		$start      = 0;
		$limit      = 0;
		if (isset($filter['csv_limit_export']) && $filter['csv_limit_export'])
		{
			if (strpos($filter['csv_limit_export'], ',') !== false)
			{
				list($start, $limit) = explode(',', $filter['csv_limit_export']);
			}
			else
			{
				$limit = (int) $filter['csv_limit_export'];
			}
		}

		
		$submissions = $this->getSubmissions($filter, $start, $limit);

		if (!empty($submissions))
		{
			foreach ($submissions AS $submission)
			{
				$data = array();
				foreach ($exportColumns AS $exportColumn)
				{
					if (is_numeric($exportColumn))
					{
						$field = JUFormFrontHelperField::getField($exportColumn, $submission);
						if ($field && $field->canExport())
						{
							$data[$field->getCaption(true) . ' [' . $field->id . ']'] = $field->onExport();
						}
					}
					elseif (isset($submission->$exportColumn))
					{
						$data[$exportColumn] = $submission->$exportColumn;
					}
				}

				$exportData[] = $data;
			}
		}

		$columns = array_keys($exportData[0]);
		array_unshift($exportData, $columns);

		return $exportData;
	}

	
	protected function getSubmissions($filter, $start, $limit)
	{
		$db = $this->getDbo();

		


		
		$query = $db->getQuery(true);
		$query->select('submission.*')
			->from("#__juform_submissions AS submission")
			->where('submission.form_id = ' . $filter['form_id']);

		
		$offset = JFactory::getUser()->getParam('timezone', JFactory::getConfig()->get('offset'));
		if (!empty($filter['csv_created_from_filter']))
		{
			$time = JFactory::getDate($filter['csv_created_from_filter'], $offset)->toSql();
			$query->where('submission.created >= ' . $db->quote($time));
		}

		if (!empty($filter['csv_created_to_filter']))
		{
			$time = JFactory::getDate($filter['csv_created_to_filter'], $offset)->toSql();
			$query->where('submission.created <= ' . $db->quote($time));
		}

		$query->order('submission.id ASC');

		$query->group('submission.id');

		$db->setQuery($query, $start, $limit);

		return $db->loadObjectList();
	}

	public function downloadSendHeaders($filename)
	{
		
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}

	
	public function array2csv($data, $path = 'php://output', $mode = 'w')
	{
		if (count($data) == 0)
		{
			return null;
		}

		ob_start();

		$file = fopen($path, $mode);

		

		foreach ($data AS $row)
		{
			fputcsv($file, $row);
		}

		fclose($file);

		return ob_get_clean();
	}

	public function getFormOptions()
	{
		
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('id AS value, title AS text');
		$query->from('#__juform_forms');
		$query->where('published != -1');
		$query->order('id ASC');

		$db->setQuery($query);

		return $db->loadObjectList();
	}
}