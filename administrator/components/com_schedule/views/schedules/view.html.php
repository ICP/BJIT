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

/**
 * View class for a list of Schedule.
 *
 * @since  1.6
 */
class ScheduleViewSchedules extends JViewLegacy {

	protected $items;

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
		$context = "schedule.list.admin.schedules";
		$this->items = [];
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$this->addToolbar();

		parent::display($tpl);

		$this->setDocument();
	}

	protected function setDocument() {
		$document = JFactory::getDocument();
		$document->setTitle('Schedules');
		$document->addStyleSheet(JURI::base() . 'components/com_schedule/assets/css/toastr.min.css');
		$document->addStyleSheet(JURI::base() . 'components/com_schedule/assets/css/select2.min.css');
		$document->addStyleSheet(JURI::base() . 'components/com_schedule/assets/css/schedule.css');
		$document->addScriptDeclaration('var base = "' . JUri::root() . '";');
		$document->addScriptDeclaration('var today = "' . date('Y-m-d', time()) . '";');
		$document->addScript(JURI::base() . 'components/com_schedule/assets/js/toastr.min.js');
		$document->addScript(JURI::base() . 'components/com_schedule/assets/js/select2.full.min.js');
		$document->addScript(JURI::base() . 'components/com_schedule/assets/js/schedule.js');
		$document->addScript(JURI::base() . 'components/com_schedule/assets/js/jquery.maskedinput.min.js');
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar() {
		$state = $this->get('State');
		$canDo = ScheduleHelpersSchedule::getActions();

		JToolBarHelper::title(JText::_('COM_SCHEDULE_TITLE_SCHEDULES'), 'schedule.png');
		

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/schedule';

		if (file_exists($formPath)) {
			if ($canDo->get('core.create')) {
//				JToolBarHelper::addNew('schedule.add', 'JTOOLBAR_NEW');
//				JToolbarHelper::custom('schedules.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
//				JToolbarHelper::link('#link', 'JTOOLBAR_NEW');
			}
		}
/*
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_schedule');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_schedule&view=schedules');

		$this->extra_sidebar = '';
		 */
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields() {
		return array(
		);
	}

}
