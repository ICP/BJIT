<?php
/**
 * @version		3.0.x
 * @package		Simple Image Gallery Pro
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2015 JoomlaWorks Ltd. All rights reserved.
 * @license		http://www.joomlaworks.net/license
 */

// no direct access
defined('_JEXEC') or die ;

class SigProViewMedia extends SigProView
{

	public function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		//$mainframe->enqueueMessage(JText::_('COM_SIGPRO_MEDIA_MANAGER_INFO'));
		parent::display($tpl);
	}

}
