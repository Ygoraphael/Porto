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


jimport('joomla.application.component.modellist');


class JUFormModelDashboard extends JModelList
{
	
	protected function getListQuery()
	{
		return true;
	}

	public function getSubmissionData($type = 'day')
	{
		$db     = $this->getDbo();
		$config = JFactory::getConfig();
		$user   = JFactory::getUser();
		
		$date = JFactory::getDate('now', 'UTC');
		
		$date->setTimeZone(new DateTimeZone($user->getParam('timezone', $config->get('offset'))));

		$data = array();
		
		switch ($type)
		{
			case 'day':
				$date->add(new DateInterval("PT1H"));
				$dateTimeStr = $date->format('Y-m-d H:00:00');

				for ($i = 24; $i >= 1; $i--)
				{
					$query = $db->getQuery(true);
					$query->select('COUNT(*) AS value')
						->select('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' HOUR) AS today')
						->from('#__juform_submissions AS submission')
						->where('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' HOUR) < submission.created')
						->where('submission.created <= DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . ($i - 1) . ' HOUR)');
					$db->setQuery($query);
					$upload = $db->loadObject();

					$_date = JFactory::getDate($upload->today, 'UTC');
					$_date->setTimezone(new DateTimeZone($user->getParam('timezone', $config->get('offset'))));

					
					$hour = $_date->format('H', true, false);
					$day  = $_date->format('d', true, false);

					$dataRow   = array();
					$dataRow[] = $hour == 0 ? ($hour . 'h/' . $day) : $hour . 'h';
					$dataRow[] = $upload->value ? $upload->value : 0;

					$data[] = $dataRow;
				}
				break;

			case 'week':
				$currentDay = $date->format('w', true, false);
				$date->add(new DateInterval("P1D"));
				$dateTimeStr = $date->format('Y-m-d 00:00:00');

				for ($i = 6; $i >= 0; $i--)
				{
					$query = $db->getQuery(true);
					$query->select('COUNT(*) AS value')
						->from('#__juform_submissions AS submission')
						->where('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' DAY) < submission.created')
						->where('submission.created <= DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . ($i - 1) . ' DAY)');

					$db->setQuery($query);
					$upload = $db->loadObject();

					$day = (($currentDay - $i) + 7) % 7;

					$dataRow   = array();
					$dataRow[] = $date->dayToString($day);
					$dataRow[] = $upload->value ? $upload->value : 0;

					$data[] = $dataRow;
				}
				break;

			case 'month':
				$day = $date->format('t');
				$date->add(new DateInterval("P1D"));
				$dateTimeStr = $date->format('Y-m-d 00:00:00');
				for ($i = $day; $i >= 1; $i--)
				{
					$query = $db->getQuery(true);
					$query->select('COUNT(*) AS value')
						->select('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' DAY) AS today')
						->from('#__juform_submissions AS submission')
						->where('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' DAY) < submission.created')
						->where('submission.created <= DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . ($i - 1) . ' DAY)');

					$db->setQuery($query);
					$upload = $db->loadObject();

					$_date = JFactory::getDate($upload->today, 'UTC');
					$_date->setTimezone(new DateTimeZone($user->getParam('timezone', $config->get('offset'))));

					
					$day   = $_date->format('d', true, false);
					$month = $_date->format('m', true, false);

					$dataRow   = array();
					$dataRow[] = $day == 1 ? ($day . '/' . $month) : $day;
					$dataRow[] = $upload->value ? $upload->value : 0;

					$data[] = $dataRow;
				}
				break;

			case 'year':
				$date = JFactory::getDate();
				$date->add(new DateInterval("P1M"));
				$dateTimeStr = $date->format('Y-m-01 00:00:00');
				for ($i = 12; $i >= 1; $i--)
				{
					$query = $db->getQuery(true);
					$query->select('COUNT(*) AS value')
						->select('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' MONTH) AS today')
						->from('#__juform_submissions AS submission')
						->where('DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . $i . ' MONTH) < submission.created')
						->where('submission.created <= DATE_SUB("' . $dateTimeStr . '", INTERVAL ' . ($i - 1) . ' MONTH)');

					$db->setQuery($query);
					$upload = $db->loadObject();

					$_date = JFactory::getDate($upload->today, 'UTC');
					$_date->setTimezone(new DateTimeZone($user->getParam('timezone', $config->get('offset'))));

					

					$month = $_date->format('m', true, false);
					$year  = $_date->format('Y', true, false);

					$dataRow   = array();
					$dataRow[] = $month == 1 ? ($month . '/' . $year) : $month;
					$dataRow[] = $upload->value ? $upload->value : 0;

					$data[] = $dataRow;
				}
				break;
		}

		return $data;
	}

	public function getForms($type, $limit = 5)
	{
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		$query->SELECT("form.id, form.title, form.created, form.modified, form.published, form.checked_out, form.checked_out_time");
		$query->FROM("#__juform_forms AS form");
		$query->SELECT("ua1.name AS checked_out_name");
		$query->JOIN("LEFT", "#__users AS ua1 ON ua1.id = form.checked_out");
		switch ($type)
		{
			case "lastCreatedForms" :
				$query->SELECT("ua.name AS created_by_name");
				$query->JOIN("LEFT", "#__users AS ua ON ua.id = form.created_by");
				$query->ORDER("form.created DESC LIMIT 0, $limit");
				break;

			case "lastModifiedForms" :
				$query->SELECT("ua.name AS modified_by_name");
				$query->JOIN("LEFT", "#__users AS ua ON ua.id = form.modified_by");
				$query->WHERE("form.modified > '0000-00-00 00:00:00'");
				$query->ORDER("form.modified DESC LIMIT 0, $limit");
				break;
		}
		
		$query->WHERE("form.published != -1");
		$db->setQuery($query);
		$data = $db->loadObjectList();

		return $data;
	}

	public function getStatistics()
	{
		$db     = $this->getDbo();
		$static = array();

		$query = $db->getQuery(true);
		$query->SELECT("COUNT(*)");
		$query->FROM("#__juform_forms");
		$db->setQuery($query);
		$total                                = $db->loadResult();
		$static[JText::_('COM_JUFORM_FORMS')] = $total;

		$query = $db->getQuery(true);
		$query->SELECT("COUNT(*)");
		$query->FROM("#__juform_submissions");
		$db->setQuery($query);
		$total                                      = $db->loadResult();
		$static[JText::_('COM_JUFORM_SUBMISSIONS')] = $total;

		return $static;
	}
}
