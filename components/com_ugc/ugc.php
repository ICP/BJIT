<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Ugc
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Ugc', JPATH_COMPONENT);
JLoader::register('UgcController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Ugc');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
