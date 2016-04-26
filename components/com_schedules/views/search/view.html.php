<?php
/**
 * @version     1.0.0
 * @package     com_schedules
 * @copyright   Copyright (C) 2012,  Pooya TV. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid Roshan <faridv@gmail.com> - http://www.faridr.ir
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Schedules.
 */
class SchedulesViewSearch extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $params;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app                = JFactory::getApplication();
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->params       = $app->getParams('com_schedules');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
		        throw new Exception(implode("\n", $errors));
		}

        	$this->_prepareDocument();
        
		parent::display($tpl);
	}
	
	public function convertJalali($date) {
		list($y, $m, $d) = explode('-', $date);
		$jalali = gregorian_to_jalali($y, $m, $d, '-');
		list($y, $m, $d) = explode('-', $jalali);
		if ((int)$m < 10) $m = '0' . $m;
		if ((int)$d < 10) $d = '0' . $d;
		$output = $y . '-' . $m . '-' . $d;
		return $output;
	}

	public function handlePrograms($jsonEncodedPrograms, $keyword) {
		$items = json_decode($jsonEncodedPrograms);
		$data = array();
		foreach ($items as $item) {
			if (stristr($item->name, $keyword)) {
				$data[] = $item;
			}
		}
		return $data;
	}

	public function getKind($name) {
		$kinds = array('armstation' => 'وله و آرم', 'internal' => 'داخلی', 'foreigner' => 'خارجی', 'azaan' => 'اذانگاهی', 'film' => 'فیلم سینمایی', 'lullaby' => 'لالایی', 'provinces' => 'سیمای استان‌ها', 'movies' => 'سینمایی', 'persian-series' => 'مجموعه ایرانی', 'foreigner-series' => 'مجموعه خارجی', 'prayer-time' => 'قرآن و اذان', 'armstations' => 'آرم استیشن', 'musical' => 'کلیپ موزیکال', 'announces' => 'تیزر و آنونس', 'specials' => 'ویژه برنامه ها', 'commercials' => 'آگهی بازرگانی');
		return $kinds[$name];
	}


	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('com_schedules_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}    
    	
}
