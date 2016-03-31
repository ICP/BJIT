<?php
/**
 * @version		$Id$
 * @package		Simple Image Gallery Pro
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2015 JoomlaWorks Ltd. All rights reserved.
 * @license		http://www.joomlaworks.net/license
 */

defined('_JEXEC') or die ;

jimport('joomla.application.component.model');

if (version_compare(JVERSION, '3.0', 'ge'))
{
	class SigProModel extends JModelLegacy
	{
	}

}
else
{
	class SigProModel extends JModel
	{
	}

}
