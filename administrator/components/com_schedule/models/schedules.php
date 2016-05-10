<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Schedule
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Schedule records.
 *
 * @since  1.6
 */
class ScheduleModelSchedules extends JModelList {

	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id',
				'greeting',
				'published'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null) {
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_schedule');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('id', 'desc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '') {
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
//	protected function getListQuery() {
//		$db = $this->getDbo();
//		$query = $db->getQuery(true);
//		$query->select("*")->from($db->quoteName('#__schedules'));
//
//		// Filter: like / search
//		$search = $this->getState('filter.search');
//
//		if (!empty($search)) {
//			$like = $db->quote('%' . $search . '%');
//			$query->where('title LIKE ' . $like);
//		}
//
//		$published = $this->getState('filter.published');
//
//		if (is_numeric($published)) {
//			$query->where('state = ' . (int) $published);
//		} elseif ($published === '') {
//			$query->where('(state IN (0, 1))');
//		}
//
//		return '';
//	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems() {
		$items = parent::getItems();

		return $items;
	}

}
