<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Schedule
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Schedule', JPATH_COMPONENT);
JLoader::register('ScheduleController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Schedule');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
