<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Ugc
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_ugc'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Ugc', JPATH_COMPONENT_ADMINISTRATOR);

$controller = JControllerLegacy::getInstance('Ugc');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
