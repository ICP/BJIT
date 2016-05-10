<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Schedule
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php');
require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'utilities.php');
require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_k2' . DS . 'models' . DS . 'model.php');

/**
 * View class for a list of Schedule.
 *
 * @since  1.6
 */
class ScheduleViewSchedule extends JViewLegacy {

//	protected $items;

	protected $pagination;
	protected $state;
	protected $params;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null) {
		$app = JFactory::getApplication();

		$this->state = $this->get('State');
		$this->params = $app->getParams('com_schedule');


		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}

		$this->_prepareDocument();
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function _prepareDocument() {
		$app = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_SCHEDULE_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title)) {
			$title = $app->get('sitename');
		} elseif ($app->get('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		} elseif ($app->get('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description')) {
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords')) {
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots')) {
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}

	/**
	 * Check if state is set
	 *
	 * @param   mixed  $state  State
	 *
	 * @return bool
	 */
	public function getState($state) {
		return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}

	public function getItems($date = null) {
//		$date = ($date) ? self::convertDate($date) : date('Y-m-d', time());
		$path = JUri::root() . 'api/schedules/' . $date;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $path);
		$result = curl_exec($ch);
		curl_close($ch);

		return $items = (count(json_decode($result)->items)) ? $this->prepareItems(json_decode($result)->items) : [];
	}

	public static function prepareItems($items) {
		if (!count($items))
			return [];
		foreach ($items as $item) {
			$item->link = '';
			$item->image = '';
			$item->thumb = '';
			if ($item->episode != 0 || $item->program_id) {
				if ($item->program_id) {
					$item->link = Route::category($item->program_id, $item->program_alias);
					$item->image = JURI::root() . 'media/k2/categories/' . $item->program_id . '.jpg';
					$item->thumb = JURI::root() . 'media/k2/categories/' . $item->program_id . '.jpg';
				}
				if ($item->episode != 0) {
					$item->link = Route::item($item->episode, $item->episode_alias, $item->program_id, $item->program_alias);
					$item->image = Route::image($item->episode);
					$item->thumb = Route::image($item->episode, true);
				}
			}
			$item->start_small = date('H:i', strtotime($item->start));
		}
		return $items;
	}
	
	static function convertDate($jalali) {
		new jDateTime(false);
		list($j_y, $j_m, $j_d) = explode('-', $jalali);
		$gregorian = jDateTime::toGregorian($j_y, $j_m, $j_d);
		return implode('-', $gregorian);
	}

}

if (!class_exists('Route')) {

	abstract class Route {

		public static function video($path) {
			$base = VIDEO_BASE;
			$url = str_replace('$old|', '', str_replace('{/mp4}', '', str_replace('{mp4}', '', $path)));
			return $base . $url;
		}

		public static function image($id, $thumb = false) {
			$path = JURI::root() . 'media/k2/items/cache/' . md5('Image' . $id);
			$path .= $thumb ? '_XS.jpg' : '_S.jpg';
			return str_replace('/api', '', $path);
		}

		public static function item($id, $alias, $catid, $catalias) {
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($id . ':' . urlencode($alias), $catid . ':' . urlencode($catalias))));
			return str_replace('/api', '', $link);
		}

		public static function category($id, $alias) {
			$link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($id . ':' . urlencode($alias))));
			return str_replace('/api', '', $link);
		}

	}

}